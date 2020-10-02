<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * @property Collection media
 * @property array name
 * @property array description
 * */
class Project extends Model implements HasMedia
{
    use InteractsWithMedia, HasTranslations;

    public $translatable = ['name', 'description'];

    protected $guarded = ['id'];

    /**
     * Begin querying the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder|self
     */
    public static function query()
    {
        return (new static)->newQuery();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photos');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getPhotosAttribute()
    {
        return getMediaCollectionURLs($this->media, 'FullUrl');
    }
}
