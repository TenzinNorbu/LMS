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
        'employee_full_name',
        'employment_id',
        'branch_id',
        'department_id',
        'email',
        'designation',
        'phone_no',
        'profile_url',        
        'user_id',
        'password',
        //'confirm_password',
        'user_status'
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
    
    public function setEmployeeFullNameAttribute($value){
      $this->attributes['employee_full_name']=Crypt::encryptString($value);
    }
    public function setEmploymentIdAttribute($value){
        $this->attributes['employment_id']=Crypt::encryptString($value);
      }
    public function setPhoneNoAttribute($value){
        $this->attributes['phone_no']=Crypt::encryptString($value);
      }
    public function setEmailAttribute($value){
        $this->attributes['email']=Crypt::encryptString($value);
      }
    public function setDepartmentIdAttribute($value){
        $this->attributes['department_id']=Crypt::encryptString($value);
      }
    public function setBranchIdAttribute($value){
        $this->attributes['branch_id']=Crypt::encryptString($value);
      }
    // public function setUserIdAttribute($value){
    //     $this->attributes['user_id']=Crypt::encryptString($value);
    //   }
    public function setDesignationAttribute($value){
        $this->attributes['designation']=Crypt::encryptString($value);
      }

    public function getEmployeeFullNameAttribute($value){
      try{
        return Crypt::decryptString($value);
      }catch(\Exception $e){
          return $value;    
      }
    }  
    public function getEmploymentIdAttribute($value){
        try{
          return Crypt::decryptString($value);
        }catch(\Exception $e){
            return $value;    
        }
      }  
    public function getPhoneNoAttribute($value){
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
    //   public function getUserIdAttribute($value){
    //     try{
    //       return Crypt::decryptString($value);
    //     }catch(\Exception $e){
    //         return $value;    
    //     }
    //   }  
    public function getDesignationAttribute($value){
        try{
          return Crypt::decryptString($value);
        }catch(\Exception $e){
            return $value;    
        }
      }  
    public function getBranchIdAttribute($value){
        try{
          return Crypt::decryptString($value);
        }catch(\Exception $e){
            return $value;    
        }
      }  
      public function getDepartmentIdAttribute($value){
        try{
          return Crypt::decryptString($value);
        }catch(\Exception $e){
            return $value;    
        }
      }  
}
