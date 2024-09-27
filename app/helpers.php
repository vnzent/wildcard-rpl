<?php

use App\Facades\CMS;
use App\Models\Post;
use App\Models\Type;
use App\Models\Wishlist;
use App\Settings\ThemesSettings;
use Illuminate\Support\Facades\File;

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

if (! function_exists('theme_assets')) {
    function theme_assets(?string $path = null): string
    {
        return asset('storage/themes/'.setting('theme_name').'/'.$path);
    }
}

if (! function_exists('theme_setting')) {
    function theme_setting(string $key): mixed
    {
        if (! File::exists(base_path('Themes'))) {
            return false;
        }
        if (! File::exists(base_path('Themes').'/'.setting('theme_path'))) {
            return false;
        }
        $info = json_decode(File::get(base_path('Themes').'/'.setting('theme_path').'/info.json'), false);
        if (isset($info->settings->{$key})) {
            return $info->settings->{$key}->value;
        }

        $settingClass = new ThemesSettings;

        if (isset($settingClass->{'theme_'.$key})) {
            return $settingClass->{'theme_'.$key};
        }

        return false;
    }
}

if (! function_exists('load_page')) {
    function load_page(string $slug, ?string $name = null): Post
    {
        $page = Post::query()
            ->withTrashed()
            ->where('type', 'builder')
            ->where('slug', $slug)
            ->first();

        if (! $page) {
            $page = new Post;
            $page->title = $name ?: 'Empty';
            $page->type = 'builder';
            $page->slug = $slug;
            $page->is_published = true;
            $page->save();
        } else {
            if ($page->deleted_at) {
                $page->restore();
            }
        }

        return $page;
    }
}

if (! function_exists('section')) {
    function section($key)
    {
        $section = CMS::themes()->getSections()->where('key', $key)->first();

        return $section ?? null;
    }
}
