<?php
namespace App\Models;

use App\Models\items;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Img extends Model
{
    use HasFactory;
    protected $fillable = [
        'src',
        'color',
        'item_id',
    ];
    public function item()
    {
        return $this->belongsTo(items::class, 'item_id');
    }

}
