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
            $product->title = 'V-Neck T-Shirt';
            $product->short_description = 'This is a variable product.	';
            $product->description = 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.	';
            $product->price = '5000';
            $product->discounted_price = '4500';
            $product->rating = '4';
            $product->image = 'download.jpg';
            $product->review = 'woo-vneck-tee';
            $product->color = 'Black';
            $product->size = 'Medium';
            $product->brand = 'V-Neck T-Shirt';
            $product->tags = 'T-Shirt';
            $product->weight = '5';
            $product->selected_qty = '5';
            $product->status = 'New';
            $product->stock = '50';
            $product->save();
        }
    }
}
