<?php
namespace Kloos\Saas\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTenantsUsersTable extends Migration
{
    public function up()
    {
        Schema::create('kloos_saas_tenants_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('tenant_id');
            $table->integer('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kloos_saas_tenants_users');
    }
}
