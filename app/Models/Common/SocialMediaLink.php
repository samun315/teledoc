<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class SocialMediaLink extends Model
{
    protected $fillable = [
        'platform',
        'url',
        'icon_class',
        'display_location',
        'order',
        'active',
    ];

    /**
     * Get active social media links by location
     */
    public static function getByLocation($location = 'header')
    {
        return static::where('active', 'YES')
            ->where(function ($query) use ($location) {
                $query->where('display_location', $location)
                    ->orWhere('display_location', 'both');
            })
            ->orderBy('order')
            ->get();
    }

    /**
     * Get icon class by platform
     */
    public static function getPlatformIcon($platform)
    {
        $icons = [
            'facebook' => 'icofont-facebook',
            'twitter' => 'icofont-twitter',
            'instagram' => 'icofont-instagram',
            'linkedin' => 'icofont-linkedin',
            'youtube' => 'icofont-youtube-play',
            'pinterest' => 'icofont-pinterest',
            'tiktok' => 'icofont-brand-tiktok',
            'whatsapp' => 'icofont-whatsapp',
        ];

        return $icons[strtolower($platform)] ?? 'icofont-link';
    }
}

