<?php

namespace App\Services;

use App\Models\Common\SocialMediaLink;
use Illuminate\Support\Facades\Cache;

class SocialMediaService
{
    /**
     * Get all social media links
     */
    public function getAll()
    {
        return SocialMediaLink::orderBy('order')->get();
    }

    /**
     * Get by location with cache
     */
    public function getByLocation($location = 'header')
    {
        return Cache::remember("social_media_{$location}", 86400, function () use ($location) {
            return SocialMediaLink::getByLocation($location);
        });
    }

    /**
     * Store new social media link
     */
    public function store($data)
    {
        // Auto-generate icon if not provided
        if (!isset($data['icon_class']) || empty($data['icon_class'])) {
            $data['icon_class'] = SocialMediaLink::getPlatformIcon($data['platform']);
        }

        $link = SocialMediaLink::create($data);
        $this->clearCache();

        return $link;
    }

    /**
     * Update social media link
     */
    public function update($id, $data)
    {
        $link = SocialMediaLink::findOrFail($id);

        // Auto-generate icon if platform changed
        if (isset($data['platform']) && $data['platform'] !== $link->platform) {
            $data['icon_class'] = SocialMediaLink::getPlatformIcon($data['platform']);
        }

        $link->update($data);
        $this->clearCache();

        return $link;
    }

    /**
     * Delete social media link
     */
    public function delete($id)
    {
        $link = SocialMediaLink::findOrFail($id);
        $link->delete();
        $this->clearCache();

        return true;
    }

    /**
     * Update order
     */
    public function updateOrder($orders)
    {
        foreach ($orders as $id => $order) {
            SocialMediaLink::where('id', $id)->update(['order' => $order]);
        }

        $this->clearCache();
        return true;
    }

    /**
     * Clear cache
     */
    public function clearCache()
    {
        Cache::forget('social_media_header');
        Cache::forget('social_media_footer');
        Cache::forget('social_media_both');
    }
}

