<?php

namespace App\Http\Controllers;

use App\Http\Requests\StageRequest;
use App\Models\Priority;
use App\Models\Project;
use Inertia\Inertia;
use App\Models\Stage;
use App\Traits\SetStageSerialNumberTrait;
use Illuminate\Support\Facades\Redirect;

class StageController extends Controller
{
    use SetStageSerialNumberTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $stages = Stage::where('project_id', $project->id)
            ->with(['bugs' => function ($query) {
                $query->orderBy('sort', 'asc');
            }, 'bugs.priority', 'project'])
            ->orderBy('id')
            ->get();

        return Inertia::render('Stage/Index', [
            'stages' => $stages,
            'project' => Project::where('id', $project->id)->with(['users' => function ($query) {
                $query->select('id', 'name', 'email');
            }])->first()->toArray(),
            'priorities' => Priority::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        return Inertia::render('Stage/Create', [
            'project' => $project,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StageRequest $request, Project $project)
    {
        Stage::create(
            $request->validated() + [
                'project_id' => $project->id,
            ],
        );

        return Redirect::back()->with('message', 'Stage created successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function update(StageRequest $request, Project $project, Stage $stage)
    {
        $stage->update($request->validated());

        return Redirect::back()->with('message', 'Stage updated successfully');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Stage $stage)
    {
        $stage->delete();

        return Redirect::back()->with('message', 'Stage deleted successfully');;
    }
}
