<?php

use Illuminate\Database\Seeder;

class InventariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inventarios')->insert([
            'articulo_codint' => str_random(10),
            'unidades' => Float.random(10),
            'cod_barras' => str_random(15),
        ]);
    }
}
