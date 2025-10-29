# Frontend Settings - Dynamic Header & Footer System

## Overview
Complete implementation of dynamic frontend settings management with a tabbed admin interface for managing:
- General site information
- Contact details
- Social media links
- Footer quick links
- Footer service links
- Logo & branding (main, mobile, footer, favicon)

---

## 🎯 Installation & Setup

### Step 1: Run Migrations
```bash
php artisan migrate
```

This will create 4 new tables:
- `site_settings` - General and contact settings
- `social_media_links` - Social media platform links
- `footer_links` - Quick links and service links
- `site_logos` - Logo files (main, mobile, footer, favicon)

### Step 2: Seed Initial Data
```bash
php artisan db:seed --class=FrontendSettingsSeeder
```

This will populate:
- Default site name, tagline, copyright
- Sample contact information
- Default social media links (Facebook, Twitter, Pinterest)
- Default footer quick links and service links

### Step 3: Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 📁 Files Created

### **Migrations** (4 files)
- `database/migrations/2025_10_28_000001_create_site_settings_table.php`
- `database/migrations/2025_10_28_000002_create_social_media_links_table.php`
- `database/migrations/2025_10_28_000003_create_footer_links_table.php`
- `database/migrations/2025_10_28_000004_create_site_logos_table.php`

### **Models** (4 files)
- `app/Models/Common/SiteSetting.php`
- `app/Models/Common/SocialMediaLink.php`
- `app/Models/Common/FooterLink.php`
- `app/Models/Common/SiteLogo.php`

### **Services** (4 files)
- `app/Services/SiteSettingService.php`
- `app/Services/SocialMediaService.php`
- `app/Services/FooterLinkService.php`
- `app/Services/SiteLogoService.php`

### **Controllers** (1 file)
- `app/Http/Controllers/Backend/FrontendSettingsController.php`

### **Request Validators** (4 files)
- `app/Http/Requests/UpdateGeneralSettingsRequest.php`
- `app/Http/Requests/UpdateContactSettingsRequest.php`
- `app/Http/Requests/StoreSocialMediaRequest.php`
- `app/Http/Requests/StoreFooterLinkRequest.php`

### **Views** (12 files)
- `resources/views/settings/frontend-settings.blade.php` (Main page)
- `resources/views/settings/partials/general-tab.blade.php`
- `resources/views/settings/partials/contact-tab.blade.php`
- `resources/views/settings/partials/social-media-tab.blade.php`
- `resources/views/settings/partials/quick-links-tab.blade.php`
- `resources/views/settings/partials/services-tab.blade.php`
- `resources/views/settings/partials/logo-tab.blade.php`
- `resources/views/settings/partials/social-media-modal.blade.php`
- `resources/views/settings/partials/footer-link-modal.blade.php`
- `resources/views/settings/partials/scripts.blade.php`

### **Routes** (1 file)
- `routes/settings.php`

### **View Composer** (1 file)
- `app/View/Composers/FrontendComposer.php`

### **Seeder** (1 file)
- `database/seeders/FrontendSettingsSeeder.php`

### **Modified Files** (5 files)
- `routes/web.php` - Added settings route inclusion
- `app/Providers/AppServiceProvider.php` - Registered FrontendComposer
- `app/Helpers/helper.php` - Added helper functions
- `resources/views/frontend/layout/navbar.blade.php` - Dynamic data
- `resources/views/frontend/layout/footer.blade.php` - Dynamic data
- `resources/views/frontend/layout/stylesheet.blade.php` - Dynamic meta & favicon

---

## 🚀 Usage

### Accessing the Settings Page
Navigate to: `/admin/settings/frontend`

The page contains 6 tabs:

#### **Tab 1: General Information**
- Site Name
- Site Tagline
- Copyright Text
- Meta Description
- Meta Keywords
- Google Analytics Code

#### **Tab 2: Contact Details**
- Primary & Secondary Email
- Primary & Secondary Phone
- WhatsApp Number
- Address (Line 1, Line 2, City, State, Postal Code, Country)

#### **Tab 3: Social Media**
- Platform selection (Facebook, Twitter, Instagram, LinkedIn, YouTube, Pinterest, TikTok, WhatsApp)
- URL
- Icon class (auto-populated)
- Display location (Header/Footer/Both)
- Order & Status

