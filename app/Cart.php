<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $fillable = ['id','content','userEmail'];
    public $incrementing = false;
    
    public function items () {
        return $this->hasMany('App\CartItem', 'Cart_id');
    }
}
