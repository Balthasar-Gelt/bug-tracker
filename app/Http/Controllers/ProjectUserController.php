<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectUserRequest;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProjectUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        return Inertia::render('ProjectUser/Index', [
            'users' => User::all()->except([Auth::user()->id]),
            'project' => $project,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectUserRequest $request, Project $project)
    {
        $request->validated();

        $project->users()->sync(array($request->all() + ['project_id' => $project->id]), false);

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, $projectUserId)
    {
        if ($project->created_by->id != $projectUserId) {
            $project->users()->detach($projectUserId);
        }

        return Redirect::back();
    }
}
