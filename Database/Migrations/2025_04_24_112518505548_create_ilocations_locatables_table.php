<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('ilocations__locatables', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('entity_type', 255);
      $table->integer('entity_id');
      $table->integer('country_id')->unsigned()->nullable();
      $table->foreign('country_id')->references('id')->on('ilocations__countries')->onDelete('restrict');
      $table->integer('province_id')->unsigned()->nullable();
      $table->foreign('province_id')->references('id')->on('ilocations__provinces')->onDelete('restrict');
      $table->integer('city_id')->unsigned()->nullable();
      $table->foreign('city_id')->references('id')->on('ilocations__cities')->onDelete('restrict');

      // Audit fields
      $table->timestamps();
      $table->auditStamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('ilocations__locatables');
  }
};
