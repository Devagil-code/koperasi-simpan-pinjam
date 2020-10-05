<?php

namespace App;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];

    public function module()
    {
        return $this->belongsTo('App\Module');
    }

    public function permission_role()
    {
        return $this->hasMany('App\PermissionRole');
    }

    public function permission_with_role($permission_id, $role_id)
    {
        return PermissionRole::where('permission_id', $permission_id)
                ->where('role_id', $role_id)->first();
    }
}
