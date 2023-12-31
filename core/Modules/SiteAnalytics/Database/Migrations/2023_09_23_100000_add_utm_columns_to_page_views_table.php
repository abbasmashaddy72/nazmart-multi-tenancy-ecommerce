<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUtmColumnsToPageViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumns('page_views', ['utm_source','utm_medium','utm_campaign','utm_term','utm_content']))
        {
            Schema::table('page_views', function (Blueprint $table) {
                $table->string('utm_source')->nullable()->after('device');
                $table->string('utm_medium')->nullable()->after('device');
                $table->string('utm_campaign')->nullable()->after('device');
                $table->string('utm_term')->nullable()->after('device');
                $table->string('utm_content')->nullable()->after('device');
            });
        }
    }
}
