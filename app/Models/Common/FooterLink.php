<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    protected $fillable = [
        'title',
        'url',
        'link_type',
        'section',
        'icon',
        'target',
        'order',
        'active',
    ];

    /**
     * Get active footer links by section
     */
    public static function getBySection($section = 'quick_links')
    {
        return static::where('section', $section)
            ->where('active', 'YES')
            ->orderBy('order')
            ->get();
    }

    /**
     * Get quick links
     */
    public static function getQuickLinks()
    {
        return static::getBySection('quick_links');
    }

    /**
     * Get service links
     */
    public static function getServiceLinks()
    {
        return static::getBySection('services');
    }
}

