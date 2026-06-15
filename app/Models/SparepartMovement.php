<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SparepartMovement extends Model
{
    use HasFactory;
    protected $fillable=['sparepart_id','asset_id','user_id','type','quantity','notes'];
public function sparepart(){return $this->belongsTo(Sparepart::class);}
public function asset(){return $this->belongsTo(Asset::class);}
public function user(){return $this->belongsTo(User::class);}
}
