<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {	
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0');

    	Category::truncate();
        Product::truncate();
        Transaction::truncate();
        User::truncate();
        DB::table('category_product')->truncate();
  
        $categoriesQuantity = 30;
        $productsQuantity = 1000;
        $transactionsQuantity = 1000;
        $usersQuantity = 1000;

        User::factory()->count($usersQuantity)->create();

        Category::factory()->count($categoriesQuantity)->create();

        Product::factory()->count($productsQuantity)->create()->each( 
        	function ($product)
            {
              	$categories = Category::all()->random(mt_rand(1,5))->pluck('id');
        	 	$product->categories()->attach($categories); 
        	 }
        	);
        
        Transaction::factory()->count($transactionsQuantity)->create();

        
    }
}