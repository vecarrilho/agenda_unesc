<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDisciplinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_disciplinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cd_user');
            $table->foreignId('cd_disciplina');
            $table->year('ano');
            $table->integer('trimestre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_disciplinas');
    }
}
