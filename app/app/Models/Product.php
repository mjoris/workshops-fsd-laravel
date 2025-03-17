<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'brand_id'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    // DEMO ON SERIALIZATION
    //    protected $hidden = ['user_id', 'brand_id'];
    //
    //    protected $appends = ['code'];
    //
    //    protected function code(): Attribute
    //    {
    //        return Attribute::make(
    //            get: fn (mixed $value, array $attributes) => 'P'.sprintf('%06d', $attributes['id']),
    //        );
    //    }
    //
    //    protected function casts(): array
    //    {
    //        return [
    //            'created_at' => 'datetime:Y-m-d H:m:s',
    //            'updated_at' => 'datetime:Y-m-d H:m:s',
    //        ];
    //    }

}
