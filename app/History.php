<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class History extends Model
{
    use SoftDeletes;
    protected $guarded = [];


    /**
     * Get the product that owns the History
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

        /**
     * Get the product that owns the History
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function market(): BelongsTo
    {
        return $this->belongsTo('App\Market', 'market_id');
    }
    
}
