<?php namespace Kloos\Saas\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateTenantsTable1 extends Migration
{
    public function up()
    {
        Schema::table('kloos_saas_tenants', function (Blueprint $table) {
            $table->tinyInteger('is_landlord')->default(0);
        });
    }

    public function down()
    {
        Schema::table('kloos_saas_tenants', function (Blueprint $table) {
            $table->dropColumn('is_landlord');
        });
    }
}
