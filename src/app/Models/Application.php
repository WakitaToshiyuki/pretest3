<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;

    public function getStatusLabel(){
        return match($this->status){
            self::STATUS_PENDING => '承認待ち',
            self::STATUS_APPROVED => '承認済み',
        };
    }

    protected $fillable=['user_id','work_id','update_start_time','update_finish_time','reason','status'];

    public function application_rests(){
        return $this->hasMany(ApplicationRest::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function work(){
        return $this->belongsTo(Work::class);
    }
}