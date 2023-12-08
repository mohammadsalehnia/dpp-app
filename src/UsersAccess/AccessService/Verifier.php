<?php

namespace Src\UsersAccess\AccessService;

use App\Models\User;
use Src\UsersAccess\Models\Product;

abstract class Verifier
{
    private Verifier $nextVerifier;

    /**
     * @param Verifier|null $nextVerifier
     */
    public function __construct(Verifier $nextVerifier = null)
    {
        $this->nextVerifier = $nextVerifier;
    }

    public function hasAccess(User $user, Product $product): bool
    {
        if (!$this->nextVerifier) {
            return true;
        }
        return $this->nextVerifier->hasAccess($user, $product);
    }

}
