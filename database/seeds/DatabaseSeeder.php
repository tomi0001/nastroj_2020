<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('actions')->insert([
            'name' => "Jazda na rowerze",
            'level_pleasure' => 3,
        ]);
        DB::table('actions')->insert([
            'name' => "Odkurzanie",
            'level_pleasure' => -8,
        ]);
        DB::table('actions')->insert([
            'name' => "Pójście do sklepu",
            'level_pleasure' => 0,
        ]);
        DB::table('actions')->insert([
            'name' => "Mycie okien",
            'level_pleasure' => -9,
        ]);
        DB::table('actions')->insert([
            'name' => "Praca",
            'level_pleasure' => -6,
        ]);
        DB::table('actions')->insert([
            'name' => "Pogoda jest bardzo ładna",
            'level_pleasure' => 12,
        ]);
        DB::table('actions')->insert([
            'name' => "Pogoda jest średniawa",
            'level_pleasure' => 0,
        ]);
        DB::table('actions')->insert([
            'name' => "Pogoda jest depresyjna",
            'level_pleasure' => -8,
        ]);
        DB::table('actions')->insert([
            'name' => "pogoda się poprawiła",
            'level_pleasure' => 5,
        ]);
        DB::table('actions')->insert([
            'name' => "pogoda się pogorszyła",
            'level_pleasure' => -5,
        ]);
        DB::table('actions')->insert([
            'name' => "leżenie w łóżku",
            'level_pleasure' => 3,
        ]);
        DB::table('actions')->insert([
            'name' => "Oglądanie filmu",
            'level_pleasure' => 3,
        ]);

    }
}
