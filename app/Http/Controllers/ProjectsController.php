<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;

class ProjectsController extends Controller
{
    public function index()
    {
        return Inertia::render('Projects');
    }

    public function datatable()
    {
        return DataTables::of(Project::query())->make(true);
    }

    public function create()
    {
        return Inertia::render('CreateProject');
    }

    public function store(Request $request)
    {
        $project = Project::query()->create([
            'name' => [
                'ar' => $request->input('name_ar'),
                'en' => $request->input('name_en')
            ],
            'description' => [
                'ar' => $request->input('description_ar'),
                'en' => $request->input('description_en')
            ]
        ]);

        collect(array_fill(0, $request->input('images_length'), 'image'))
            ->map(function ($image, $index) use ($project, $request) {
                $project
                    ->addMediaFromRequest("{$image}_{$index}")
                    ->setFileName(fileRandomName($request->file("{$image}_{$index}")))
                    ->toMediaCollection('photos');
            });

        return Response::json([
            'success' => true,
            'message' => 'Project created successfully'
        ]);
    }

    public function getUpdate($id)
    {
        $project = Project::query()
            ->with(['media' => function ($query) {
                $query->where('collection_name', 'photos');
            }])
            ->find($id);

        $project->media->each(function ($image) {
            $image->url = $image->getFullUrl();
        });

        return Inertia::render('UpdateProject', [
            'project' => $project
        ]);
    }

    public function update(Request $request, $id)
    {
        $project = Project::query()->find($id);

        $project->update([
            'name' => [
                'ar' => $request->input('name_ar'),
                'en' => $request->input('name_en')
            ],
            'description' => [
                'ar' => $request->input('description_ar'),
                'en' => $request->input('description_en')
            ]
        ]);

        if ($request->has('removed_images') && count(($removed = json_decode($request->input('removed_images'), true))) > 0) {
            $project->media()->whereIn('id', $removed)->forceDelete();
        }

        if ($request->input('images_length') && $request->input('images_length') > 0) {
            collect(array_fill(0, $request->input('images_length'), 'image'))
                ->map(function ($image, $index) use ($project, $request) {
                    $project
                        ->addMediaFromRequest("{$image}_{$index}")
                        ->setFileName(fileRandomName($request->file("{$image}_{$index}")))
                        ->toMediaCollection('photos');
                });
        }

        return Response::json([
            'success' => true,
            'message' => 'Project Updated Successfully'
        ]);
    }

    public function delete($id)
    {
        Project::query()->find($id)->forceDelete();

        return Response::json([
            'success' => true,
            'message' => 'Project deleted successfully'
        ]);
    }
}
