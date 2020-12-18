<?php namespace Kloos\Saas\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTenantsRelationsTable extends Migration
{
    public function up()
    {
        Schema::create('kloos_saas_tenants_relations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('tenant_id');
            $table->integer('tenant_relation_id');
            $table->string('tenant_relation_type');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kloos_saas_tenants_relations');
    }
}
