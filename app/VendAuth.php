<?php

namespace App;

class VendAuth extends \Eloquent
{
    protected $table = "vend_auth";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'access_token',
        'token_type',
        'expires',
        'expires_in',
        'refresh_token',
        'domain_prefix',
    ];

    public function getVendAuth( $user_id ){
        return VendAuth::where('user_id',$user_id)->orderBy('id','DESC')->limit(1)->get()->first();
    }
}
