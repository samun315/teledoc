<?php
namespace App\Support\Csp\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Basic;

class CustomPolicy extends Basic
{
    public function configure()
    {
        $this->addDirective(Directive::BASE, Keyword::SELF)
            ->addDirective(Directive::CONNECT, Keyword::SELF)
            ->addDirective(Directive::DEFAULT, Keyword::SELF)
            ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
            ->addDirective(Directive::IMG, [
                Keyword::SELF,  // Allow images from the same origin
                'data:',        // Allow data URIs for images
                'http://www.w3.org/'
            ])
            ->addDirective(Directive::MEDIA, Keyword::SELF)
            ->addDirective(Directive::OBJECT, Keyword::NONE)
            ->addDirective(Directive::SCRIPT, [
                Keyword::SELF,
                'https://www.google-analytics.com/'
            ])
            ->addNonceForDirective(Directive::SCRIPT) // Adds nonce for scripts
            ->addDirective(Directive::STYLE, [
                Keyword::SELF,
                'https://fonts.googleapis.com'
            ])
            ->addNonceForDirective(Directive::STYLE) // Adds nonce for inline styles
            ->addDirective(Directive::STYLE_ELEM, [
                Keyword::SELF,
                'https://fonts.googleapis.com/',
            ])
            ->addDirective(Directive::FONT, [
                Keyword::SELF,
                'https://fonts.gstatic.com/',
                'https://fonts.googleapis.com/',
                'data:', // Allow data URIs for fonts
            ]);





    }
}
