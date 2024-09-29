<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class todo extends Model
{
    protected $table = "todos";
    protected $primaryKey = "id";
    protected $keyType = "int";
    protected $fillable = [
        "todo",
        "user_id"
    ];

    public $incrementing = true;
    public $timestamps = true;

//    public function user(): BelongsTo
//    {
//        return $this->belongsTo(User::class);
//    }
}
