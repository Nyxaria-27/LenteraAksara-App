# 📁 Project Structure

Organized file structure for **Lentera Aksara** bookstore application.

---

## 🗂️ Root Directory

```
lentera-aksara/
│
├── 📄 README.md                    # Main project documentation
├── 📄 LICENSE                      # MIT License
├── 📄 composer.json                # PHP dependencies
├── 📄 package.json                 # Node.js dependencies
├── 📄 phpunit.xml                  # PHPUnit configuration
├── 📄 tailwind.config.js           # Tailwind CSS configuration
├── 📄 vite.config.js               # Vite build tool configuration
├── 📄 postcss.config.js            # PostCSS configuration
├── 📄 pnpm-lock.yaml               # PNPM lock file
├── 📄 artisan                      # Laravel Artisan CLI
├── 🔧 toggle-features.bat          # Feature toggle script (Windows)
├── 🔧 toggle-features.ps1          # Feature toggle script (PowerShell)
│
├── 📂 app/                         # Application core
│   ├── 📂 Helpers/                # Helper classes
│   │   ├── FeatureHelper.php      # Feature flag management
│   │   ├── NavbarHelper.php       # Navbar rendering logic
│   │   └── TranslatorHelper.php   # Translation utilities
│   │
│   ├── 📂 Http/
│   │   ├── 📂 Controllers/        # Request handlers
│   │   ├── 📂 Middleware/         # HTTP middleware
│   │   └── 📂 Requests/           # Form request validation
│   │
│   ├── 📂 Models/                 # Eloquent ORM models
│   │   ├── User.php
│   │   ├── Book.php
│   │   ├── Category.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Cart.php
│   │   ├── CartItem.php
│   │   ├── Review.php
│   │   ├── Wishlist.php
│   │   ├── Contact.php
│   │   └── About.php
│   │
│   ├── 📂 Notifications/          # Email/notification classes
│   ├── 📂 Providers/              # Service providers
│   ├── 📂 Support/                # Support classes
│   └── 📂 View/
│       ├── 📂 Components/         # Blade components
│       └── 📂 Composers/          # View composers
│
├── 📂 bootstrap/                   # Application bootstrap
│   ├── app.php
│   ├── providers.php
│   └── 📂 cache/
│
├── 📂 config/                      # Configuration files
│   ├── app.php                    # Application config
│   ├── auth.php                   # Authentication config
│   ├── database.php               # Database connections
│   ├── features.php               # 🔥 Feature flags config
│   ├── filesystems.php
│   ├── mail.php
│   └── ...
│
├── 📂 database/
│   ├── 📂 factories/              # Model factories
│   ├── 📂 migrations/             # Database migrations
│   └── 📂 seeders/                # Database seeders
│
├── 📂 docs/                        # 📚 Documentation hub
│   ├── 📄 README.md               # Documentation index
│   ├── 📄 CHANGELOG.md            # Version history
│   ├── 📄 SECURITY.md             # Security policy
│   │
│   ├── 📂 guides/                 # Feature & technical guides
│   │   ├── GITHUB_SETUP_CHECKLIST.md
│   │   ├── PORTFOLIO_SETUP_SUMMARY.md
│   │   ├── FEATURE_FLAGS_GUIDE.md
│   │   ├── FEATURE_TOGGLE_SUMMARY.md
│   │   ├── QUICK_TOGGLE_GUIDE.md
│   │   ├── TO_USK_FEATURES_LIST.md
│   │   ├── WISHLIST_FEATURE_GUIDE.md
│   │   ├── WISHLIST_DEMO.md
│   │   ├── ORDER_MANAGEMENT_README.md
│   │   ├── TRANSLATION_CLEAN_IMPLEMENTATION.md
│   │   ├── NAVBAR_OPTIMIZATION.md
│   │   ├── AOS_ANIMATIONS_README.md
│   │   ├── FEATURE_HIDING_FIXES.md
│   │   └── VISUAL_COMPARISON.md
│   │
│   └── 📂 screenshots/            # Application screenshots
│       └── README.md              # Screenshot guidelines
│
├── 📂 public/                      # Public web assets
│   ├── index.php                  # Application entry point
│   ├── robots.txt
│   ├── 📂 build/                  # Vite compiled assets
│   └── 📂 storage/                # Symlink to storage/app/public
│
├── 📂 resources/
│   ├── 📂 css/
│   │   └── app.css                # Tailwind CSS imports
│   │
│   ├── 📂 js/
│   │   ├── app.js                 # Main JavaScript entry
│   │   └── bootstrap.js           # Bootstrap dependencies
│   │
│   ├── 📂 lang/                   # Translation files
│   │   ├── 📂 en/                 # English translations
│   │   └── 📂 id/                 # Indonesian translations
│   │
│   └── 📂 views/                  # Blade templates
│       ├── 📂 admin/              # Admin dashboard views
│       ├── 📂 auth/               # Authentication views
│       ├── 📂 books/              # Book catalog views
│       ├── 📂 cart/               # Shopping cart views
│       ├── 📂 checkout/           # Checkout process
│       ├── 📂 components/         # Reusable components
│       ├── 📂 contact/            # Contact page
│       ├── 📂 layouts/            # Layout templates
│       ├── 📂 orders/             # Order management views
│       ├── 📂 profile/            # User profile
│       ├── 📂 reviews/            # Review system
│       ├── 📂 wishlist/           # Wishlist views
│       └── welcome.blade.php      # Homepage
│
├── 📂 routes/
│   ├── web.php                    # Web routes
│   ├── auth.php                   # Authentication routes
│   └── console.php                # Artisan commands
│
├── 📂 storage/
│   ├── 📂 app/
│   │   ├── 📂 public/             # Public file storage
│   │   │   ├── 📂 books/         # Book cover images
│   │   │   ├── 📂 profiles/      # User profile pictures
│   │   │   └── 📂 abouts/        # About page images
│   │   └── ...
│   │
│   ├── 📂 framework/              # Framework cache/sessions
│   └── 📂 logs/                   # Application logs
│
├── 📂 tests/
│   ├── TestCase.php
│   ├── 📂 Feature/                # Feature tests
│   └── 📂 Unit/                   # Unit tests
│
├── 📂 vendor/                      # Composer dependencies
│
└── 📂 .github/                     # GitHub templates
    ├── CONTRIBUTING.md            # Contribution guidelines
    ├── PULL_REQUEST_TEMPLATE.md   # PR template
    └── 📂 ISSUE_TEMPLATE/
        ├── bug_report.md
        └── feature_request.md
```

