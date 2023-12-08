<?php

namespace Src\UsersAccess\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Src\UsersAccess\Models\Product;

class ViewProductController
{
    public function __invoke(Request $request,$slug)
    {
        $product = Product::whereSlug($slug);
        $user = $request->user();

        return 'Test product';
    }
}
