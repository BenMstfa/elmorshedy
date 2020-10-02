<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('create-projects', function () {
    $faker = \Faker\Factory::create('en');
    $fakerAr = \Faker\Factory::create('ar');

    $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::query()->get();

    \App\Models\Project::query()->whereNotIn('id', [54])->get()
        ->map(function (\App\Models\Project $project) use ($media) {
            $media->map(function ($m) use ($project) {
                $mediaArray = $m->toArray();

                unset($mediaArray['id']);

                $mediaArray['model_id'] = $project->id;

                \Spatie\MediaLibrary\MediaCollections\Models\Media::query()->create($mediaArray);
            });
        });
});
