<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SparepartType extends Model
{
    use HasFactory;
    protected $fillable=['name','category'];
public function spareparts(){return $this->hasMany(Sparepart::class);}
}
