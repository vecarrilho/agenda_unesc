<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertSalasData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('salas')->insert(
            array(
                'bloco' => 'XXIA',
                'hora' => '19:00:00',
                'data' => '2022-04-30',
                'qtd_maquinas' => 20,
                'nsala' => 1
            )
        );
        DB::table('salas')->insert(
            array(
                'bloco' => 'XXIB',
                'hora' => '12:00:00',
                'data' => '2022-04-20',
                'qtd_maquinas' => 30,
                'nsala' => 2
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
