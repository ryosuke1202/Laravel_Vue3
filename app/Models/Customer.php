<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * purchasesテーブルへのリレーション（1対多）
     *
     * @return HasMany
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
