<?php namespace Kloos\Saas\Behaviors;

use Model;
use October\Rain\Extension\ExtensionBase;

class BlacklistGlobalScope extends ExtensionBase
{
    public function __construct(Model $model)
    {
        $model->addDynamicProperty('scopeBlacklist', true);
    }
}