<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * @var string
    */
    protected $table = 'items';
    protected $fillable = ['english_name', 'arabic_name', 'barcode', 'price', 'category_id'];

    /**
     * @var array
    */
    protected $guarded = [];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->belongsTo('App\Category');
    }
}
