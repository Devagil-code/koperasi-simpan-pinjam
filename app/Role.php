<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    protected $fillable = [
        'display_name'
    ];

    public function permission_role()
    {
        return $this->hasMany('App\PermissionRole');
    }
}
