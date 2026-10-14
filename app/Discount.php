<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function variations()
    {
        return $this->belongsToMany(\App\Variation::class, 'discount_variations', 'discount_id', 'variation_id');
    }
}
