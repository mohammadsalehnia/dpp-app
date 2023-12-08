<?php

namespace Src\UsersAccess\AccessService;

use App\Models\User;
use Src\UsersAccess\Models\Product;
use Src\UsersAccess\Models\Subscription;

class SubscriptionVerifier extends Verifier
{
    public function hasAccess(User $user, Product $product): bool
    {
        $subscription = Subscription::findByUserAndProduct($user, $product);

        if (!$subscription) {
            return false;
        }

        return parent::hasAccess($user, $product);
    }
}
