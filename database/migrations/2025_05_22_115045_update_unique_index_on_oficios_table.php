<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('oficios', function (Blueprint $table) {
            // Remove o índice único antigo (caso exista)
            $table->dropUnique('oficios_numero_oficio_unique');

            // Cria um índice único combinado entre numero_oficio e ano
            $table->unique(['numero_oficio', 'ano']);
        });
    }

    public function down()
    {
        Schema::table('oficios', function (Blueprint $table) {
            $table->dropUnique(['numero_oficio', 'ano']);
            $table->unique('numero_oficio');
        });
    }
};
