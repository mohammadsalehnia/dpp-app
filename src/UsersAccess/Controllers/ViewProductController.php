<?php

namespace Src\UsersAccess\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Src\UsersAccess\AccessService\AccessVerifier;
use Src\UsersAccess\Exception\UserDosesNotHaveAccessProductException;
use Src\UsersAccess\Models\Product;

class ViewProductController
{
    private Guard $guard;
    private ResponseFactory $responseFactory;
    private AccessVerifier $accessVerifier;

    /**
     * @param Guard $guard
     * @param ResponseFactory $responseFactory
     * @param AccessVerifier $accessVerifier
     */
    public function __construct(Guard $guard, ResponseFactory $responseFactory, AccessVerifier $accessVerifier)
    {
        $this->guard = $guard;
        $this->responseFactory = $responseFactory;
        $this->accessVerifier = $accessVerifier;
    }

    /**
     * @throws UserDosesNotHaveAccessProductException
     */
    public function __invoke(Request $request, $slug)
    {
        try {
            $product = Product::whereSlug($slug);
            $user = $this->guard->user();

            if (!$user || $product) {
                return $this->responseFactory->json([
                    'Product not found'
                ], 404);
            }

            $hasAccess = $this->accessVerifier->hasAccess($user, $product);

            if (!$hasAccess) {
                throw UserDosesNotHaveAccessProductException::caseOfThereIsNoSubscription();
            }

            return $this->responseFactory->json([
                'message' => 'Your subscription apprived'
            ]);

        } catch (\Exception $exception) {
            return $this->responseFactory->json([
                'message' => $exception->getMessage()
            ], 403);
        }
    }
}
