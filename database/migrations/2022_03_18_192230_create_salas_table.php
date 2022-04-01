<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSalasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salas', function (Blueprint $table) {
            $table->id();
            $table->string('bloco', 20);
            $table->time('hora');
            $table->date('data');
        });

        DB::table('salas')->insert(
            array(
                'bloco' => 'XXIA',
                'hora' => '19:00:00',
                'data' => '2022-04-30'
            )
        );
        DB::table('salas')->insert(
            array(
                'bloco' => 'XXIB',
                'hora' => '12:00:00',
                'data' => '2022-04-20'
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
        Schema::dropIfExists('salas');
    }
}
