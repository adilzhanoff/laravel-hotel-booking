<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\View;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'number', 'description', 'category_id', 'view_id', 'rate'
    ];

    public function users() {
        return $this->belongsToMany(
            'App\Models\User',
            'users_rooms',
            'room_id',
            'user_id'
        )->withPivot('start', 'finish', 'hours', 'total_price');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function view(){
        return $this->belongsTo(View::class);
    }
}
