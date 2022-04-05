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
                'endereco' => 'RUA UNIVERSITARIO 100',
                'localizacao' => 'www.google.com',
                'status' => 'Ativo'
            )
        );

        DB::table('polos')->insert(
            array(
                'descricao' => 'POLO ARARANGUA',
                'endereco' => 'RUA CHILE 200',
                'localizacao' => 'www.facebook.com',
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
