<?php
namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'image_path', 'created_at', 'updated_at'];
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
