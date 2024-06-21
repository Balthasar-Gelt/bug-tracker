<?php

namespace App\Http\Controllers;

use App\Helpers\BugPositionManager;
use App\Http\Requests\BugPositionRequest;
use App\Models\Bug;
use Inertia\Inertia;
use App\Models\Priority;
use App\Http\Requests\BugRequest;
use App\Http\Requests\UpdateBugRequest;
use App\Models\Project;
use App\Models\Stage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BugController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bug  $bug
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, Stage $stage, Bug $bug)
    {
        return Inertia::render('Bug/Show', [
            'priorities' => Priority::all(),
            'project' => Project::where('id', $project->id)->with(['users' => function ($query) {
                $query->select('id', 'name', 'email');
            }])->first()->toArray(),
            'stage' => $stage,
            'bug' => $bug,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project, Stage $stage)
    {
        return Inertia::render('Bug/Create', [
            'priorities' => Priority::all(),
            'project' => $project,
            'stage' => $stage,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BugRequest $request, Project $project, Stage $stage)
    {
        Bug::create(
            $request->validated() + [
                'created_by' => Auth::user()->id,
            ],
        );

        return Redirect::back()->with('message', 'Bug created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bug  $bug
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, Stage $stage, Bug $bug)
    {
        return Inertia::render('Bug/Edit', [
            'bug' => $bug,
            'project' => $project,
            'stage' => $stage,
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
    public function update(UpdateBugRequest $request, Project $project, Stage $stage, Bug $bug)
    {
        $bug->update($request->validated());

        return Redirect::back()->with('message', 'Bug updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bug  $bug
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Stage $stage, Bug $bug)
    {
        $bug->delete();

        return Redirect::back()->with('message', 'Bug deleted successfully');;
    }

    /**
     * Update position attribute of the Bug
     * 
     * @param  \App\Models\Bug  $bug
     * @return \Illuminate\Http\Response
     */
    public function updatePosition(BugPositionRequest $request, Project $project, Stage $stage, Bug $bug)
    {
        $validated = $request->validated();
        $bugPositionManager = new BugPositionManager($bug, Bug::find($validated['sibling_id']), Stage::find($validated['target_id']));

        $bugPositionManager->updateData();

        return Redirect::back();
    }
}
