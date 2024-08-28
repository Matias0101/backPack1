<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
//use Str;

class Tag extends Model
{
    use CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    // public function products(): BelongsToMany
    // {
    //     return $this->belongsToMany(Product::class);
    // }
    public function products()
    {
        // return $this->belongsToMany(Product::class, 'product_tag');
        return $this->belongsToMany(Product::class);
    }
    // Mutator to automatically set the slug from the name
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    protected static function boot()
{
    parent::boot();

    static::creating(function ($tag) {
        if (empty($tag->slug)) {
            $tag->slug = Str::slug($tag->name);
        }
    });
}
}
