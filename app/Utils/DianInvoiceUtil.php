<?php

namespace App\Utils;

use App\Transaction;
use Carbon\Carbon;
use Stenfrank\UBL21dian\XAdES\SignInvoice;

class DianInvoiceUtil extends Util
{
    /**
     * Generate the signed UBL 2.1 XML for a sale.
     *
     * @param  int  $transaction_id
     * @return array ['xml' => string, 'cufe' => string]
     */
    public function generate($transaction_id)
    {
        $transaction = Transaction::with([
            'sell_lines.product',
            'sell_lines.line_tax',
            'sell_lines.variations',
            'contact',
            'location',
        ])->findOrFail($transaction_id);

        $invoice = $this->prepareData($transaction);

        // First pass: sign to obtain the CUFE, then embed it in the QR code and sign again.
        $invoice['qr_code'] = '';
        $first_xml = $this->render($invoice);
        $first_signed = $this->sign($first_xml);
        $cufe = $this->extractCufe($first_signed['xml']);

        $invoice['qr_code'] = $this->qrCodeUrl($cufe);
        $xml = $this->render($invoice);
        $signed = $this->sign($xml);

        return [
            'xml' => $signed['xml'],
            'cufe' => $cufe,
        ];
    }

    /**
     * Render the Blade view with the invoice data.
     *
     * @param  array  $invoice
     * @return string
     */
    protected function render($invoice)
    {
        return view('dian.invoice', ['invoice' => $invoice])->render();
    }

    /**
     * Sign the XML with the configured certificate.
     *
     * @param  string  $xml
     * @return array
     */
    protected function sign($xml)
    {
        $path = config('dian.certificate_path');
        $password = config('dian.certificate_password');

        if (empty($path) || empty($password)) {
            throw new \Exception(
                'Configure el certificado digital en el archivo .env ' .
                '(DIAN_CERTIFICATE_PATH y DIAN_CERTIFICATE_PASSWORD) antes de descargar el XML.'
            );
        }

        // Allow relative paths (resolved from the project root).
        if (!file_exists($path) && !\Illuminate\Support\Str::startsWith($path, ['/', '\\']) && !preg_match('/^[A-Za-z]:[\\\\\\/]/', $path)) {
            $path = base_path($path);
        }

        if (!file_exists($path)) {
            throw new \Exception("No se encontró el certificado digital en: {$path}");
        }

        $sign = new SignInvoice($path, $password);

        if (!empty(config('dian.software_id'))) {
            $sign->softwareID = config('dian.software_id');
        }
        if (!empty(config('dian.software_pin'))) {
            $sign->pin = config('dian.software_pin');
        }
        if (!empty(config('dian.technical_key'))) {
            $sign->technicalKey = config('dian.technical_key');
        }

        // The signing library reads $certs['extracerts'] (the CA chain). When a
        // certificate does not bundle a chain it emits a notice that Laravel
        // would turn into an exception. Ignore that specific notice.
        set_error_handler(function ($errno, $errstr) {
            return ($errno === E_NOTICE && stripos($errstr, 'extracerts') !== false);
        });
        try {
            $sign->sign($xml);
        } finally {
            restore_error_handler();
        }

        return ['xml' => $sign->xml];
    }

