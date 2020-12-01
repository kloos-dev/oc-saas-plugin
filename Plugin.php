<?php namespace Kloos\Saas;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'kloos.saas::lang.plugin.name',
            'description' => 'kloos.saas::lang.plugin.description',
            'author' => 'kloos.saas::lang.plugin.author',
        ];
    }

    public function register()
    {
    }

    public function boot()
    {
    }

    public function registerPermissions()
    {
    }

    public function registerFormWidgets()
    {
    }
}