<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\CompetitionJoin;
class Competition extends Model
{
    public $incrementing = true;
    public $timestamps = true;
    public $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'competition_categories', 'competition_id', 'category_id')
        ->withPivot('price')
        ->withTimestamps();
    }

    public function getFromAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getToAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function competition_join()
    {
        return $this->hasMany(CompetitionJoin::class)->where('status','paid');
    }
}