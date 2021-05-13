<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $fillable = ['name', 'description', 'project_id', 'stage_id', 'priority_id'];

    public function priority(){

        return $this->belongsTo(Priority:: class);
    }

    public function stage(){

        return $this->belongsTo(Stage::class);
    }
}
