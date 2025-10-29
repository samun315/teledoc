<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Common\SiteSetting;
use App\Models\Common\SocialMediaLink;
use App\Models\Common\FooterLink;

class FrontendSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Site Settings - General
        $generalSettings = [
            ['key' => 'site_name', 'value' => 'Medsev', 'type' => 'text', 'group' => 'general', 'label' => 'Site Name', 'order' => 1],
            ['key' => 'site_tagline', 'value' => 'Healthcare Clinic & Doctor', 'type' => 'text', 'group' => 'general', 'label' => 'Site Tagline', 'order' => 2],
            ['key' => 'copyright_text', 'value' => '© Medsev 2025. All rights reserved.', 'type' => 'textarea', 'group' => 'general', 'label' => 'Copyright Text', 'order' => 3],
            ['key' => 'meta_description', 'value' => 'Best healthcare clinic providing quality medical services', 'type' => 'textarea', 'group' => 'general', 'label' => 'Meta Description', 'order' => 4],
            ['key' => 'meta_keywords', 'value' => 'healthcare, clinic, doctor, medical, hospital', 'type' => 'text', 'group' => 'general', 'label' => 'Meta Keywords', 'order' => 5],
        ];

        foreach ($generalSettings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // Site Settings - Contact
        $contactSettings = [
            ['key' => 'contact_email_1', 'value' => 'hello@medsev.com', 'type' => 'email', 'group' => 'contact', 'label' => 'Primary Email', 'order' => 1],
            ['key' => 'contact_email_2', 'value' => 'support@medsev.com', 'type' => 'email', 'group' => 'contact', 'label' => 'Secondary Email', 'order' => 2],
            ['key' => 'contact_phone_1', 'value' => '+07 554 332 322', 'type' => 'phone', 'group' => 'contact', 'label' => 'Primary Phone', 'order' => 3],
            ['key' => 'contact_phone_2', 'value' => '+236 256 256 365', 'type' => 'phone', 'group' => 'contact', 'label' => 'Secondary Phone', 'order' => 4],
            ['key' => 'contact_whatsapp', 'value' => '+07 554 332 322', 'type' => 'phone', 'group' => 'contact', 'label' => 'WhatsApp Number', 'order' => 5],
            ['key' => 'contact_address_1', 'value' => '210-27 Quadra, Market Street', 'type' => 'text', 'group' => 'contact', 'label' => 'Address Line 1', 'order' => 6],
            ['key' => 'contact_address_2', 'value' => '', 'type' => 'text', 'group' => 'contact', 'label' => 'Address Line 2', 'order' => 7],
            ['key' => 'contact_city', 'value' => 'Victoria', 'type' => 'text', 'group' => 'contact', 'label' => 'City', 'order' => 8],
            ['key' => 'contact_state', 'value' => 'British Columbia', 'type' => 'text', 'group' => 'contact', 'label' => 'State/Province', 'order' => 9],
            ['key' => 'contact_postal_code', 'value' => 'V8W 2M3', 'type' => 'text', 'group' => 'contact', 'label' => 'Postal Code', 'order' => 10],
            ['key' => 'contact_country', 'value' => 'Canada', 'type' => 'text', 'group' => 'contact', 'label' => 'Country', 'order' => 11],
        ];

        foreach ($contactSettings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // Social Media Links
        $socialMediaLinks = [
            ['platform' => 'Facebook', 'url' => 'https://www.facebook.com/', 'icon_class' => 'icofont-facebook', 'display_location' => 'both', 'order' => 1],
            ['platform' => 'Twitter', 'url' => 'https://twitter.com/', 'icon_class' => 'icofont-twitter', 'display_location' => 'both', 'order' => 2],
            ['platform' => 'Pinterest', 'url' => 'https://www.pinterest.com/', 'icon_class' => 'icofont-pinterest', 'display_location' => 'both', 'order' => 3],
        ];

        foreach ($socialMediaLinks as $link) {
            SocialMediaLink::updateOrCreate(
                ['platform' => $link['platform']],
                $link
            );
        }

        // Footer Quick Links
        $quickLinks = [
            ['title' => 'About Us', 'url' => '/about', 'link_type' => 'internal', 'section' => 'quick_links', 'target' => '_self', 'order' => 1],
            ['title' => 'Blog', 'url' => '/blog', 'link_type' => 'internal', 'section' => 'quick_links', 'target' => '_self', 'order' => 2],
            ['title' => 'FAQ', 'url' => '/faqs', 'link_type' => 'internal', 'section' => 'quick_links', 'target' => '_self', 'order' => 3],
            ['title' => 'Doctors', 'url' => '/doctors', 'link_type' => 'internal', 'section' => 'quick_links', 'target' => '_self', 'order' => 4],
            ['title' => 'Contact Us', 'url' => '/contact-us', 'link_type' => 'internal', 'section' => 'quick_links', 'target' => '_self', 'order' => 5],
        ];

        foreach ($quickLinks as $link) {
            FooterLink::updateOrCreate(
                ['title' => $link['title'], 'section' => 'quick_links'],
                $link
            );
        }

        // Footer Service Links
        $serviceLinks = [
            ['title' => 'Dental Care', 'url' => '/service', 'link_type' => 'internal', 'section' => 'services', 'target' => '_self', 'order' => 1],
            ['title' => 'Cardiology', 'url' => '/service', 'link_type' => 'internal', 'section' => 'services', 'target' => '_self', 'order' => 2],
            ['title' => 'Massage Therapy', 'url' => '/service', 'link_type' => 'internal', 'section' => 'services', 'target' => '_self', 'order' => 3],
            ['title' => 'Ambulance Services', 'url' => '/service', 'link_type' => 'internal', 'section' => 'services', 'target' => '_self', 'order' => 4],
            ['title' => 'Medicine', 'url' => '/service', 'link_type' => 'internal', 'section' => 'services', 'target' => '_self', 'order' => 5],
        ];

        foreach ($serviceLinks as $link) {
            FooterLink::updateOrCreate(
                ['title' => $link['title'], 'section' => 'services'],
                $link
            );
        }

        $this->command->info('Frontend settings seeded successfully!');
    }
}

