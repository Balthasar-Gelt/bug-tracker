<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ninoman\LaravelSortable\Sortable;

class Bug extends Model
{
    use HasFactory;
    use Sortable;

    public $timestamps = false;
    public $sortIndexColumn = 'sort';
    public $sortingParentColumn = 'stage_id';
    public $startSortingFrom = 1;
    protected $fillable = ['name', 'short_description', 'description', 'assignee', 'project_id', 'stage_id', 'priority_id', 'is_resolved', 'created_by', 'sort'];

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getAssigneeAttribute($value)
    {
        return User::find($value);
    }
    public function getIsResolvedAttribute($value)
    {
        return $value ? true : false;
    }
}
