<?php

namespace Src\UsersAccess\AccessService;

use App\Models\User;
use Src\UsersAccess\Models\Product;

class UserActivationVerifier extends Verifier
{
    public function hasAccess(User $user, Product $product): bool
    {
        if ($user->isInactive()) {
            return false;
        }

        return parent::hasAccess($user, $product);
    }
}
