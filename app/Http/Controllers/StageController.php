<?php

namespace App\Http\Controllers;

use App\Http\Requests\StageRequest;
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
    public function index($projectId)
    {
        $stages = Stage::where('project_id', $projectId)
            ->with(['bugs.priority', 'project'])
            ->orderBy('serial_number')
            ->get();

        $project = Project::findOrFail($projectId);

        return Inertia::render('Stage/Index', [
            'stages' => $stages,
            'project' => $project,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($projectId)
    {
        return Inertia::render('Stage/Create', [
            'project' => $projectId,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StageRequest $request, $projectId)
    {
        Stage::create(
            $request->validated() + [
                'project_id' => $projectId,
                'serial_number' => $this->setDefaultValue($projectId),
            ],
        );

        return Redirect::route('projects.stages.index', $projectId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function update(StageRequest $request, $projectId , Stage $stage)
    {
        $stage->update($request->validated());

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function destroy($projectId, Stage $stage)
    {
        $stage->delete();

        return Redirect::back();
    }
}
