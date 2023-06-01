<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CompetitionJoin extends Model
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

    public function competition_join_category()
    {
        return $this->hasMany(CompetitionJoinCategory::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function payment()
    {
        return $this->belongsTo(CompetitionJoinPayment::class,'id','competition_join_id');
    }
}
