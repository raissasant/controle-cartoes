<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('oficios', function (Blueprint $table) {
        $table->integer('ano')->after('numero_oficio');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oficios', function (Blueprint $table) {
            //
        });
    }
};
