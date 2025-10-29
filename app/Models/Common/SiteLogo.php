<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteLogo extends Model
{
    protected $fillable = [
        'type',
        'file_path',
        'alt_text',
        'active',
    ];

    /**
     * Get logo by type
     */
    public static function getByType($type = 'main')
    {
        $logo = static::where('type', $type)
            ->where('active', 'YES')
            ->first();

        return $logo ? asset($logo->file_path) : null;
    }

    /**
     * Get main logo
     */
    public static function getMainLogo()
    {
        return static::getByType('main');
    }

    /**
     * Get mobile logo
     */
    public static function getMobileLogo()
    {
        return static::getByType('mobile') ?? static::getMainLogo();
    }

    /**
     * Get footer logo
     */
    public static function getFooterLogo()
    {
        return static::getByType('footer') ?? static::getMainLogo();
    }

    /**
     * Get favicon
     */
    public static function getFavicon()
    {
        return static::getByType('favicon');
    }
}

