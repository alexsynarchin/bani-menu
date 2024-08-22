<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products  = Product::all();
        foreach ($products as $product) {
            $product -> price = $product -> price / 100;
            $product -> save();
        }
    }
}
