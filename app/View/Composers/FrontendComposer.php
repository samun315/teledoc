<?php

namespace App\View\Composers;

use App\Services\SiteSettingService;
use App\Services\SocialMediaService;
use App\Services\FooterLinkService;
use App\Services\SiteLogoService;
use Illuminate\View\View;

class FrontendComposer
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
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Site Settings
        $generalSettings = $this->settingService->getByGroup('general');
        $contactSettings = $this->settingService->getByGroup('contact');

        // Social Media Links
        $socialMediaHeader = $this->socialMediaService->getByLocation('header');
        $socialMediaFooter = $this->socialMediaService->getByLocation('footer');

        // Footer Links
        $footerQuickLinks = $this->footerLinkService->getBySection('quick_links');
        $footerServiceLinks = $this->footerLinkService->getBySection('services');

        // Logos
        $mainLogo = $this->logoService->getByType('main');
        $mobileLogo = $this->logoService->getByType('mobile');
        $footerLogo = $this->logoService->getByType('footer');
        $favicon = $this->logoService->getByType('favicon');

        // Share with view
        $view->with([
            'siteSettings' => array_merge($generalSettings, $contactSettings),
            'socialMediaHeader' => $socialMediaHeader,
            'socialMediaFooter' => $socialMediaFooter,
            'footerQuickLinks' => $footerQuickLinks,
            'footerServiceLinks' => $footerServiceLinks,
            'mainLogo' => $mainLogo ?? asset('frontend/assets/img/logo.png'),
            'mobileLogo' => $mobileLogo ?? $mainLogo ?? asset('frontend/assets/img/logo-two.png'),
            'footerLogo' => $footerLogo ?? $mainLogo ?? asset('frontend/assets/img/logo.png'),
            'favicon' => $favicon ?? asset('frontend/assets/img/favicon.png'),
        ]);
    }
}

