<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusEnumInCartaosTable extends Migration
{
    public function up()
    {
        Schema::table('cartaos', function (Blueprint $table) {
            \DB::statement("ALTER TABLE cartaos MODIFY COLUMN status ENUM('Ativo', 'Expirado', 'Bloqueado', 'Devolvido', 'Perto de Vencer') DEFAULT 'Ativo'");
        });
    }

    public function down()
    {
        Schema::table('cartaos', function (Blueprint $table) {
            \DB::statement("ALTER TABLE cartaos MODIFY COLUMN status ENUM('Ativo', 'Expirado', 'Bloqueado', 'Devolvido') DEFAULT 'Ativo'");
        });
    }
}
