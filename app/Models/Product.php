<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory,  InteractsWithMedia;
    protected $fillable = ['title', 'price', 'description', 'r_id', 'category_id'];
    protected $appends = ['preview', 'thumb'];
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('products')
            ->singleFile()
            ->useDisk('product');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->crop(Manipulations::CROP_CENTER, 350, 350)
            ->nonQueued();
        $this->addMediaConversion('preview')
            ->width(350)
            ->height(350)
            ->crop(Manipulations::CROP_CENTER, 350, 350)
            ->nonQueued();
    }
    public function getPreviewAttribute()
    {
        $image = $this ->getFirstMediaUrl('products', 'preview');
        return $image;
    }
    public function getThumbAttribute()
    {
        $image = $this ->getFirstMediaUrl('products', 'thumb');
        return $image;
    }
}
