<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogManagement extends Model{
    use HasFactory;
    protected $fillable = ['id','user_id','register_date','password_change_date','login_date','logout_date'];
}
