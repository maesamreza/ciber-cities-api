<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    
    public function run()
    {
        $category = new Category();
        $subcategory = new SubCategory();
        
        $category->create(['name'=>'Mens Collection','url'=>'menscollection']);
        $category->create(['name'=>'Womens Collection','url'=>'womenscollection']);
        $category->create(['name'=>'Electronic Device','url'=>'electronicdevice']);
        $category->create(['name'=>'Health & Beauty','url'=>'health&beauty']);

        $subcategory->create(['category_id'=>1,'name'=>'Watch','url'=>'menscollection/watch']);
        $subcategory->create(['category_id'=>1,'name'=>'Shirts','url'=>'menscollection/shirts']);
        $subcategory->create(['category_id'=>1,'name'=>'T-Shirts','url'=>'menscollection/t-shirts']);
        $subcategory->create(['category_id'=>1,'name'=>'Jeans','url'=>'menscollection/jeans']);
        
        $subcategory->create(['category_id'=>2,'name'=>'Watch','url'=>'womenscollection/watch']);
        $subcategory->create(['category_id'=>2,'name'=>'Shirts','url'=>'womenscollection/shirts']);
        $subcategory->create(['category_id'=>2,'name'=>'T-Shirts','url'=>'womenscollection/t-shirts']);
        $subcategory->create(['category_id'=>2,'name'=>'Jeans','url'=>'womenscollection/jeans']);
        
        $subcategory->create(['category_id'=>3,'name'=>'Smart Phones','url'=>'electronicdevice/smartphones']);
        $subcategory->create(['category_id'=>3,'name'=>'Feature Phones','url'=>'electronicdevice/featurephones']);
        $subcategory->create(['category_id'=>3,'name'=>'Tablets','url'=>'electronicdevice/tablets']);
        $subcategory->create(['category_id'=>3,'name'=>'Landline Phones','url'=>'electronicdevice/landlinephones']);
        
        $subcategory->create(['category_id'=>4,'name'=>'Bath & Body','url'=>'health&beauty/bath&body']);
        $subcategory->create(['category_id'=>4,'name'=>'Beauty Tools','url'=>'health&beauty/beautytools']);
        $subcategory->create(['category_id'=>4,'name'=>'Hair Care','url'=>'health&beauty/haircare']);
        $subcategory->create(['category_id'=>4,'name'=>'Makeup','url'=>'health&beauty/makeup']);
        
        for ($i=0; $i <  20; $i++) { 
            $product = new Product();
            $product->user_id = 3;
            $product->sub_category_id = 1;
            $product->name = 'V-Neck T-Shirt';
            $product->price = '5000';
            $product->discount_price = '4500';
            // $product->color = ["Red","Black","White","Blue"];
            $product->size = "small medium large xlarge";
            $product->brand = 'V-Neck T-Shirt';
            $product->status = 'New';
            $product->stock = '50';
            $product->featured = 'Standard';
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
        for ($j=1; $j <  20; $j++) { 
            $products = new ProductImage();
            $products->product_id = $j;
            $products->image = 'image/download.jpg';
            $products->save();
        }

    }
}
