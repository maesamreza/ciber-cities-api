<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i <  20; $i++) { 
            $product = new Product();
            $product->user_id = 3;
            $product->name = 'V-Neck T-Shirt';
            $product->price = '5000';
            $product->discount_price = '4500';
            $product->image = 'download.jpg';
            $product->color = ["Red","Black","White","Blue"];
            $product->size = ["small","medium","large","xlarge"];
            $product->brand = 'V-Neck T-Shirt';
            $product->status = 'New';
            $product->selected_qty = '5';
            $product->stock = '50';
            $product->details = "<p>Product Details:</p><ul><li>4.5 inch Gold Heel</li> <li>Pointed Toe</li><li>Patent</li> <li>Imported</li></ul>";
            // $product->short_description = 'This is a variable product.	';
            // $product->description = 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.	';
            // $product->rating = '4';
            // $product->review = 'woo-vneck-tee';
            // $product->tags = 'T-Shirt';
            // $product->weight = '5';
            // dd($product);
            $product->save();
        }
    }
}
