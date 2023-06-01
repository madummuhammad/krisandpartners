<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Certificate;

class CompetitionJoinCategory extends Model
{
    use HasFactory;
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
        return $this->belongsTo(Category::class,'category_id');
    }

    public function competition_join()
    {
        return $this->belongsTo(CompetitionJoin::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function certificate()
    {
        return $this->belongsTo(Certificate::class,'id','competition_join_category_id');
    }
}
