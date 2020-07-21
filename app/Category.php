<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * @var string
    */
    protected $table = 'categories';
    protected $fillable = ['english_name', 'arabic_name'];

    /**
     * @var array
    */
    protected $guarded = [];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Item');
    }
}
