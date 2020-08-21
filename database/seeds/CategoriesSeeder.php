<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
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
            for ($i = 0; $i < 5; $i++) { 
                $arrayForInsert[] = ['name' => Str::random(10)];
            }
        
            DB::table('categories')
                ->insert($arrayForInsert);
        });
    }
}
