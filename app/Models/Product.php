<?php

namespace App\Models;

use App\Notifications\NewProductNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
class Product extends Model
{
    use HasFactory, SoftDeletes, Notifiable;
    protected $fillable = ['name', 'price', 'product_type_id', 'created_by', 'status_id'];


    protected static function booted()
    {
        static::updating(function ($model) {
            $dirty = $model->getDirty();
            foreach ($dirty as $field => $value) {
                $log[] = [
                    'field' => $field,
                    'old_value' => $model->getOriginal($field),
                    'new_value' => $value,
                    'updated_by' => $model->seller->name, // assuming you have authentication set up
                    'updated_at' => now(),
                ];
            }
            Storage::append('product_logs.log', json_encode($log));
        });
    }
    public function sendProductAddedNotification()
    {
        $user = $this->seller;
        $user->notify(new NewProductNotification($this));
    }

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
