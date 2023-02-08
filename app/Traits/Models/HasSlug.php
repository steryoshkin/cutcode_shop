<?php

declare(strict_types=1);

namespace App\Traits\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Counter;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        static::creating(function(Model $item) {
            $item->slug = $item->slug
                ?? str($item->{self::slugFrom()})
                    ->append(self::generateSlug($item->{self::slugFrom()}))
                    ->slug();
        });
    }

    public static function slugFrom(): string
    {
        return 'title';
    }

    public static function generateSlug(string $slug): string
    {
        $i = 0;
        $newSlug = $slug;

        while (static::query()
            ->withoutGlobalScopes()
            ->select('slug')
            ->where('slug', str($newSlug)->slug())
            ->first())
        {
            $newSlug = $slug.'-'.$i++;
        }

        return $i > 0 ? '-'.$i : '';
    }
/*
    public static function slugSuffixAll(string $slug): string
    {
        $slug = str($slug)->slug();

        $result = Brand::query()
            ->select('slug')
            ->where('slug', 'LIKE', $slug.'%')
            ->count()
        + Category::query()
            ->select('slug')
            ->where('slug', 'LIKE', $slug.'%')
            ->count()
        + Product::query()
            ->select('slug')
            ->where('slug', 'LIKE', $slug.'%')
            ->count();

        return $result == 0 ? '' : '-'.$result;
    }

    public static function slugSuffix(string $slug): string
    {
        $slug = str($slug)->slug();

        $result = static::query()
            ->select('slug')
            ->where('slug', 'LIKE', $slug.'%')
            ->count();

        return $result == 0 ? '' : '-'.$result;
    }*/
}
