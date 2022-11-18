<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use Notifiable;
    use HasMediaTrait;

    protected $guarded;
    protected $with = ['account'];


    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(160)
            ->height(160);
    }


    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function account(){
        return $this->hasOne(Account::class, 'user_id');
    }

    public function transactions(){
        return $this->hasMany(Transactions::class, 'user_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function nextOfKin()
    {
        return $this->hasMany(NextOfKin::class, 'user_id');
    }

    public function cards()
    {
        return $this->hasMany(RequestCard::class, 'user_id');
    }

    public function getProfilePicAttribute($value) {
        if(!$this->attributes['avatar']) {
            $colors = ['E91E63', '9C27B0', '673AB7', '3F51B5', '0D47A1', '01579B', '00BCD4', '009688', '33691E', '1B5E20', '33691E', '827717', 'E65100',  'E65100', '3E2723', 'F44336', '212121'];
            $background = $colors[$this->id%count($colors)];
            return "https://ui-avatars.com/api/?size=256&background=".$background."&color=fff&name=".urlencode($this->last_name .' '. $this->first_name);
        }
        return '/storage/avatar/' . $this->attributes['avatar'];
    }


    public function notifyUser(){
        return $this->hasMany('App\Message', 'user_id');
    }

    public function unread_msg(){
        $unread_msg = Message::whereUserId($this->id)->where('read', 0)->count();
        return $unread_msg;
    }
    public function read_msg(){
        $read_msg = Message::whereUserId($this->id)->where('read', 1)->count();
        return $read_msg;
    }

    public function admin_status()
    {
        if ($this->status == 1){
            return "<i class='mdi mdi-star-circle member-star text-success' title='verified user'></i>";
        }else{
            return "<i class='mdi mdi-star-circle member-star text-danger' title='unverified user'></i>";
        }
    }
    public function status()
    {
        if ($this->status == 1){
            return "<p class='fs-12 mb-0 text text-success'>Verified</p>";
        }else{
            return "<p class='fs-12 mb-0 text text-danger'>Unverified</p>";
        }
    }


}
