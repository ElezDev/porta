<?php

use App\Category;
use App\Product;
use App\ProductVariation;
use App\Variation;
use App\VariationLocationDetails;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $business_id = 1;
        $user_id = 1;
        $unit_id = 1;
        $location_id = 1;

        $service_category = Category::firstOrCreate([
            'name' => 'Servicios',
            'business_id' => $business_id,
            'category_type' => 'product',
        ], [
            'short_code' => 'SERV',
            'parent_id' => 0,
            'created_by' => $user_id,
        ]);

        $tech_category = Category::firstOrCreate([
            'name' => 'Tecnología',
            'business_id' => $business_id,
            'category_type' => 'product',
        ], [
            'short_code' => 'TEC',
            'parent_id' => 0,
            'created_by' => $user_id,
        ]);

        $shop_category = Category::firstOrCreate([
            'name' => 'Tienda',
            'business_id' => $business_id,
            'category_type' => 'product',
        ], [
            'short_code' => 'TIEN',
            'parent_id' => 0,
            'created_by' => $user_id,
        ]);

        $products = [
            ['name' => 'Hora de Internet', 'category' => $service_category->id, 'purchase' => 0, 'sell' => 2000, 'stock' => null],
            ['name' => 'Impresión Blanco y Negro', 'category' => $service_category->id, 'purchase' => 0, 'sell' => 300, 'stock' => null],
            ['name' => 'Impresión a Color', 'category' => $service_category->id, 'purchase' => 0, 'sell' => 1000, 'stock' => null],
            ['name' => 'Fotocopia', 'category' => $service_category->id, 'purchase' => 0, 'sell' => 200, 'stock' => null],
            ['name' => 'Escaneo de Documento', 'category' => $service_category->id, 'purchase' => 0, 'sell' => 500, 'stock' => null],
            ['name' => 'Recarga de Celular', 'category' => $service_category->id, 'purchase' => 0, 'sell' => 1000, 'stock' => null],
            ['name' => 'Memoria USB 32GB', 'category' => $tech_category->id, 'purchase' => 20000, 'sell' => 35000, 'stock' => 20],
            ['name' => 'Audífonos Básicos', 'category' => $tech_category->id, 'purchase' => 8000, 'sell' => 15000, 'stock' => 25],
            ['name' => 'Gaseosa Personal', 'category' => $shop_category->id, 'purchase' => 2000, 'sell' => 3000, 'stock' => 48],
            ['name' => 'Papas Fritas', 'category' => $shop_category->id, 'purchase' => 1500, 'sell' => 2500, 'stock' => 40],
        ];

        DB::beginTransaction();

        foreach ($products as $index => $item) {
            $sku = 'CIBER' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);

            $product = Product::create([
                'name' => $item['name'],
                'business_id' => $business_id,
                'type' => 'single',
                'unit_id' => $unit_id,
                'category_id' => $item['category'],
                'tax_type' => 'exclusive',
                'enable_stock' => is_null($item['stock']) ? 0 : 1,
                'alert_quantity' => 5,
                'sku' => $sku,
                'barcode_type' => 'C128',
                'created_by' => $user_id,
                'product_description' => $item['name'],
            ]);

            $product_variation = ProductVariation::create([
                'name' => 'DUMMY',
                'product_id' => $product->id,
                'is_dummy' => 1,
            ]);

            $variation = Variation::create([
                'name' => 'DUMMY',
                'product_id' => $product->id,
                'product_variation_id' => $product_variation->id,
                'sub_sku' => $sku,
                'default_purchase_price' => $item['purchase'],
                'dpp_inc_tax' => $item['purchase'],
                'profit_percent' => 0,
                'default_sell_price' => $item['sell'],
                'sell_price_inc_tax' => $item['sell'],
            ]);

            if (!is_null($item['stock'])) {
                VariationLocationDetails::create([
                    'product_id' => $product->id,
                    'product_variation_id' => $product_variation->id,
                    'variation_id' => $variation->id,
                    'location_id' => $location_id,
                    'qty_available' => $item['stock'],
                ]);
            }

            DB::table('product_locations')->insert([
                'product_id' => $product->id,
                'location_id' => $location_id,
            ]);
        }

        DB::commit();

        $this->command->info('Se crearon 10 productos de ejemplo.');
    }
}
