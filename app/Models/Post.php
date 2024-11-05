<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'locationName',
        'address',
        'city',
        'created_by'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, "created_by");
    }


}
