# 📚 Lentera Aksara - Online Bookstore

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-7.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)

![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)
![School Project](https://img.shields.io/badge/Project-School-blue.svg?style=for-the-badge)

*"Tranquil Growth" - A serene online bookstore experience*

**School Project** | SMK Negeri 21 Jakarta | Software Engineering (PPLG)

[Features](#-key-features) • [Installation](#-installation) • [Tech Stack](#-tech-stack) • [Screenshots](#-screenshots) • [Design](#-design-system)

</div>

---

## 📖 About The Project

**Lentera Aksara** is a comprehensive full-stack web application for an online bookstore, built with Laravel 12 and modern web technologies. Developed as a school project at **SMK Negeri 21 Jakarta** for the **Software Engineering (PPLG)** program, this platform features a complete e-commerce system with role-based access control, real-time notifications, bilingual support, and a feature flag system for flexible presentation modes.

The project showcases professional-grade development practices including:
- 🎨 **Design System**: Consistent earth-tone color palette with Lora serif typography
- 🌓 **Dark Mode**: Full dark mode support across all pages
- 🌍 **Bilingual**: Indonesian and English language support with Google Translate API integration
- 🎯 **Feature Flags**: Configurable feature toggling for demo/presentation purposes
- 📱 **Responsive**: Mobile-first design with optimized navigation
- ♿ **Accessible**: ARIA labels and semantic HTML

### 🎯 Project Goals

This project was developed as a **school project** at **SMK Negeri 21 Jakarta** for the **Software Engineering (PPLG)** program to demonstrate:
- Full-stack web development capabilities with Laravel ecosystem
- Modern frontend development with Tailwind CSS and Alpine.js
- Database design and relationship management
- Authentication and authorization implementation
- E-commerce functionality (cart, checkout, orders)
- Admin dashboard with CRUD operations
- Real-time notifications system
- PDF generation and file handling
- API integration (Google Translate)
- Professional software development practices

---

## ✨ Key Features

### 👥 User Management
- **Authentication System**: Registration, login, logout, password reset
- **Role-Based Access**: Admin and User roles with different permissions
- **Profile Management**: Update profile information, change password, upload profile picture

### 📚 Book Catalog
- **Book Management (Admin)**: Full CRUD operations for books
- **Category Management**: Organize books by categories with many-to-many relationships
- **Advanced Search**: Search by title, author, ISBN with real-time suggestions
- **Filtering & Sorting**: Filter by category, rating, price range; Sort by various criteria
- **Pagination**: Efficient data loading with customizable per-page limits

### 🛒 E-Commerce Features
- **Shopping Cart**: Add/remove items, update quantities, persistent cart storage
- **Checkout Process**: Multi-step checkout with order summary
- **Order Management**: Track order status (pending, processing, shipped, completed, cancelled)
- **Order History**: View past orders with detailed information
- **PDF Invoice**: Generate and download PDF invoices for completed orders

### ⭐ Review & Rating System
- **Product Reviews**: Users can review and rate books (1-5 stars)
- **Average Rating**: Display aggregate ratings on book cards
- **Admin Review Management**: View, filter, and moderate reviews
- **Review Statistics**: Rating distribution analytics

### ❤️ Wishlist System
- **Save Favorites**: Add books to wishlist for later purchase
- **Quick Access**: Dedicated wishlist page with easy management
- **Badge Indicators**: Visual counters for wishlist items

### 📧 Contact & Notifications
- **Contact Form**: Users can send messages to admin
- **Real-Time Notifications**: Database-driven notification system
- **Admin Replies**: Two-way communication between users and admin
- **Notification Center**: Unread notification tracking with badge counters

### 🎨 Design & UX
- **Dark Mode**: Toggle between light and dark themes with localStorage persistence
- **Responsive Design**: Mobile-first approach with hamburger menu animation
- **AOS Animations**: Smooth scroll-triggered animations throughout the site
- **Consistent Branding**: Earth-tone color palette (#4B5320, #2F4F4F, #D2B48C, #F5F5F5)
- **Typography**: Lora serif for headings, Inter sans-serif for body text

### 🌐 Internationalization
- **Bilingual Support**: Switch between Indonesian and English
- **Google Translate Integration**: Automatic content translation
- **Language Persistence**: User language preference stored in session
- **Translation Helper**: Custom helper function for seamless i18n

### 🎛️ Admin Dashboard
- **Statistics Overview**: Total users, books, orders, revenue with visual cards
- **User Management**: View, edit, delete users; Filter by role
- **Book Management**: CRUD operations with image upload, stock tracking
- **Category Management**: Organize book categories
- **Order Management**: View orders, update status, filter by status
- **Contact Management**: View messages, reply to users
- **Review Management**: Monitor and moderate user reviews

### 🚩 Feature Flags System
- **Configurable Features**: Toggle features on/off via `.env` file
- **Quick Toggle Scripts**: Batch scripts for instant mode switching
- **TO USK Mode**: Presentation mode with minimal features
- **FULL Mode**: All features enabled for demo

**Available Feature Flags:**
```env
FEATURE_TRANSLATION=true/false      # Bilingual support
FEATURE_DARK_MODE=true/false        # Dark mode toggle
FEATURE_REVIEWS=true/false          # Rating & review system
FEATURE_WISHLIST=true/false         # Wishlist functionality
FEATURE_CART=true/false             # Shopping cart
FEATURE_ORDERS=true/false           # Order management
FEATURE_NOTIFICATIONS=true/false    # Notification system
FEATURE_AOS_ANIMATIONS=true/false   # Scroll animations
FEATURE_PDF_INVOICE=true/false      # PDF generation
```

---

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 12.x (PHP 8.2+)
- **Database**: MySQL 8.0+
- **ORM**: Eloquent ORM
- **Authentication**: Laravel Breeze (Blade)
- **Queue**: Database driver
- **Cache**: Database driver
- **Session**: Database driver

### Frontend
- **Template Engine**: Blade
- **CSS Framework**: Tailwind CSS 3.x
- **JavaScript Framework**: Alpine.js 3.x
- **Build Tool**: Vite 7.x
- **Animations**: AOS (Animate On Scroll)
- **Icons**: Heroicons (SVG)

### Key Packages
- **barryvdh/laravel-dompdf**: PDF generation (v3.1)
- **stichoza/google-translate-php**: Translation API integration (v5.3)
- **Laravel Breeze**: Authentication scaffolding (v2.3)
- **Laravel Pail**: Real-time log monitoring (v1.2)

### Development Tools
- **Composer**: PHP dependency management
- **NPM/PNPM**: Node package management
- **Concurrently**: Run multiple dev servers simultaneously
- **Laravel Pint**: Code style formatter
- **PHPUnit**: Testing framework

---

## 📦 Installation

### Prerequisites
```bash
PHP >= 8.2
Composer >= 2.0
Node.js >= 18.x
MySQL >= 8.0
```

### Step-by-Step Installation

1. **Clone the repository**
```bash
git clone https://github.com/Nyxaria-27/lentera-aksara.git
cd lentera-aksara
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node dependencies**
```bash
npm install
# or
pnpm install
```

4. **Environment setup**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

5. **Database configuration**

Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lenteraaksara
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create database:
```bash
mysql -u root -p
CREATE DATABASE lenteraaksara;
exit;
```

6. **Run migrations and seeders**
```bash
php artisan migrate --seed
```

7. **Create storage link**
```bash
php artisan storage:link
```

8. **Build frontend assets**
```bash
npm run build
# or for development
npm run dev
```

9. **Start development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

### 🚀 Quick Setup Script

Alternatively, use the automated setup:
```bash
composer run setup
```

---

## 🎮 Usage

### Default Credentials

After running seeders, you can login with:

**Admin Account:**
```
Email: admin@lenteraaksara.com
Password: password
```

**User Account:**
```
Email: user@lenteraaksara.com
Password: password
```

### Feature Flag Management

**Switch to TO USK Mode (Minimal Features):**
```bash
# Windows
toggle-features.bat
# Select option [1]

# PowerShell
.\toggle-features.ps1
# Select option [1]
```

**Switch to FULL Mode (All Features):**
```bash
# Windows
toggle-features.bat
# Select option [2]

# PowerShell
.\toggle-features.ps1
# Select option [2]
```

**Manual Toggle:**

Edit `.env` file and change feature flags:
```env
FEATURE_TRANSLATION=false
FEATURE_DARK_MODE=false
FEATURE_REVIEWS=false
# ... etc
```

Then clear cache:
```bash
php artisan config:clear
php artisan view:clear
```

### Development Commands

```bash
# Run all dev servers (Laravel + Vite + Queue + Logs)
composer dev

# Run tests
composer test
php artisan test

# Clear all caches
php artisan optimize:clear

# Generate IDE helper (if installed)
php artisan ide-helper:generate
php artisan ide-helper:models
```

---

## 📸 Screenshots

### Homepage - Welcome Page
![Homepage Welcome](docs/screenshots/welcome-page.png)

### Design System
For complete design mockups and prototypes, visit our Figma design:
**[View Figma Prototype](https://www.figma.com/proto/Xo4baACLkrmb6xjCsOUDW2/Lentera-Aksara-s-Mockup-Design?node-id=17-3&p=f&t=GE2P2QbRWPsfqEcA-0&scaling=min-zoom&content-scaling=fixed&page-id=2%3A2&starting-point-node-id=17%3A3&show-proto-sidebar=1)**

> 📝 Note: More screenshots will be added as the project progresses. The Figma prototype showcases the design system and UI/UX planning.

---

## 🗂️ Project Structure

```
lentera-aksara/
├── app/
│   ├── Helpers/              # Custom helper functions
│   │   ├── FeatureHelper.php
│   │   ├── NavbarHelper.php
│   │   └── TranslatorHelper.php
│   ├── Http/
│   │   ├── Controllers/      # Application controllers
│   │   ├── Middleware/       # Custom middleware
│   │   └── Requests/         # Form requests
│   ├── Models/               # Eloquent models
│   ├── Notifications/        # Notification classes
│   └── Providers/
├── config/
│   └── features.php          # Feature flags configuration
├── database/
│   ├── migrations/           # Database migrations
│   ├── seeders/              # Database seeders
│   └── factories/            # Model factories
├── public/
│   ├── hero.jpg              # Hero image
│   ├── Library.jpg           # About section image
│   └── storage/              # Symlinked storage
├── resources/
│   ├── css/
│   │   └── app.css           # Main stylesheet
│   ├── js/
│   │   └── app.js            # Main JavaScript
│   ├── lang/                 # Language files (future)
│   └── views/
│       ├── admin/            # Admin views
│       ├── user/             # User views
│       ├── auth/             # Authentication views
│       ├── layouts/          # Layout templates
│       └── welcome.blade.php # Landing page
├── routes/
│   ├── web.php               # Web routes
│   ├── auth.php              # Authentication routes
│   └── console.php           # Console routes
├── storage/
│   └── app/
│       └── public/           # User uploads
├── tests/                    # Test files
├── .env.example              # Environment template
├── .env.full                 # Full mode preset
├── .env.to-usk               # TO USK mode preset
├── toggle-features.bat       # Windows toggle script
├── toggle-features.ps1       # PowerShell toggle script
├── composer.json             # PHP dependencies
├── package.json              # Node dependencies
├── tailwind.config.js        # Tailwind configuration
└── vite.config.js            # Vite configuration
```

---

## 🗃️ Database Schema

### Main Tables

**users**
- Authentication and user profile information
- Roles: admin, user
- Profile picture support

**books**
- Book catalog with cover images
- ISBN, title, author, publisher, description
- Price and stock tracking
- Timestamps for created/updated

**categories**
- Book categorization
- Many-to-many relationship with books via `book_categories` pivot table

**orders**
- Order management with status tracking
- Linked to users
- Total amount and timestamps

**order_items**
- Individual items in an order
- Quantity and price at purchase time

**carts & cart_items**
- Persistent shopping cart
- Session-based cart storage

**reviews**
- User reviews and ratings (1-5 stars)
- Linked to books and users

**wishlists**
- User favorite books
- Many-to-many relationship

**contacts**
- Contact form messages
- Admin reply support
- Read/unread status

**notifications**
- Database-driven notification system
- Polymorphic relationship

**abouts**
- About Us page content management
- Supports image uploads

### Relationships

```
User (1) ─── (N) Order
User (1) ─── (N) Cart
User (1) ─── (N) Review
User (1) ─── (N) Contact
User (N) ─── (N) Book (Wishlist)

Book (N) ─── (N) Category
Book (1) ─── (N) Review
Book (1) ─── (N) OrderItem
Book (1) ─── (N) CartItem

Order (1) ─── (N) OrderItem
Cart (1) ─── (N) CartItem
```

---

## 🎨 Design System

### Color Palette

**Light Mode:**
```css
Primary (Olive):   #4B5320
Secondary (Slate): #2F4F4F
Accent (Tan):      #D2B48C
Background:        #F5F5F5
Text:              #2F4F4F
```

**Dark Mode:**
```css
Primary:           #9acd32 (Yellow Green)
Secondary:         #8b7355 (Mocha)
Background:        #1a1a1a
Surface:           #2d2d2d
Text:              #e5e5e5
```

### Typography

```css
Headings: 'Lora', serif (400, 600, 700)
Body:     'Inter', sans-serif (300, 400, 600, 700)
```

### Component Patterns

- **Cards**: Rounded-xl with shadow-md hover:shadow-2xl
- **Buttons**: Rounded-lg with transition-colors
- **Forms**: Consistent border-gray-200 with focus:ring-[color]
- **Badges**: Rounded-full with px-3 py-1
- **Modals**: Backdrop-blur with slide-in animation

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Coding Standards

- Follow PSR-12 coding standards for PHP
- Use Laravel best practices and conventions
- Write descriptive commit messages
- Add comments for complex logic
- Update documentation for new features

---

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👤 Author

**Dwi Wahyu Ramadhan**

- 🎓 Student at SMK Negeri 21 Jakarta
- 💻 Software Engineering (PPLG - Pemrograman Perangkat Lunak dan Gim)
- 📅 Project Date: October 15, 2025
- 🐙 GitHub: [@Nyxaria-27](https://github.com/Nyxaria-27)
- 📧 Email: dwiwahyuramadhan27@gmail.com

---

## 🙏 Acknowledgments

- **Laravel Framework**: Amazing PHP framework
- **Tailwind CSS**: Utility-first CSS framework
- **Alpine.js**: Lightweight JavaScript framework
- **AOS Library**: Scroll animation library
- **Heroicons**: Beautiful SVG icons
- **Google Translate API**: Translation services
- **DomPDF**: PDF generation library

---

## 📚 Documentation

For complete documentation, see the **[Documentation Index](docs/README.md)** 📖

**Essential Docs:**
- [Changelog](docs/CHANGELOG.md) - Version history and updates
- [Security Policy](docs/SECURITY.md) - Security guidelines and reporting

**Feature Guides:**
- [Feature Flags Guide](docs/guides/FEATURE_FLAGS_GUIDE.md) - Complete feature toggle system
- [Translation System](docs/guides/TRANSLATION_CLEAN_IMPLEMENTATION.md) - Bilingual support
- [Order Management](docs/guides/ORDER_MANAGEMENT_README.md) - Order processing
- [Wishlist Feature](docs/guides/WISHLIST_FEATURE_GUIDE.md) - Wishlist functionality

**Setup Guides:**
- [GitHub Setup Checklist](docs/guides/GITHUB_SETUP_CHECKLIST.md) - Pre-push checklist
- [Portfolio Setup](docs/guides/PORTFOLIO_SETUP_SUMMARY.md) - Portfolio preparation

👉 **[View All Documentation →](docs/README.md)**

---

## 🌐 Deployment

### Current Status
This project is planned to be deployed on **InfinityFree** hosting for live demonstration.

> � **Deployment in Progress**: Live demo URL will be available soon.

### Deployment Platform
- **Hosting**: InfinityFree (Free hosting service)
- **Database**: MySQL
- **Domain**: TBD (To be announced)

Stay tuned for the live demo link!

---

## �🐛 Known Issues

- Translation API requires internet connection
- PDF generation may be slow for large orders
- Image uploads limited to 2MB

---

## 🔮 Future Enhancements

- [ ] Deploy to InfinityFree hosting
- [ ] Payment gateway integration (Midtrans/Stripe)
- [ ] Email notification system (Mailtrap/SendGrid)
- [ ] Advanced analytics dashboard
- [ ] Book recommendations algorithm
- [ ] Social login (Google/Facebook)
- [ ] Multi-currency support
- [ ] API for mobile app integration
- [ ] Real-time chat support
- [ ] Advanced search with Elasticsearch
- [ ] Multi-vendor support

---

## 📊 Project Statistics

- **Total Lines of Code**: ~15,000+
- **Controllers**: 15+
- **Models**: 11
- **Migrations**: 15
- **Blade Templates**: 50+
- **Routes**: 80+
- **Feature Flags**: 11

---

<div align="center">

---

### 🎓 Academic Information

**Institution**: SMK Negeri 21 Jakarta  
**Program**: Software Engineering (PPLG - Pemrograman Perangkat Lunak dan Gim)  
**Project Date**: October 15, 2025  
**Developer**: Dwi Wahyu Ramadhan ([@Nyxaria-27](https://github.com/Nyxaria-27))

---

**Made with ❤️ using Laravel & Tailwind CSS**

⭐ Star this repository if you find it helpful!

**© 2025 Dwi Wahyu Ramadhan. Licensed under MIT License.**

</div>
