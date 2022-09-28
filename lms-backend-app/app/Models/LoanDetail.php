<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;


class LoanDetail extends Model
{
    use UUID, HasFactory;
    protected $fillable = ['applicant_id','loan_type_id','loan_amount','loan_duration','loan_start_date','loan_end_date'];
}
