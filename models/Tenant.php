<?php namespace Kloos\Saas\Models;

use Model;
use Backend\Models\User;
use Kloos\Multitenancy\Classes\Item\Database;

/**
 * Tenant Model
 */
class Tenant extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'kloos_saas_tenants';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [
        'settings',
    ];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public $with = [
        'image',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];

    /**
     * Morphed by many relations
     *
     * @var \string[][]
     */
    public $morphedByMany = [
        'backend_users' => [
            User::class,
            'name' => 'tenant_relation',
            'table' => 'kloos_saas_tenants_relations',
        ],
    ];

    public $attachOne = [
        'image' => 'System\Models\File',
    ];

    public $attachMany = [];

    public static function byDomain($domainName)
    {
        return static::where('domain', $domainName)->first();
    }

    public static function bySlug($slug)
    {
        return static::where('slug', $slug)->first();
    }
}
