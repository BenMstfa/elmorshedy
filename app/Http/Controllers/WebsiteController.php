<?php

namespace App\Http\Controllers;

use App\Models\Project;

class WebsiteController extends Controller
{
    public function index()
    {
        $projects = Project::query()->with(['media'])->paginate(3);

        collect($projects->items())->each->append('photos');

        return view('welcome', [
            'projects' => $projects,
        ]);
    }

    public function projectDetails($id)
    {
        return view('details', [
            'project' => Project::query()->find($id)->append('photos'),
        ]);
    }

}
