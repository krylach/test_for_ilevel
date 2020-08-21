<?php

use Illuminate\Database\Seeder;

class ProductsHasCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $arrayForInsert = [];
            for ($i = 1; $i <= 50; $i++) {
                $arrayForInsert[] = ['category_id' => rand(1, 5), 'product_id' => $i];
                $arrayForInsert[] = ['category_id' => rand(1, 5), 'product_id' => $i];
            }

            DB::table('products_has_categories')
                ->insert($arrayForInsert);
        });
    }
}
