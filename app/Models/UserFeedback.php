<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFeedback extends Model
{
    use SoftDeletes;
    
    protected $table = 'user_feedbacks';
    public $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resturant()
    {
        return $this->belongsTo(Resturant::class);
    }

    public function reason()
    {
        return $this->belongsTo(UserFeedbackReason::class,'reason_id')->withTrashed();
    }

    public function messages()
    {
        return $this->hasMany(UserFeedbackMessage::class,'user_feedback_id');
    }
}
