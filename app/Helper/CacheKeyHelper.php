<?php

declare(strict_types=1);

namespace App\Helper;

use App\Models\User;

class CacheKeyHelper
{
    public const EARTHQUAKES_TAG = 'earthquakes';
    public const USERS_TAG = 'users';

    public static function getAllUsersCacheKey(): string
    {
        return 'all_users';
    }

    public static function getUserCacheKey(User $user): string
    {
        return "user_{$user->id}";
    }

    public static function getEarthquakesCacheKey(): string
    {
        return 'all_earthquakes';
    }

    public static function getEarthquakesForUser(User $user): string
    {
        return "earthquakes_for_user_{$user->id}";
    }
}
