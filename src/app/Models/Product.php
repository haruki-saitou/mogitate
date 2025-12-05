<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Season;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
    ];

    public function seasons(): BelongsToMany
    {
        return $this->belongsToMany(Season::class, 'product_season');
    }

    public function scopeKeywordSearch($query, $keyword){
        if(!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%");
            return $query;
        }
    }

}