    /**
     * Build the invoice data array from a transaction.
     *
     * @param  \App\Transaction  $transaction
     * @return array
     */
    protected function prepareData($transaction)
    {
        $currency = config('dian.currency', 'COP');
        $default_tax = [
            'code' => config('dian.default_tax_code'),
            'name' => config('dian.default_tax_name'),
            'percent' => config('dian.default_tax_percent'),
        ];

        $lines = [];
        $tax_totals = [
            '01' => ['code' => '01', 'name' => 'IVA', 'percent' => $default_tax['percent'], 'taxable' => 0, 'amount' => 0],
            '04' => ['code' => '04', 'name' => 'INC', 'percent' => '0.00', 'taxable' => 0, 'amount' => 0],
            '03' => ['code' => '03', 'name' => 'ICA', 'percent' => '0.00', 'taxable' => 0, 'amount' => 0],
        ];

        $line_extension_sum = 0;
        $total_tax = 0;
        $i = 1;

        foreach ($transaction->sell_lines as $sell_line) {
            if ($sell_line->children_type == 'modifier') {
                continue;
            }

            $quantity = (float) $sell_line->quantity;
            $unit_price = (float) $sell_line->unit_price;
            $line_extension = $quantity * $unit_price;
            $item_tax = (float) $sell_line->item_tax;

            $code = $default_tax['code'];
            $name = $default_tax['name'];
            $percent = $default_tax['percent'];
            if (!empty($sell_line->line_tax)) {
                $percent = (float) $sell_line->line_tax->amount;
                $name = $sell_line->line_tax->name;
                $code = $this->mapTaxCode($name);
            }

            $taxes = [];
            if ($item_tax > 0 || (float) $percent > 0) {
                $taxes[] = [
                    'code' => $code,
                    'name' => $name,
                    'percent' => $this->formatAmount($percent),
                    'amount' => $this->formatAmount($item_tax),
                ];

                if (!isset($tax_totals[$code])) {
                    $tax_totals[$code] = ['code' => $code, 'name' => $name, 'percent' => $this->formatAmount($percent), 'taxable' => 0, 'amount' => 0];
                }
                $tax_totals[$code]['taxable'] += $line_extension;
                $tax_totals[$code]['amount'] += $item_tax;
            }

            $lines[] = [
                'id' => $i,
                'quantity' => $this->formatQuantity($quantity),
                'unit_code' => config('dian.unit_code'),
                'line_extension' => $this->formatAmount($line_extension),
                'tax_amount' => $this->formatAmount($item_tax),
                'description' => $sell_line->product ? $sell_line->product->name : '',
                'sku' => $sell_line->product ? $sell_line->product->sku : '',
                'price' => $this->formatAmount($unit_price),
                'taxes' => $taxes,
            ];

            $line_extension_sum += $line_extension;
            $total_tax += $item_tax;
            $i++;
        }

        $formatted_tax_totals = [];
        foreach ($tax_totals as $tax) {
            $formatted_tax_totals[] = [
                'code' => $tax['code'],
                'name' => $tax['name'],
                'percent' => is_string($tax['percent']) ? $tax['percent'] : $this->formatAmount($tax['percent']),
                'taxable' => $this->formatAmount($tax['taxable']),
                'amount' => $this->formatAmount($tax['amount']),
            ];
        }

        // Document level discount (allowance)
        $discount = (float) $transaction->discount_amount;
        if ($transaction->discount_type == 'percentage') {
            $discount = $transaction->total_before_tax * ($discount / 100);
        }
        $charge = (float) $transaction->shipping_charges;

        $payable = (float) $transaction->final_total;
        $tax_inclusive = $payable;
        $tax_exclusive = $tax_inclusive - $total_tax;
        $line_extension_total = $tax_exclusive + $discount - $charge;

        $date = Carbon::parse($transaction->transaction_date);

        return [
            'environment' => config('dian.environment'),
            'currency' => $currency,
            'resolution_number' => config('dian.resolution_number'),
            'resolution_prefix' => config('dian.resolution_prefix'),
            'resolution_from' => config('dian.resolution_from'),
            'resolution_to' => config('dian.resolution_to'),
            'resolution_start_date' => config('dian.resolution_start_date'),
            'resolution_end_date' => config('dian.resolution_end_date'),
            'software_id' => config('dian.software_id'),
            'provider_nit' => config('dian.software_provider_nit') ?: config('dian.supplier_nit'),
            'invoice_no' => $transaction->invoice_no,
            'issue_date' => $date->format('Y-m-d'),
            'issue_time' => $date->format('H:i:s') . '-05:00',
            'due_date' => ($transaction->pay_term_number && $transaction->pay_term_type) ?
                (clone $date)->add($transaction->pay_term_number, $transaction->pay_term_type)->format('Y-m-d') : '',
            'note' => $transaction->additional_notes,
            'qr_code' => '',
            'supplier' => $this->supplierData(),
            'customer' => $this->customerData($transaction),
            'tax_totals' => $formatted_tax_totals,
            'totals' => [
                'line_extension' => $this->formatAmount($line_extension_total),
                'tax_exclusive' => $this->formatAmount($tax_exclusive),
                'tax_inclusive' => $this->formatAmount($tax_inclusive),
                'allowance' => $this->formatAmount($discount),
                'charge' => $this->formatAmount($charge),
                'payable' => $this->formatAmount($payable),
            ],
            'lines' => $lines,
            'payment_means' => [
                'id' => '1',
                'code' => '10',
                'due_date' => '',
            ],
        ];
    }

