<?php namespace Kloos\Saas\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'kloos_saas_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}