#### **Tab 4: Footer Quick Links**
- Title
- URL/Route
- Link Type (Internal/External)
- Target (_self/_blank)
- Order & Status

#### **Tab 5: Footer Services**
- Same structure as Quick Links
- Displays in "Our Services" footer section

#### **Tab 6: Logo & Branding**
- Main Logo (Header)
- Mobile Logo
- Footer Logo (optional)
- Favicon

---

## 💡 Helper Functions

Use these anywhere in your Blade templates or controllers:

```php
// Get single setting
siteSetting('site_name', 'Default Name')

// Get social media links
socialMediaLinks('header') // or 'footer'

// Get footer links
footerLinks('quick_links') // or 'services'

// Get logo
siteLogo('main') // or 'mobile', 'footer', 'favicon'
```

---

## 🔧 API Endpoints

### Settings
- `POST /admin/settings/frontend/general` - Update general settings
- `POST /admin/settings/frontend/contact` - Update contact settings

### Social Media
- `GET /admin/settings/frontend/social-media` - List all
- `POST /admin/settings/frontend/social-media` - Create new
- `PUT /admin/settings/frontend/social-media/{id}` - Update
- `DELETE /admin/settings/frontend/social-media/{id}` - Delete

### Footer Links
- `GET /admin/settings/frontend/footer-links` - List all
- `POST /admin/settings/frontend/footer-links` - Create new
- `PUT /admin/settings/frontend/footer-links/{id}` - Update
- `DELETE /admin/settings/frontend/footer-links/{id}` - Delete

### Logo Upload
- `POST /admin/settings/frontend/logo` - Upload logo
- `POST /admin/settings/frontend/logo/delete` - Delete logo

---

## 📊 Frontend Display

### Navbar (Header Top)
- Displays: Phone, Email, Address (from contact settings)
- Social media icons (header location)
- Dynamic logos

### Footer
- **Contact Section**: Emails, Phones, Address
- **Quick Links**: Dynamic menu
- **Services**: Dynamic service links
- **Copyright**: Dynamic copyright text

### Meta Tags
- Dynamic page title: `{Site Name} - {Site Tagline}`
- Dynamic meta description
- Dynamic meta keywords
- Dynamic favicon

---

## 🔄 Caching

All settings are cached for 24 hours for performance. Cache is automatically cleared when:
- Settings are updated
- Social media links are modified
- Footer links are changed
- Logos are uploaded/deleted

Manual cache clear:
```bash
php artisan cache:clear
```

---

## 🎨 Customization

### Adding New Settings
1. Add to seeder (`FrontendSettingsSeeder.php`)
2. Add form field in appropriate tab partial
3. Settings automatically save to database

### Adding New Social Platforms
Update icon mapping in:
- `SocialMediaLink::getPlatformIcon()`
- Modal select dropdown
- JavaScript icon auto-fill

### Styling
All views use your existing theme's classes. The tabbed interface uses Bootstrap 5 tabs.

---

## 🐛 Troubleshooting

### Settings not appearing in frontend
1. Check if FrontendComposer is registered in AppServiceProvider
2. Clear cache: `php artisan cache:clear`
3. Verify migrations ran successfully

### Logo not uploading
1. Check directory permissions: `public/uploads/settings/logos/`
2. Ensure max upload size in `php.ini`
3. Verify file extension is allowed (png, jpg, jpeg, svg, ico)

### Tab not saving
1. Check browser console for JavaScript errors
2. Verify CSRF token is present
3. Check route is properly defined

---

## 📝 Notes

- All forms use AJAX for seamless submission
- Toast notifications (iziToast) show success/error messages
- Tab state is saved in localStorage
- Empty fallbacks ensure site still works without settings
- Images are stored in `public/uploads/settings/logos/`

---

## 🔐 Security

- All routes require authentication (`auth` middleware)
- CSRF protection on all forms
- File upload validation (type, size)
- Input sanitization via Laravel Request validation
- XSS protection via Blade escaping

---

## 📞 Support

For issues or questions:
1. Check migration status: `php artisan migrate:status`
2. Check logs: `storage/logs/laravel.log`
3. Verify permissions on upload directory

---

**Version**: 1.0  
**Created**: October 28, 2025  
**Last Updated**: October 28, 2025

