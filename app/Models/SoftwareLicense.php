<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoftwareLicense extends Model
{
    use HasFactory;
    use BelongsToCompany, SoftDeletes;
protected $fillable=['company_id','software_name','category','vendor_name','license_type','license_key','total_license','used_license','purchase_date','start_date','expired_date','renewal_reminder_date','pic_user_id','status','notes'];
protected $casts=['purchase_date'=>'date','start_date'=>'date','expired_date'=>'date','renewal_reminder_date'=>'date'];
public function pic(){return $this->belongsTo(User::class,'pic_user_id');}
}
