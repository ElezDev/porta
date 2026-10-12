<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2"
    xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
    xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
    xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2"
    xmlns:sts="http://www.dian.gov.co/contratos/facturaelectronica/v1/Structures"
    xmlns:xades="http://uri.etsi.org/01903/v1.3.2#"
    xmlns:xades141="http://uri.etsi.org/01903/v1.4.1#"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2 http://docs.oasis-open.org/ubl/os-UBL-2.1/xsd/maindoc/UBL-Invoice-2.1.xsd">
    <ext:UBLExtensions>
        <ext:UBLExtension>
            <ext:ExtensionContent>
                <sts:DianExtensions>
                    <sts:InvoiceControl>
                        <sts:InvoiceAuthorization>{{ $invoice['resolution_number'] }}</sts:InvoiceAuthorization>
                        <sts:AuthorizationPeriod>
                            <cbc:StartDate>{{ $invoice['resolution_start_date'] }}</cbc:StartDate>
                            <cbc:EndDate>{{ $invoice['resolution_end_date'] }}</cbc:EndDate>
                        </sts:AuthorizationPeriod>
                        <sts:AuthorizedInvoices>
                            <sts:Prefix>{{ $invoice['resolution_prefix'] }}</sts:Prefix>
                            <sts:From>{{ $invoice['resolution_from'] }}</sts:From>
                            <sts:To>{{ $invoice['resolution_to'] }}</sts:To>
                        </sts:AuthorizedInvoices>
                    </sts:InvoiceControl>
                    <sts:InvoiceSource>
                        <cbc:IdentificationCode listAgencyID="6" listAgencyName="United Nations Economic Commission for Europe" listSchemeURI="urn:oasis:names:specification:ubl:codelist:gc:CountryIdentificationCode-2.1">CO</cbc:IdentificationCode>
                    </sts:InvoiceSource>
                    <sts:SoftwareProvider>
                        <sts:ProviderID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Direccion de Impuestos y Aduanas Nacionales)" schemeID="3" schemeName="{{ $invoice['supplier']['id_type'] }}">{{ $invoice['provider_nit'] }}</sts:ProviderID>
                        <sts:SoftwareID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Direccion de Impuestos y Aduanas Nacionales)">{{ $invoice['software_id'] }}</sts:SoftwareID>
                    </sts:SoftwareProvider>
                    <sts:SoftwareSecurityCode schemeAgencyID="195" schemeAgencyName="CO, DIAN (Direccion de Impuestos y Aduanas Nacionales)"></sts:SoftwareSecurityCode>
                    <sts:AuthorizationProvider>
                        <sts:AuthorizationProviderID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Direccion de Impuestos y Aduanas Nacionales)" schemeID="4" schemeName="31">800197268</sts:AuthorizationProviderID>
                    </sts:AuthorizationProvider>
                    <sts:QRCode>{{ $invoice['qr_code'] }}</sts:QRCode>
                </sts:DianExtensions>
            </ext:ExtensionContent>
        </ext:UBLExtension>
        <ext:UBLExtension>
            <ext:ExtensionContent/>
        </ext:UBLExtension>
    </ext:UBLExtensions>
    <cbc:UBLVersionID>UBL 2.1</cbc:UBLVersionID>
    <cbc:CustomizationID>01</cbc:CustomizationID>
    <cbc:ProfileID>DIAN 2.1</cbc:ProfileID>
    <cbc:ProfileExecutionID>{{ $invoice['environment'] }}</cbc:ProfileExecutionID>
    <cbc:ID>{{ $invoice['invoice_no'] }}</cbc:ID>
    <cbc:UUID schemeID="2" schemeName="CUFE-SHA384"></cbc:UUID>
    <cbc:IssueDate>{{ $invoice['issue_date'] }}</cbc:IssueDate>
    <cbc:IssueTime>{{ $invoice['issue_time'] }}</cbc:IssueTime>
    @if(!empty($invoice['due_date']))
    <cbc:DueDate>{{ $invoice['due_date'] }}</cbc:DueDate>
    @endif
    <cbc:InvoiceTypeCode>01</cbc:InvoiceTypeCode>
    @if(!empty($invoice['note']))
    <cbc:Note>{{ $invoice['note'] }}</cbc:Note>
    @endif
    <cbc:DocumentCurrencyCode>{{ $invoice['currency'] }}</cbc:DocumentCurrencyCode>
    <cbc:LineCountNumeric>{{ count($invoice['lines']) }}</cbc:LineCountNumeric>
    <cac:AccountingSupplierParty>
        <cbc:AdditionalAccountID schemeAgencyID="195">{{ $invoice['supplier']['person_type'] }}</cbc:AdditionalAccountID>
        <cac:Party>
            <cac:PartyName>
                <cbc:Name>{{ $invoice['supplier']['name'] }}</cbc:Name>
            </cac:PartyName>
            <cac:PhysicalLocation>
                <cac:Address>
                    <cbc:ID>{{ $invoice['supplier']['city_code'] }}</cbc:ID>
                    <cbc:CityName>{{ $invoice['supplier']['city_name'] }}</cbc:CityName>
                    <cbc:CountrySubentity>{{ $invoice['supplier']['state_name'] }}</cbc:CountrySubentity>
                    <cbc:CountrySubentityCode>{{ $invoice['supplier']['state_code'] }}</cbc:CountrySubentityCode>
                    <cac:AddressLine>
                        <cbc:Line>{{ $invoice['supplier']['address'] }}</cbc:Line>
                    </cac:AddressLine>
                    <cac:Country>
                        <cbc:IdentificationCode>CO</cbc:IdentificationCode>
                        <cbc:Name languageID="es">Colombia</cbc:Name>
                    </cac:Country>
                </cac:Address>
            </cac:PhysicalLocation>
            <cac:PartyTaxScheme>
                <cbc:RegistrationName>{{ $invoice['supplier']['name'] }}</cbc:RegistrationName>
                <cbc:CompanyID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Direccion de Impuestos y Aduanas Nacionales)" schemeID="3" schemeName="{{ $invoice['supplier']['id_type'] }}">{{ $invoice['supplier']['nit'] }}</cbc:CompanyID>
                <cbc:TaxLevelCode listName="05">{{ $invoice['supplier']['regime'] }}</cbc:TaxLevelCode>
                <cac:TaxScheme>
                    <cbc:ID>01</cbc:ID>
                    <cbc:Name>IVA</cbc:Name>
                </cac:TaxScheme>
            </cac:PartyTaxScheme>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName>{{ $invoice['supplier']['name'] }}</cbc:RegistrationName>
                <cbc:CompanyID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Direccion de Impuestos y Aduanas Nacionales)" schemeID="3" schemeName="{{ $invoice['supplier']['id_type'] }}">{{ $invoice['supplier']['nit'] }}</cbc:CompanyID>
                <cac:CorporateRegistrationScheme>
                    <cbc:ID>{{ $invoice['resolution_prefix'] }}</cbc:ID>
                </cac:CorporateRegistrationScheme>
            </cac:PartyLegalEntity>
            @if(!empty($invoice['supplier']['phone']) || !empty($invoice['supplier']['email']))
            <cac:Contact>
                @if(!empty($invoice['supplier']['phone']))
                <cbc:Telephone>{{ $invoice['supplier']['phone'] }}</cbc:Telephone>
                @endif
                @if(!empty($invoice['supplier']['email']))
                <cbc:ElectronicMail>{{ $invoice['supplier']['email'] }}</cbc:ElectronicMail>
                @endif
            </cac:Contact>
            @endif
        </cac:Party>
    </cac:AccountingSupplierParty>
    <cac:AccountingCustomerParty>
        <cbc:AdditionalAccountID schemeAgencyID="195">{{ $invoice['customer']['person_type'] }}</cbc:AdditionalAccountID>
        <cac:Party>
            <cac:PartyName>
                <cbc:Name>{{ $invoice['customer']['name'] }}</cbc:Name>
            </cac:PartyName>
            <cac:PhysicalLocation>
                <cac:Address>
                    <cbc:ID>{{ $invoice['customer']['city_code'] }}</cbc:ID>
                    <cbc:CityName>{{ $invoice['customer']['city_name'] }}</cbc:CityName>
                    <cbc:CountrySubentity>{{ $invoice['customer']['state_name'] }}</cbc:CountrySubentity>
                    <cbc:CountrySubentityCode>{{ $invoice['customer']['state_code'] }}</cbc:CountrySubentityCode>
                    <cac:AddressLine>
                        <cbc:Line>{{ $invoice['customer']['address'] }}</cbc:Line>
                    </cac:AddressLine>
                    <cac:Country>
                        <cbc:IdentificationCode>CO</cbc:IdentificationCode>
                        <cbc:Name languageID="es">Colombia</cbc:Name>
                    </cac:Country>
                </cac:Address>
            </cac:PhysicalLocation>
            <cac:PartyTaxScheme>
                <cbc:RegistrationName>{{ $invoice['customer']['name'] }}</cbc:RegistrationName>
                <cbc:CompanyID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Direccion de Impuestos y Aduanas Nacionales)" schemeID="3" schemeName="{{ $invoice['customer']['id_type'] }}">{{ $invoice['customer']['nit'] }}</cbc:CompanyID>
                <cbc:TaxLevelCode listName="05">{{ $invoice['customer']['regime'] }}</cbc:TaxLevelCode>
                <cac:TaxScheme>
                    <cbc:ID>01</cbc:ID>
                    <cbc:Name>IVA</cbc:Name>
                </cac:TaxScheme>
            </cac:PartyTaxScheme>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName>{{ $invoice['customer']['name'] }}</cbc:RegistrationName>
                <cbc:CompanyID schemeAgencyID="195" schemeAgencyName="CO, DIAN (Direccion de Impuestos y Aduanas Nacionales)" schemeID="3" schemeName="{{ $invoice['customer']['id_type'] }}">{{ $invoice['customer']['nit'] }}</cbc:CompanyID>
            </cac:PartyLegalEntity>
            @if(!empty($invoice['customer']['phone']) || !empty($invoice['customer']['email']))
            <cac:Contact>
                @if(!empty($invoice['customer']['phone']))
                <cbc:Telephone>{{ $invoice['customer']['phone'] }}</cbc:Telephone>
                @endif
                @if(!empty($invoice['customer']['email']))
                <cbc:ElectronicMail>{{ $invoice['customer']['email'] }}</cbc:ElectronicMail>
                @endif
            </cac:Contact>
            @endif
        </cac:Party>
    </cac:AccountingCustomerParty>
    <cac:PaymentMeans>
        <cbc:ID>{{ $invoice['payment_means']['id'] }}</cbc:ID>
        <cbc:PaymentMeansCode>{{ $invoice['payment_means']['code'] }}</cbc:PaymentMeansCode>
        @if(!empty($invoice['payment_means']['due_date']))
        <cbc:PaymentDueDate>{{ $invoice['payment_means']['due_date'] }}</cbc:PaymentDueDate>
        @endif
    </cac:PaymentMeans>
    @foreach($invoice['tax_totals'] as $tax)
    <cac:TaxTotal>
        <cbc:TaxAmount currencyID="{{ $invoice['currency'] }}">{{ $tax['amount'] }}</cbc:TaxAmount>
        <cac:TaxSubtotal>
            <cbc:TaxableAmount currencyID="{{ $invoice['currency'] }}">{{ $tax['taxable'] }}</cbc:TaxableAmount>
            <cbc:TaxAmount currencyID="{{ $invoice['currency'] }}">{{ $tax['amount'] }}</cbc:TaxAmount>
            <cac:TaxCategory>
                <cbc:Percent>{{ $tax['percent'] }}</cbc:Percent>
                <cac:TaxScheme>
                    <cbc:ID>{{ $tax['code'] }}</cbc:ID>
                    <cbc:Name>{{ $tax['name'] }}</cbc:Name>
                </cac:TaxScheme>
            </cac:TaxCategory>
        </cac:TaxSubtotal>
    </cac:TaxTotal>
    @endforeach
    <cac:LegalMonetaryTotal>
        <cbc:LineExtensionAmount currencyID="{{ $invoice['currency'] }}">{{ $invoice['totals']['line_extension'] }}</cbc:LineExtensionAmount>
        <cbc:TaxExclusiveAmount currencyID="{{ $invoice['currency'] }}">{{ $invoice['totals']['tax_exclusive'] }}</cbc:TaxExclusiveAmount>
        <cbc:TaxInclusiveAmount currencyID="{{ $invoice['currency'] }}">{{ $invoice['totals']['tax_inclusive'] }}</cbc:TaxInclusiveAmount>
        @if($invoice['totals']['allowance'] !== '0.00')
        <cbc:AllowanceTotalAmount currencyID="{{ $invoice['currency'] }}">{{ $invoice['totals']['allowance'] }}</cbc:AllowanceTotalAmount>
        @endif
        @if($invoice['totals']['charge'] !== '0.00')
        <cbc:ChargeTotalAmount currencyID="{{ $invoice['currency'] }}">{{ $invoice['totals']['charge'] }}</cbc:ChargeTotalAmount>
        @endif
        <cbc:PayableAmount currencyID="{{ $invoice['currency'] }}">{{ $invoice['totals']['payable'] }}</cbc:PayableAmount>
    </cac:LegalMonetaryTotal>
    @foreach($invoice['lines'] as $line)
    <cac:InvoiceLine>
        <cbc:ID>{{ $line['id'] }}</cbc:ID>
        <cbc:InvoicedQuantity unitCode="{{ $line['unit_code'] }}">{{ $line['quantity'] }}</cbc:InvoicedQuantity>
        <cbc:LineExtensionAmount currencyID="{{ $invoice['currency'] }}">{{ $line['line_extension'] }}</cbc:LineExtensionAmount>
        <cbc:FreeOfChargeIndicator>false</cbc:FreeOfChargeIndicator>
        @if(!empty($line['taxes']))
        <cac:TaxTotal>
            <cbc:TaxAmount currencyID="{{ $invoice['currency'] }}">{{ $line['tax_amount'] }}</cbc:TaxAmount>
            @foreach($line['taxes'] as $tax)
            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID="{{ $invoice['currency'] }}">{{ $line['line_extension'] }}</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID="{{ $invoice['currency'] }}">{{ $tax['amount'] }}</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cbc:Percent>{{ $tax['percent'] }}</cbc:Percent>
                    <cac:TaxScheme>
                        <cbc:ID>{{ $tax['code'] }}</cbc:ID>
                        <cbc:Name>{{ $tax['name'] }}</cbc:Name>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
            @endforeach
        </cac:TaxTotal>
        @endif
        <cac:Item>
            <cbc:Description>{{ $line['description'] }}</cbc:Description>
            @if(!empty($line['sku']))
            <cac:SellersItemIdentification>
                <cbc:ID>{{ $line['sku'] }}</cbc:ID>
            </cac:SellersItemIdentification>
            @endif
        </cac:Item>
        <cac:Price>
            <cbc:PriceAmount currencyID="{{ $invoice['currency'] }}">{{ $line['price'] }}</cbc:PriceAmount>
            <cbc:BaseQuantity unitCode="{{ $line['unit_code'] }}">1.000000</cbc:BaseQuantity>
        </cac:Price>
    </cac:InvoiceLine>
    @endforeach
</Invoice>
