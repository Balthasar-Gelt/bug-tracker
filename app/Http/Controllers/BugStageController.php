<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Traits\UpdateBugStageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BugStageController extends Controller
{
    use UpdateBugStageTrait;

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $projectId, $stageId, Bug $bug_stage)
    {

        $this->updateBugStage($projectId, $request->operator, $bug_stage);

        return Redirect::back();
    }
    
}
