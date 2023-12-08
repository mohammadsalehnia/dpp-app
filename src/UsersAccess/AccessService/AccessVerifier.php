<?php

namespace Src\UsersAccess\AccessService;

use App\Models\User;
use Src\UsersAccess\Models\Product;

class AccessVerifier
{
    public function hasAccess(User $user, Product $product): bool
    {
        return $this->buildAccessChain()->hasAccess($user, $product);
    }

    protected function buildAccessChain(): Verifier
    {
        $subscriptionExpiration = new SubscriptionExpirationVerifier();
        $subscriptionActivation = new SubscriptionActivationVerifier($subscriptionExpiration);
        $subscriptionVerifier = new SubscriptionVerifier($subscriptionActivation);
        return new UserActivationVerifier($subscriptionVerifier);
    }

//    protected function buildViewAccessChain(): Verifier
//    {
//        $subscriptionExpiration = new SubscriptionExpirationVerifier();
//        $subscriptionVerifier = new SubscriptionVerifier($subscriptionActivation);
//        return new UserActivationVerifier($subscriptionVerifier);
//    }
}
