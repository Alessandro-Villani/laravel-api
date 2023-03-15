<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['name', 'description', 'project_url', 'image_url', 'type_id'];

    public function getImageUrl()
    {
        if (substr($this->image_url, 0, 8) === 'projects') return asset('storage/' . $this->image_url);
        return $this->image_url;
    }

    public function hasUploadedImage()
    {
        if (substr($this->image_url, 0, 8) === 'projects') return true;
        return false;
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }
}
