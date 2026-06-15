<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToCompany;

class AssetMaintenance extends Model
{
    use HasFactory;
    use BelongsToCompany;
protected $fillable=['company_id','form_number','letter_date','technician_id','holder_id','asset_id','maintenance_types','device_type','repair_status','started_at','finished_at','missing_data','backup_data','problem_description','solution','notes','sparepart_requirement'];
protected $casts=['letter_date'=>'date','started_at'=>'datetime','finished_at'=>'datetime','maintenance_types'=>'array','missing_data'=>'boolean'];
public function asset(){return $this->belongsTo(Asset::class);}
public function technician(){return $this->belongsTo(User::class,'technician_id');}
public function holder(){return $this->belongsTo(User::class,'holder_id');}
}
