<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IlocationsAddAuditstampsInTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      Schema::table('ilocations__countries', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('ilocations__cities', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('ilocations__provinces', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('ilocations__geozones', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('ilocations__neighborhoods', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('ilocations__polygons', function (Blueprint $table) {
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
        //
    }

}
