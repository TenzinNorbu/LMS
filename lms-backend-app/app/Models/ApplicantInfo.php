<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;


class ApplicantInfo extends Model
{
    use UUID, HasFactory;
    protected $fillable = ['cid_no','name','gender','dzongkhag_id','gewog_id','village_id','contact_no'];

}
