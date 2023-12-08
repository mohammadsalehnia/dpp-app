<?php

namespace Src\UsersAccess\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'expires_at',
        'amount',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $dates = [
        'expires_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function findByUserAndProduct(User $user, Product $product): Model|null
    {
        return self::query()
            ->where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isInactive(): bool
    {
        return !$this->isActive();
    }

    public function isExpired(): bool
    {
        return Carbon::now()->gt($this->expires_at);
    }

}
