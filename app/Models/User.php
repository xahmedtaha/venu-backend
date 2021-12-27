<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\SMS\SendSms;
use Illuminate\Database\Eloquent\Builder;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    //
    use SoftDeletes,HasApiTokens,SendSms;

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function customToken()
    {
        return $this->hasOne(OAuthAccessToken::class,'user_id')->where('name',"user_app");
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * @return Builder
     */
    public function orders()
    {
        $orderIds = $this->carts()->pluck('order_id')->toArray();
        return Order::whereIn('id',$orderIds);
    }

    public static function testSms($number)
    {
        SendSms::send($number,'رسالة تجريبية');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function notifications()
    {
        return Notification::where('user_id',$this->id)->orWhere('user_id',0);
    }

    public function resturants()
    {
        return $this->belongsToMany(Resturant::class,'orders');
    }

    public function feedbacks()
    {
        return $this->hasMany(UserFeedback::class);
    }

    public function initCart(BranchTable $table,Order $order)
    {
        $this->carts()->update(['active'=>false]);
        return $this->carts()->create([
            'table_id' => $table->id,
            'order_id' => $order->id
        ]);
    }

    public function getActiveCartAttribute()
    {
        return $this->carts()->where('active',true)->first();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
