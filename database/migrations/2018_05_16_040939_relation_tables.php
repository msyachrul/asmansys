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

        Schema::table('certificate_on_assets', function (Blueprint $table) {
            $table->unsignedInteger('asset_id');
            $table->foreign('asset_id')->references('id')->on('assets')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('certificate_id');
            $table->foreign('certificate_id')->references('id')->on('certificates')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::table('certificate_on_assets_attachment', function (Blueprint $table) {
            $table->unsignedInteger('coa_id');
            $table->foreign('coa_id')->references('id')->on('certificate_on_assets')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign('assets_category_id_foreign');
            $table->dropColumn('category_id');
            $table->dropForeign('assets_region_id_foreign');
            $table->dropColumn('region_id');
        });

        Schema::table('certificate_on_assets', function (Blueprint $table) {
            $table->dropForeign('certificate_on_assets_asset_id_foreign');
            $table->dropColumn('asset_id');
            $table->dropForeign('certificate_on_assets_certificate_id_foreign');
            $table->dropColumn('certificate_id');
        });

        Schema::table('certificate_on_assets_attachment', function (Blueprint $table) {
            $table->dropForeign('certificate_on_assets_attachment_coa_id_foreign');
            $table->dropColumn('coa_id');
        });

        Schema::table('pictures', function (Blueprint $table) {
            $table->dropForeign('pictures_asset_id_foreign');
            $table->dropColumn('asset_id');
        });
    }
}
