<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            [
                'id_position'      => 1,
                'document'         => '432142432',
                'name'             => 'Eduardo',
                'surname'          => 'Soto',
                'balance'            => 0,
                'created_at'       => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'       => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_position'      => 2,
                'document'         => '745325452',
                'name'             => 'Maria',
                'surname'          => 'Gomez',
                'balance'          => 0,
                'created_at'       => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'       => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_position'      => 3,
                'document'         => '163245342',
                'name'             => 'Francisco',
                'surname'          => 'Ceballos',
                'balance'          => 0,
                'created_at'       => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'       => Carbon::now()->format('Y-m-d H:i:s')
            ],            
        ]);
    }
}
