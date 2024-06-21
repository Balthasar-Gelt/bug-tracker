<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name', 'project_id', 'serial_number', 'is_final'];

    public function project(){

        return $this->belongsTo(Project::class);
    }

    public function bugs(){

        return $this->hasMany(Bug::class);
    }
}
