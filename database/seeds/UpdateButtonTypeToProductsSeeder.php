<?php

use App\Model\Admin\Product;
use Illuminate\Database\Seeder;

class UpdateButtonTypeToProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::where('type', Product::TYPE_AFFILIATE)->get();
        foreach ($products as $product) {
            $product->button_type = 1;
            $product->save();
        }
    }
}
