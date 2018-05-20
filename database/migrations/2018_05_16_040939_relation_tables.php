<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('restrict');
            $table->unsignedInteger('region_id');
            $table->foreign('region_id')->references('id')->on('regions')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::table('values', function (Blueprint $table) {
            $table->unsignedInteger('asset_id');
            $table->foreign('asset_id')->references('id')->on('assets')->onUpdate('cascade')->onDelete('restrict');
            $table->unsignedInteger('certificate_id');
            $table->foreign('certificate_id')->references('id')->on('certificates')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::table('pictures', function (Blueprint $table) {
            $table->unsignedInteger('asset_id');
            $table->foreign('asset_id')->references('id')->on('assets')->onUpdate('cascade')->onDelete('restrict');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets', function(Blueprint $table) {
            $table->dropForeign('assets_category_id_foreign');
            $table->dropColumn('category_id');
            $table->dropForeign('assets_region_id_foreign');
            $table->dropColumn('region_id');
        });

        Schema::table('values', function(Blueprint $table) {
            $table->dropForeign('values_asset_id_foreign');
            $table->dropColumn('asset_id');
            $table->dropForeign('values_certificate_id_foreign');
            $table->dropColumn('certificate_id');
        });

        Schema::table('pictures', function (Blueprint $table) {
            $table->dropForeign('pictures_asset_id_foreign');
            $table->dropColumn('asset_id');
        });
    }
}
