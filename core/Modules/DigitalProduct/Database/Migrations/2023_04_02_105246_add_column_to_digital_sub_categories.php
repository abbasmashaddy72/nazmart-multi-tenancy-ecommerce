<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToDigitalSubCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('digital_sub_categories', function (Blueprint $table) {
            $table->boolean('status')->comment('0=draft,1=published');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('digital_sub_categories', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
