<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cartaos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_granja');
            $table->string('cidade');
            $table->string('tecnico');
            $table->string('pin')->nullable();
            $table->string('puk')->nullable();
            $table->date('validade')->nullable();
            $table->enum('status', ['Ativo', 'Expirado', 'Bloqueado'])->default('Ativo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cartaos');
    }
};
