<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;


class CompetitionCategory extends Model
{
    use SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded=[];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'competition_category', 'competition_id', 'category_id')
        ->withTrashed()
        ->withPivot('price');
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id')->withTrashed();
    }
}