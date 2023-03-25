<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'price', 'product_type_id', 'created_by', 'status_id'];


    public function seller()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function scopeFilterFromRequest($query)
    {
        if (request()->filled('search')) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . request()->get('search') . '%')
                    ->orWhereHas('seller', function ($q) {
                        $q->where('name', 'like', '%' . request()->get('search') . '%');
                    });
            });
        }
        if (request()->filled('product_name')) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . request()->get('product_name') . '%');
            });
        }

        if (request()->filled('seller_name')) {
            $query->where(function ($q) {
                $q->WhereHas('seller', function ($q) {
                    $q->where('name', 'like', '%' . request()->get('seller_name') . '%');
                });
            });
        }
    }
}
