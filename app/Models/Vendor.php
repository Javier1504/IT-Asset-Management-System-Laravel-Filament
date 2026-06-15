<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory;
    use BelongsToCompany, SoftDeletes;
protected $fillable=['company_id','name','pic_name','email','phone','address','category','status','notes'];
public function offers(){return $this->hasMany(VendorOffer::class);}
}
