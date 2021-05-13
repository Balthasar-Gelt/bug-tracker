<?php

namespace App\Traits;

use App\Models\Stage;

trait SetStageSerialNumberTrait{

    public function setDefaultValue(int $projectId){

        $value = 1;

        $oldStage = Stage::where('project_id', $projectId)
                        ->orderByDesc('serial_number')
                        ->first();

        if($oldStage == null) return $value;

        return ($oldStage->serial_number + $value);
    }
}