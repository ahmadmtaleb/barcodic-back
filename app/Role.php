<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * @var string
    */
    protected $table = 'roles';
    protected $fillable = ['name'];

    /**
     * @var array
    */
    protected $guarded = [];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }   
}
