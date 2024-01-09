<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\CompetitionJoinCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Certificate extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    public $guarded=[];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function competition_join_category()
    {
        return $this->belongsTo(CompetitionJoinCategory::class);
    }
}
