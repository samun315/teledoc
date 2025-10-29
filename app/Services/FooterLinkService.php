<?php

namespace App\Services;

use App\Models\Common\FooterLink;
use Illuminate\Support\Facades\Cache;

class FooterLinkService
{
    /**
     * Get all footer links
     */
    public function getAll()
    {
        return FooterLink::orderBy('section')->orderBy('order')->get();
    }

    /**
     * Get by section with cache
     */
    public function getBySection($section = 'quick_links')
    {
        return Cache::remember("footer_links_{$section}", 86400, function () use ($section) {
            return FooterLink::getBySection($section);
        });
    }

    /**
     * Store new footer link
     */
    public function store($data)
    {
        $link = FooterLink::create($data);
        $this->clearCache();

        return $link;
    }

    /**
     * Update footer link
     */
    public function update($id, $data)
    {
        $link = FooterLink::findOrFail($id);
        $link->update($data);
        $this->clearCache();

        return $link;
    }

    /**
     * Delete footer link
     */
    public function delete($id)
    {
        $link = FooterLink::findOrFail($id);
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
            FooterLink::where('id', $id)->update(['order' => $order]);
        }

        $this->clearCache();
        return true;
    }

    /**
     * Clear cache
     */
    public function clearCache()
    {
        Cache::forget('footer_links_quick_links');
        Cache::forget('footer_links_services');
    }
}

