<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use Illuminate\Support\Facades\Crypt;


class ApplicantInfo extends Model
{
    use UUID, HasFactory;
    protected $fillable = ['cid_no','name','gender','dzongkhag_id','gewog_id','village_id','contact_no'];

    public function setCidNoAttribute($value){
        $this->attributes['cid_no']=Crypt::encryptString($value);
      }
      public function setNameAttribute($value){
          $this->attributes['name']=Crypt::encryptString($value);
        }
      public function setContactNoAttribute($value){
          $this->attributes['contact_no']=Crypt::encryptString($value);
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
}
