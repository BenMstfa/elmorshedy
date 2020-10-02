<?php

use Illuminate\Http\UploadedFile;

function fileRandomName(UploadedFile $file)
{
    return \Illuminate\Support\Str::random('8') . '.' . $file->getClientOriginalExtension();
}

function getMediaCollectionObjects(\Illuminate\Support\Collection $collection, $urlType = 'Url')
{
    return $collection->map(function ($m) use ($urlType) {
        return [
            'id' => $m->id,
            'name' => $m->name,
            'full_url' => $m->{"get$urlType"}()
        ];
    });
}

function getMediaCollectionURLs(\Illuminate\Support\Collection $collection, $urlType = 'Url')
{
    return $collection->map(function ($m) use ($urlType) {
        return $m->{"get$urlType"}();
    });
}


function fullPhotoUrl($url)
{
    return $url ? config('app.url') . $url : null;
}
