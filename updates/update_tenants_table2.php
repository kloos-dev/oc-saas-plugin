<?php namespace Kloos\Saas\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateTenantsTable2 extends Migration
{
    public function up()
    {
        Schema::table('kloos_saas_tenants', function (Blueprint $table) {
            $table->string('group')->nullable();
        });
    }

    public function down()
    {
        Schema::table('kloos_saas_tenants', function (Blueprint $table) {
            $table->dropColumn('group');
        });
    }
}
