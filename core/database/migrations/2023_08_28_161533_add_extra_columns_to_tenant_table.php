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
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            if (!Schema::hasColumn('tenants', 'in_progress')) {
                $table->unsignedBigInteger('in_progress')->default(0);
            }
            if (!Schema::hasColumn('tenants', 'cleanup')) {
                $table->unsignedBigInteger('cleanup')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            if (Schema::hasColumn('tenants', 'in_progress')) {
                $table->dropColumn('in_progress');
            }
            if (Schema::hasColumn('tenants', 'cleanup')) {
                $table->dropColumn('cleanup');
            }
        });
    }
};
