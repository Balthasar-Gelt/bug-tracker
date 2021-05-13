<?php

namespace App\Traits;

use App\Models\Stage;

trait UpdateStageSerialNumberTrait{

    public function updatePosition(int $projectId, Stage $stage, string $operator){

        $val = null;

        if($operator == 'down')
            $val = Stage::where('project_id', $projectId)->where('serial_number', '<', $stage->serial_number)
                ->orderByDesc('serial_number')
                ->first();

        else if($operator == 'up')
            $val = Stage::where('project_id', $projectId)->where('serial_number', '>', $stage->serial_number)
                ->orderBy('serial_number')
                ->first();

        if($val != null){

            $help = $stage->serial_number;
            $stage->update(['serial_number' => $val->serial_number]);
            $val->update(['serial_number' => $help]);
        }
    }
}