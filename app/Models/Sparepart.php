<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sparepart extends Model
{
    use HasFactory;
    protected $fillable=['sparepart_type_id','name','stock','minimum_stock'];
public function sparepartType(){return $this->belongsTo(SparepartType::class);}
public function movements(){return $this->hasMany(SparepartMovement::class);}
}
