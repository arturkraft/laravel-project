<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'company', 'logo', 'location', 'website', 'email', 'description', 'tags', 'user_id'];

    public function scopeFilter($query, array $filters) {
        if(isset($filters['tag'])){
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }

        if(isset($filters['search'])){
            $query->where('title', 'like', '%' . request('search') . '%') 
            -> orWhere('description', 'like', '%' . request('search') . '%')
            -> orWhere('tags', 'like', '%' . request('search') . '%');
        }
    }

    //relationship to user
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
