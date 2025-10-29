<?php

namespace App\Services;

use App\Models\Common\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SiteSettingService
{
    /**
     * Get all settings with cache
     */
    public function getAllSettings()
    {
        return Cache::remember('site_settings_all', 86400, function () {
            return SiteSetting::where('active', 'YES')
                ->orderBy('group')
                ->orderBy('order')
                ->get()
                ->groupBy('group');
        });
    }

    /**
     * Get settings by group
     */
    public function getByGroup($group)
    {
        return Cache::remember("site_settings_{$group}", 86400, function () use ($group) {
            return SiteSetting::getByGroup($group);
        });
    }

    /**
     * Get single setting
     */
    public function get($key, $default = null)
    {
        return Cache::remember("site_setting_{$key}", 86400, function () use ($key, $default) {
            return SiteSetting::get($key, $default);
        });
    }

    /**
     * Update general settings
     */
    public function updateGeneralSettings($data)
    {
        foreach ($data as $key => $value) {
            SiteSetting::set($key, $value);
        }

        $this->clearCache();
        return true;
    }

    /**
     * Update contact settings
     */
    public function updateContactSettings($data)
    {
        foreach ($data as $key => $value) {
            SiteSetting::set($key, $value);
        }

        $this->clearCache();
        return true;
    }

    /**
     * Clear all settings cache
     */
    public function clearCache()
    {
        Cache::forget('site_settings_all');

        // Clear group caches
        $groups = ['general', 'contact', 'seo'];
        foreach ($groups as $group) {
            Cache::forget("site_settings_{$group}");
        }

        // Clear individual setting caches
        $keys = SiteSetting::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("site_setting_{$key}");
        }
    }
}

