<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AssetType extends Model
{
    use HasFactory;
    protected $fillable = ['name','category','depreciation_method','useful_life_months'];
public function assets(){return $this->hasMany(Asset::class);}
}
