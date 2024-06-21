<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name', 'short_description', 'description', 'created_by'];

    public function getCreatedByAttribute($value)
    {
        return User::find($value);
    }

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    public function bugs()
    {
        return $this->hasMany(Bug::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
