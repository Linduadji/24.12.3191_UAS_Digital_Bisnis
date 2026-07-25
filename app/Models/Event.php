<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $category_id
 * @property int $organization_id
 * @property string $title
 * @property string $description
 * @property \Carbon\Carbon $date
 * @property string $location
 * @property int $price
 * @property int $stock
 * @property string|null $poster_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Event extends Model
{
    protected $fillable = [
        'organization_id', 'category_id', 'title', 'description', 'date', 
        'location', 'price', 'stock', 'poster_path'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function transactions()
    {   
        return $this->hasMany(Transaction::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
