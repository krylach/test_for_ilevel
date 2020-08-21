<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
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
            for ($i = 0; $i < 50; $i++) { 
                $arrayForInsert[] = ['name' => Str::random(10)];
            }

            DB::table('products')
                ->insert($arrayForInsert);
        });
    }
}
