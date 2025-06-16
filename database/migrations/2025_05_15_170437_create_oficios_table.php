<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOficiosTable extends Migration
{
    public function up()
    {
        Schema::create('oficios', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_oficio')->unique();
            $table->string('setor');
            $table->date('data_uso');
            $table->string('responsavel')->nullable();
            $table->text('motivo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('oficios');
    }
}
