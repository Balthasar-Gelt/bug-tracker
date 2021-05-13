<?php

namespace App\Traits;

use App\Models\Bug;
use App\Models\Stage;

trait UpdateBugStageTrait{

    public function updateBugStage(int $projectId, string $operator, Bug $bug){

        $val = null;

        if($operator == 'down')
            $val = Stage::where('project_id', $projectId)->where('serial_number', '<', $bug->stage->serial_number)
                ->orderByDesc('serial_number')
                ->first();

        else if($operator == 'up')
            $val = Stage::where('project_id', $projectId)->where('serial_number', '>', $bug->stage->serial_number)
                ->orderBy('serial_number')
                ->first();

        if($val != null)
            $bug->update(['stage_id' => $val->id]);
    }
}