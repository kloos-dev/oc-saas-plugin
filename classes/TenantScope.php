<?php namespace Kloos\Saas\Classes;

use DB;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $tenancy = Tenant::instance()->active();

        if ($tenancy) {
            $ids = DB::table('kloos_saas_tenants_relations')
                ->where('tenant_id', $tenancy->id)
                ->where('tenant_relation_type', get_class($model))
                ->get()
                ->pluck('tenant_relation_id')
                ->toArray();

            $builder->whereIn('id', $ids);
        }
    }
}