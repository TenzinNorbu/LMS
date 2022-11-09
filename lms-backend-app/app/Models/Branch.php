<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;



class Branch extends Model implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;
    protected $fillable = ['id','branch_code','branch_name'];

}
