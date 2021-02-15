<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Product;
use App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        $seller = Seller::has('products')->get()->random();
        $product_id = $seller->products->random()->id;
        $product = Product::find($product_id);
        $buyer = User::all()->except($seller->id)->random();
        $quantity =  $this->faker->numberBetween(1,10);

        return [

            'quantity'=> $quantity,
            'total' =>  floatval($product->price)*$quantity,
            'buyer_id'=> $buyer->id,
            'product_id'=> $product_id,
        ];
    }
}
