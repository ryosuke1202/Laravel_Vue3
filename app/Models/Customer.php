<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kana',
        'tel',
        'email',
        'postcode',
        'address',
        'birthday',
        'gender',
        'emmemoail'
    ];

    public function scopeSearchCustomers($query, $input = null)
    {
        if (!empty($input)) {
            $customer = $query
                ->where('kana', 'like', $input . '%' )
                ->orWhere('tel', 'like', $input . '%');

            return $customer;
        } 
    }
}
