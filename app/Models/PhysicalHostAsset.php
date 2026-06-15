<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PhysicalHostAsset extends Model
{
    use HasFactory;
    protected $fillable=['asset_id','hostname','ip_address','os'];
public function asset(){return $this->belongsTo(Asset::class);}
}
