<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'city',
        'country'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
