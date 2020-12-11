<?php namespace Kloos\Saas\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateTenantsTable extends Migration
{
    public function up()
    {
        Schema::table('kloos_saas_tenants', function (Blueprint $table) {
            $table->text('settings')->nullable();
            $table->tinyInteger('is_active')->default(0);
        });
    }

    public function down()
    {
        Schema::table('kloos_saas_tenants', function (Blueprint $table) {
            $table->dropColumn('settings');
            $table->dropColumn('is_active');
        });
    }
}
