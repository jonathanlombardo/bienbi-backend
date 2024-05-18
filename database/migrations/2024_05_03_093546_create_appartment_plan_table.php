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
    Schema::create('appartment_plan', function (Blueprint $table) {
      $table->id();
      $table->foreignId("appartment_id")->constrained()->cascadeOnDelete();
      $table->foreignId("plan_id")->constrained()->cascadeOnDelete();
      $table->dateTime('expired_at')->nullable();
      $table->dateTime('date_of_issue')->nullable();
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
    Schema::dropIfExists('appartment_plan');
  }
};
