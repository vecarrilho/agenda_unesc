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
                'id' => 7,
                'descricao' => 'POLO CRICIUMA',
                'endereco' => 'Avenida Universitária, n° 1105',
                'localizacao' => 'www.unesc.net',
                'status' => 'Ativo'
            )
        );
        DB::table('polos')->insert(
            array(
                'id' => 14,
                'descricao' => 'POLO ARARANGUÁ',
                'endereco' => 'Campus Araranguá Av. Governador Jorge Lacerda, nº 2320. Bairro Divinéia, Araranguá/SC',
                'localizacao' => 'www.unesc.net',
                'status' => 'Ativo'
            )
        );
        DB::table('polos')->insert(
            array(
                'id' => 15,
                'descricao' => 'POLO BALNEÁRIO RINCÃO',
                'endereco' => 'Escola Arroio Rincão  Rua Jaguaruna S/N - Centro. Balneário Rincão/SC',
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