---

## 🎯 Key Directories Explained

### 📂 `app/`
Core application logic including controllers, models, and helpers.

### 📂 `config/`
All configuration files. **Note:** `features.php` contains the feature flag system.

### 📂 `docs/`
📚 **Complete project documentation** - All `.md` files organized here!
- Root docs: CHANGELOG, SECURITY
- Guides: Feature-specific and setup documentation
- Screenshots: Visual examples

### 📂 `resources/views/`
Blade templates for all pages. Feature flags control which views are rendered.

### 📂 `storage/app/public/`
User-uploaded files (book covers, profile pictures). Symlinked to `public/storage`.

### 📂 `routes/`
Route definitions. `web.php` contains all application routes.

---

## 🔥 Feature Flag Files

```
config/features.php              # Feature flag definitions
app/Helpers/FeatureHelper.php    # Feature flag helper
.env                             # Feature toggle variables
toggle-features.bat|ps1          # Quick toggle scripts
```

---

## 📝 Documentation Files Location

**All documentation moved to `docs/` for better organization!**

```
Root:
├── README.md                    # Main entry point (stays in root)
└── LICENSE                      # License file (stays in root)

docs/:
├── README.md                    # Documentation index
├── CHANGELOG.md                 # Version history
├── SECURITY.md                  # Security policy
├── guides/                      # All feature guides
└── screenshots/                 # All screenshots
```

---

## 🚀 Quick Navigation

**Main Entry Points:**
- 📄 [README.md](../README.md) - Project overview
- 📚 [docs/README.md](../docs/README.md) - Documentation hub
- 🔧 [config/features.php](../config/features.php) - Feature flags

**For Development:**
- 🎨 [resources/views/](../resources/views/) - Frontend templates
- 🔌 [app/Http/Controllers/](../app/Http/Controllers/) - Backend logic
- 🗄️ [database/migrations/](../database/migrations/) - Database schema

**For Deployment:**
- 📦 [composer.json](../composer.json) - PHP dependencies
- 📦 [package.json](../package.json) - Node dependencies
- ⚙️ [.env.example](../.env.example) - Environment template

---

**Last Updated**: November 20, 2025  
**Maintainer**: Dwi Wahyu Ramadhan ([@Nyxaria-27](https://github.com/Nyxaria-27))
