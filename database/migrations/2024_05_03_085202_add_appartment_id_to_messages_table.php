<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
    Schema::table('messages', function (Blueprint $table) {
        $table->unsignedBigInteger('appartment_id')->after('id');
        $table->foreign('appartment_id')->references('id')->on('appartments')->onDelete('cascade');
    });
    }

    public function down(){
    Schema::table('messages', function (Blueprint $table) {
        $table->dropForeign(['appartment_id']);
        $table->dropColumn('appartment_id');
    });
    }
};


