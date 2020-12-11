<?php namespace Kloos\Saas\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTenantsTable extends Migration
{
    public function up()
    {
        Schema::create('kloos_saas_tenants', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('domain')->nullable();

            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kloos_saas_tenants');
    }
}
