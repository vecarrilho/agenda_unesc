<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertPolosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('polos')->insert(
            array(
                'descricao' => 'POLO CRICIUMA',
                'endereco' => 'Avenida Universitária, n° 1105',
                'localizacao' => 'www.unesc.net',
                'status' => 'Ativo'
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
