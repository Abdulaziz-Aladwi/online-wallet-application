<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'amount',
        'reference',
        'date',
        'bank_type',
        'meta',
        'user_id',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * Get the user that owns the transaction.
     * 
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