    /**
     * Supplier (issuer) data from the DIAN configuration.
     *
     * @return array
     */
    protected function supplierData()
    {
        $nit = config('dian.supplier_nit');
        $dv = config('dian.supplier_dv');
        if (empty($dv) && !empty($nit)) {
            $dv = $this->calculateDv($nit);
        }

        return [
            'nit' => $nit,
            'dv' => $dv,
            'id_type' => config('dian.supplier_identification_type'),
            'person_type' => config('dian.supplier_person_type'),
            'name' => config('dian.supplier_name'),
            'regime' => config('dian.supplier_regime'),
            'email' => config('dian.supplier_email'),
            'phone' => config('dian.supplier_phone'),
            'address' => config('dian.supplier_address'),
            'city_code' => config('dian.supplier_city_code'),
            'city_name' => config('dian.supplier_city_name'),
            'state_name' => config('dian.supplier_state_name'),
            'state_code' => config('dian.supplier_state_code'),
        ];
    }

    /**
     * Customer data from the contact, with a final consumer fallback.
     *
     * @param  \App\Transaction  $transaction
     * @return array
     */
    protected function customerData($transaction)
    {
        $contact = $transaction->contact;

        $nit = '';
        $dv = '';
        $id_type = config('dian.customer_id_type');
        if ($contact && !empty($contact->tax_number)) {
            $parts = explode('-', $contact->tax_number);
            $nit = trim($parts[0]);
            if (isset($parts[1])) {
                $dv = trim($parts[1]);
            }
            $id_type = (strlen($nit) >= 9) ? '31' : '13';
        }

        if (empty($nit)) {
            $nit = config('dian.final_consumer_nit');
            $id_type = '13';
        }

        $name = $contact ? ($contact->name ?: $contact->supplier_business_name) : config('dian.final_consumer_name');
        if (empty($name)) {
            $name = config('dian.final_consumer_name');
        }

        return [
            'nit' => $nit,
            'dv' => $dv,
            'id_type' => $id_type,
            'person_type' => ($id_type == '31') ? '1' : '2',
            'name' => $name,
            'regime' => config('dian.customer_regime'),
            'email' => $contact ? $contact->email : '',
            'phone' => $contact ? $contact->mobile : '',
            'address' => $contact ? ($contact->address_line_1 ?: $contact->address_line_2) : '',
            'city_code' => config('dian.customer_city_code'),
            'city_name' => $contact && $contact->city ? $contact->city : config('dian.customer_city_name'),
            'state_name' => $contact && $contact->state ? $contact->state : config('dian.customer_state_name'),
            'state_code' => config('dian.customer_state_code'),
        ];
    }

    /**
     * Map an UltimatePOS tax name to a DIAN tax scheme code.
     *
     * @param  string  $name
     * @return string
     */
    protected function mapTaxCode($name)
    {
        $name = strtolower($name);
        if (strpos($name, 'inc') !== false || strpos($name, 'consumo') !== false) {
            return '04';
        }
        if (strpos($name, 'ica') !== false || strpos($name, 'industria') !== false) {
            return '03';
        }
        return '01';
    }

    /**
     * DIAN QR verification URL.
     *
     * @param  string  $cufe
     * @return string
     */
    protected function qrCodeUrl($cufe)
    {
        $host = (config('dian.environment') == '1')
            ? 'https://catalogo-vpfe.dian.gov.co'
            : 'https://catalogo-vpfe-hab.dian.gov.co';

        return $host . '/document/searchqr?documentkey=' . $cufe;
    }

    /**
     * Extract the CUFE from a signed XML.
     *
     * @param  string  $xml
     * @return string
     */
    protected function extractCufe($xml)
    {
        if (preg_match('/<cbc:UUID[^>]*>([^<]+)<\/cbc:UUID>/', $xml, $matches)) {
            return $matches[1];
        }

        return '';
    }

    /**
     * Calculate the Colombian NIT check digit (DV).
     *
     * @param  string  $nit
     * @return string
     */
    public function calculateDv($nit)
    {
        $nit = preg_replace('/\D/', '', $nit);
        if ($nit === '') {
            return '';
        }

        $weights = [3, 7, 13, 17, 19, 23, 29, 37, 41, 43, 47, 53, 59, 67, 71];
        $sum = 0;
        $len = strlen($nit);
        for ($i = 0; $i < $len && $i < count($weights); $i++) {
            $sum += (int) $nit[$len - 1 - $i] * $weights[$i];
        }

        $mod = $sum % 11;

        return (string) ($mod > 1 ? (11 - $mod) : $mod);
    }

    /**
     * Format a monetary amount with 2 decimals (dot separated).
     *
     * @param  float  $value
     * @return string
     */
    protected function formatAmount($value)
    {
        return number_format((float) $value, 2, '.', '');
    }

    /**
     * Format a quantity (6 decimals as required by DIAN).
     *
     * @param  float  $value
     * @return string
     */
    protected function formatQuantity($value)
    {
        return number_format((float) $value, 6, '.', '');
    }
}
