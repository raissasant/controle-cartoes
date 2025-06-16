<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('cartaos', function (Blueprint $table) {
            $table->text('observacao')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('cartaos', function (Blueprint $table) {
            $table->dropColumn('observacao');
        });
    }
};
