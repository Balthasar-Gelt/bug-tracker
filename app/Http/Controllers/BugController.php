<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use Inertia\Inertia;
use App\Models\Priority;
use App\Http\Requests\BugRequest;
use Illuminate\Support\Facades\Redirect;

class BugController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($projectId, $stageId)
    {
        return Inertia::render('Bug/Create', [
            'priorities' => Priority::all(),
            'project' => $projectId,
            'stage' => $stageId,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BugRequest $request, $projectId, $stageId)
    {
        Bug::create(
            $request->validated() + [
                'project_id' => $projectId,
                'stage_id' => $stageId,
            ],
        );

        return Redirect::route('projects.stages.index', $projectId);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bug  $bug
     * @return \Illuminate\Http\Response
     */
    public function edit($projectId, $stageId, Bug $bug)
    {
        return Inertia::render('Bug/Edit', [
            'bug' => $bug,
            'project' => $projectId,
            'stage' => $stageId,
            'priorities' => Priority::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bug  $bug
     * @return \Illuminate\Http\Response
     */
    public function update(BugRequest $request, $projectId, $stageId, Bug $bug)
    {
        $bug->update($request->validated());

        return Redirect::route('projects.stages.index', $projectId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bug  $bug
     * @return \Illuminate\Http\Response
     */
    public function destroy($projectId, $stageId, Bug $bug)
    {
        $bug->delete();

        return Redirect::back();
    }
}
