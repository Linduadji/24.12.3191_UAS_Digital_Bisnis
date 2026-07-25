<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    // Menandakan atribut: 1 Kategori dapat memiliki banyak list Event
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
