<?php

namespace App\Services;

use App\Models\Common\SiteLogo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteLogoService
{
    /**
     * Get all logos
     */
    public function getAll()
    {
        return SiteLogo::all();
    }

    /**
     * Get logo by type with cache
     */
    public function getByType($type = 'main')
    {
        return Cache::remember("site_logo_{$type}", 86400, function () use ($type) {
            return SiteLogo::getByType($type);
        });
    }

    /**
     * Upload logo
     */
    public function uploadLogo($file, $type, $altText = null)
    {
        // Define upload directory
        $directory = 'uploads/settings/logos';

        // Create directory if not exists
        if (!file_exists(public_path($directory))) {
            mkdir(public_path($directory), 0755, true);
        }

        // Delete old logo if exists
        $oldLogo = SiteLogo::where('type', $type)->first();
        if ($oldLogo && file_exists(public_path($oldLogo->file_path))) {
            unlink(public_path($oldLogo->file_path));
        }

        // Generate unique filename
        $filename = $type . '_' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = $directory . '/' . $filename;

        // Move file to public directory
        $file->move(public_path($directory), $filename);

        // Update or create logo record
        $logo = SiteLogo::updateOrCreate(
            ['type' => $type],
            [
                'file_path' => $filePath,
                'alt_text' => $altText ?? ucfirst($type) . ' Logo',
                'active' => 'YES',
            ]
        );

        $this->clearCache($type);

        return $logo;
    }

    /**
     * Delete logo
     */
    public function delete($type)
    {
        $logo = SiteLogo::where('type', $type)->first();

        if ($logo) {
            // Delete physical file
            if (file_exists(public_path($logo->file_path))) {
                unlink(public_path($logo->file_path));
            }

            // Delete record
            $logo->delete();
            $this->clearCache($type);
        }

        return true;
    }

    /**
     * Clear cache
     */
    public function clearCache($type = null)
    {
        if ($type) {
            Cache::forget("site_logo_{$type}");
        } else {
            Cache::forget('site_logo_main');
            Cache::forget('site_logo_mobile');
            Cache::forget('site_logo_footer');
            Cache::forget('site_logo_favicon');
        }
    }
}

