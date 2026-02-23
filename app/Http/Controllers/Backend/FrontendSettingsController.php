<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateGeneralSettingsRequest;
use App\Http\Requests\UpdateContactSettingsRequest;
use App\Http\Requests\StoreSocialMediaRequest;
use App\Http\Requests\StoreFooterLinkRequest;
use App\Services\SiteSettingService;
use App\Services\SocialMediaService;
use App\Services\FooterLinkService;
use App\Services\SiteLogoService;
use App\Models\Common\SiteSetting;
use App\Models\Common\SocialMediaLink;
use App\Models\Common\FooterLink;
use App\Models\Common\SiteLogo;
use Illuminate\Http\Request;

class FrontendSettingsController extends Controller
{
    protected $settingService;
    protected $socialMediaService;
    protected $footerLinkService;
    protected $logoService;

    public function __construct(
        SiteSettingService $settingService,
        SocialMediaService $socialMediaService,
        FooterLinkService $footerLinkService,
        SiteLogoService $logoService
    ) {
        $this->settingService = $settingService;
        $this->socialMediaService = $socialMediaService;
        $this->footerLinkService = $footerLinkService;
        $this->logoService = $logoService;
    }

    /**
     * Display the frontend settings page
     */
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
        $socialMediaLinks = $this->socialMediaService->getAll();
        $footerLinks = $this->footerLinkService->getAll();
        $logos = SiteLogo::all()->keyBy('type');

        return view('backend.settings.frontend-settings', compact(
            'settings',
            'socialMediaLinks',
            'footerLinks',
            'logos'
        ));
    }

    /**
     * Update general settings
     */
    public function updateGeneral(UpdateGeneralSettingsRequest $request)
    {
        try {
            $this->settingService->updateGeneralSettings($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'General settings updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating general settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update contact settings
     */
    public function updateContact(UpdateContactSettingsRequest $request)
    {
        try {
            $this->settingService->updateContactSettings($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Contact settings updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating contact settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all social media links or single link by ID
     */
    public function getSocialMedia($id = null)
    {
        if ($id) {
            $link = \App\Models\Common\SocialMediaLink::find($id);
            if (!$link) {
                return response()->json([
                    'success' => false,
                    'message' => 'Social media link not found'
                ], 404);
            }
            return response()->json(['data' => $link]);
        }
        
        $links = $this->socialMediaService->getAll();
        return response()->json(['data' => $links]);
    }

    /**
     * Store new social media link
     */
    public function storeSocialMedia(StoreSocialMediaRequest $request)
    {
        try {
            $link = $this->socialMediaService->store($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Social media link added successfully!',
                'data' => $link
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding social media link: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update social media link
     */
    public function updateSocialMedia(StoreSocialMediaRequest $request, $id)
    {
        try {
            $link = $this->socialMediaService->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Social media link updated successfully!',
                'data' => $link
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating social media link: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete social media link
     */
    public function destroySocialMedia($id)
    {
        try {
            $this->socialMediaService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Social media link deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting social media link: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all footer links
     */
    public function getFooterLinks()
    {
        $links = $this->footerLinkService->getAll();
        return response()->json(['data' => $links]);
    }

    /**
     * Store new footer link
     */
    public function storeFooterLink(StoreFooterLinkRequest $request)
    {
        try {
            $link = $this->footerLinkService->store($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Footer link added successfully!',
                'data' => $link
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding footer link: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update footer link
     */
    public function updateFooterLink(StoreFooterLinkRequest $request, $id)
    {
        try {
            $link = $this->footerLinkService->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Footer link updated successfully!',
                'data' => $link
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating footer link: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete footer link
     */
    public function destroyFooterLink($id)
    {
        try {
            $this->footerLinkService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Footer link deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting footer link: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload logo
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo_file' => 'required|image|mimes:png,jpg,jpeg,svg,ico|max:2048',
            'logo_type' => 'required|in:main,mobile,footer,favicon',
            'alt_text' => 'nullable|string|max:255',
        ]);

        try {
            $logo = $this->logoService->uploadLogo(
                $request->file('logo_file'),
                $request->logo_type,
                $request->alt_text
            );

            return response()->json([
                'success' => true,
                'message' => 'Logo uploaded successfully!',
                'data' => $logo,
                'preview_url' => asset($logo->file_path)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading logo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete logo
     */
    public function deleteLogo(Request $request)
    {
        $request->validate([
            'logo_type' => 'required|in:main,mobile,footer,favicon',
        ]);

        try {
            $this->logoService->delete($request->logo_type);

            return response()->json([
                'success' => true,
                'message' => 'Logo deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting logo: ' . $e->getMessage()
            ], 500);
        }
    }
}

