<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('appartments', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('slug')->unique();
      $table->tinyInteger('rooms')->unsigned();
      $table->tinyInteger('beds')->unsigned();
      $table->tinyInteger('bathrooms')->unsigned();
      $table->integer('square_meters')->unsigned();
      $table->string('image')->nullable();
      $table->boolean('published')->default(false);
      $table->string('address');
      $table->decimal('lat', 9, 6);
      $table->decimal('long', 9, 6);
      $table->foreignId('user_id')->constrained();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('appartments');
  }
};
