<?php

namespace App\Helpers;

use App\Models\Bug;
use App\Models\Stage;

class BugPositionManager
{
    private $bug;
    private $sibling;
    private $targetStage;
    private $data = [];

    public function __construct(Bug $bug, Bug|null $sibling, Stage $targetStage)
    {
        $this->bug = $bug;
        $this->sibling = $sibling;
        $this->targetStage = $targetStage;
    }

    public function updateData()
    {
        $this->setResolvedStatus();
        $this->updateSortOrder();
        $this->bug->update($this->data);
    }

    private function setResolvedStatus()
    {
        $this->data['is_resolved'] = $this->targetStage->is_final ? 1 : 0;
    }

    private function updateSortOrder()
    {
        if ($this->sibling) {
            $this->handleSiblingSortOrder();
        } else {
            $this->handleNoSiblingSortOrder();
        }
    }

    private function handleSiblingSortOrder()
    {
        if ($this->sibling->sort < $this->bug->sort) {
            $this->data['sort'] = $this->sibling->sort;
        } else {
            $this->data['sort'] = $this->sibling->sort <= 1 ? 1 : ($this->sibling->sort - 1);
        }

        if ($this->targetStage->id != $this->bug->stage_id) {
            $this->bug->resortOthers = false;
            $this->data['stage_id'] = $this->targetStage->id;
            $this->data['sort'] = $this->sibling->sort;

            Bug::where('stage_id', $this->targetStage->id)
                ->where('sort', '>=', $this->sibling->sort)
                ->increment('sort');
        }
    }

    private function handleNoSiblingSortOrder()
    {
        $this->data['sort'] = count($this->targetStage->bugs)
            ? Bug::where('stage_id', $this->targetStage->id)->max('sort') + 1
            : 1;

        if ($this->targetStage->id == $this->bug->stage_id) {
            $this->data['sort']--;
        } else {
            $this->bug->resortOthers = false;
            $this->data['stage_id'] = $this->targetStage->id;
        }
    }
}
