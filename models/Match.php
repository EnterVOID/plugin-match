<?php namespace Void\Match\Models;

use Model;

class Match extends Model {

    protected $table = 'matches';

    public $hasMany = [
        'comics' => ['Void\Comic\Models\Comic', 'table' => 'comics'],
    ];

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'user',
        'creation',
        'roles',
    ];
}
