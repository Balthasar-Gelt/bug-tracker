<?php

namespace App\Traits;

use App\Models\Stage;

trait UpdateStageSerialNumberTrait
{
    public function updatePosition(int $elId, int $siblingId): array
    {
        $elStage = Stage::find($elId);
        $siblingStage = Stage::find($siblingId);

        $tempSerialNum = $elStage->serial_number;

        $elStage->update(['serial_number' => $siblingStage->serial_number]);
        $siblingStage->update(['serial_number' => $tempSerialNum]);

        return [$elStage, $siblingStage];
    }
}
