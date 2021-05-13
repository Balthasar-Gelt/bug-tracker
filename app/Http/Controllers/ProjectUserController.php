<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectUserRequest;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Project;
use Illuminate\Support\Facades\Redirect;

class ProjectUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($projectId)
    {
        $project = Project::findOrFail($projectId);

        return Inertia::render('ProjectUser/Index', [
            'users' => User::all(),
            'project' => $project,
            'projectUsers' => $project->users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectUserRequest $request,  $projectId)
    {
        $project = Project::findOrFail($projectId);

        $request->validated();

        $project->users()->sync(array($request->all() + ['project_id' => $projectId]), false);

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($projectId, $projectUserId)
    {
        $project = Project::findOrFail($projectId);

        $project->users()->detach($projectUserId);

        return Redirect::back();
    }
}
