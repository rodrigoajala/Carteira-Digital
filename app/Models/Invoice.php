<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
        'value'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
