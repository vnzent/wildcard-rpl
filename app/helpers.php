<?php

use App\Models\Type;
use App\Models\Wishlist;

if (! function_exists('type_of')) {
    function type_of(string $key, string $for, string $type): ?Type
    {
        return Type::query()
            ->where('key', $key)
            ->where('for', $for)
            ->where('type', $type)
            ->first();
    }
}

if (! function_exists('wishlist')) {
    function wishlist(int $product_id): bool
    {
        if (auth('accounts')->user()) {
            $wishlist = Wishlist::where('account_id', auth('accounts')->user()->id)
                ->where('product_id', $product_id)->first();

            if ($wishlist) {
                return true;
            }
        }

        return false;
    }
}
