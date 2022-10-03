<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
//use App\Traits\UUID;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;




class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    // use HasApiTokens, HasFactory, Notifiable, HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cid_no',
        'gender',
        'emp_id',
        'branch_id',
        'department_id',
        'contact_no',
        'profile_url',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }  
    
    public function setCidNoAttribute($value){
      $this->attributes['cid_no']=Crypt::encryptString($value);
    }
    public function setNameAttribute($value){
        $this->attributes['name']=Crypt::encryptString($value);
      }
    public function setContactNoAttribute($value){
        $this->attributes['contact_no']=Crypt::encryptString($value);
      }
    public function setEmailAttribute($value){
        $this->attributes['email']=Crypt::encryptString($value);
      }

    
      public function getCidNoAttribute($value){
      try{
        return Crypt::decryptString($value);
      }catch(\Exception $e){
          return $value;    
      }
    }  

    public function getNameAttribute($value){
        try{
          return Crypt::decryptString($value);
        }catch(\Exception $e){
            return $value;    
        }
      }  
    public function getContactNoAttribute($value){
        try{
          return Crypt::decryptString($value);
        }catch(\Exception $e){
            return $value;    
        }
      }  
    public function getEmailAttribute($value){
        try{
          return Crypt::decryptString($value);
        }catch(\Exception $e){
            return $value;    
        }
      }  
}
