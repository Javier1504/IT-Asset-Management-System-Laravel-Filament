<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class StockOpnameChecklistTemplate extends Model
{
    use HasFactory;
    protected $fillable=['asset_category','label','key','is_required','is_active'];
protected $casts=['is_required'=>'boolean','is_active'=>'boolean'];
}
