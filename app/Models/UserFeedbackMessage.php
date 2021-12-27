<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFeedbackMessage extends Model
{
    use SoftDeletes;

    const TYPE_USER = 1;
    const TYPE_ADMIN = 0;

    public $guarded = ["id"];

    public function feedback()
    {
        return $this->belongsTo(UserFeedback::class,'user_feedback_id');
    }
}
