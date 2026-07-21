# 🏨 The Royal Crest Hotel Booking System

A modern, full-featured hotel booking and management system built with **Laravel 11** and **Bootstrap 5**. Features a dark-themed admin panel, real-time notifications, email confirmations, and multi-language support.

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-purple.svg)
![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)

---

## ✨ Features

### 🎯 Customer Features
- **Room Browsing & Booking** - Browse available rooms with detailed information
- **Real-time Availability** - Check room availability by date with calendar view
- **Multiple Payment Methods** - GCash, Maya, Bank Transfer, Cash
- **Booking Management** - View, track, and cancel bookings
- **Email Notifications** - Automated booking confirmations with embedded images
- **Promo Code Support** - Apply discount codes at checkout
- **Multi-language Support** - English, Filipino, Japanese, Korean, Chinese, Spanish
- **OTP Verification** - Secure email-based one-time password authentication

### 👨‍💼 Admin Features
- **Dark-themed Dashboard** - Modern, professional admin interface
- **Booking Management** - Approve, confirm, check-in, and manage all bookings
- **Room & Room Type Management** - Create and manage rooms with multiple units
- **Calendar View** - Visual booking calendar with drag-and-drop
- **User Management** - Manage customers and staff accounts
- **Payment Verification** - Review and verify payment proofs
- **Email Blast** - Send promotional emails to all registered guests
- **Reports & Analytics** - Revenue reports and booking statistics
- **Facility & Gallery Management** - Showcase hotel amenities
- **Promotion Management** - Create and manage discount promotions
- **QR Code Check-in** - Fast check-in with QR code scanning

---

## 🛠️ Tech Stack

- **Backend:** Laravel 11, PHP 8.2+
- **Frontend:** Bootstrap 5, Blade Templates, Vanilla JavaScript
- **Database:** MySQL
- **Email:** Laravel Mail (SMTP/Gmail support)
- **Authentication:** Laravel Breeze + Jetstream
- **Notifications:** Real-time notification system
- **Queue:** Database queue for email processing
- **PDF Generation:** DomPDF for invoices and receipts

---

## 📋 Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL 5.7+
- Node.js & NPM
- Git (optional)

---

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/YOUR_USERNAME/royal-crest-hotel-booking.git
cd royal-crest-hotel-booking
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=royal_crest_hotel
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Configure Email (Gmail)
1. Generate Gmail App Password: https://myaccount.google.com/apppasswords
2. Update `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
```

### 6. Run Migrations & Seed Database
```bash
# Create database tables
php artisan migrate

# Seed with sample data (rooms, admin user, etc.)
php artisan db:seed
```

### 7. Storage Link
```bash
php artisan storage:link
```

### 8. Build Assets
```bash
npm run build
```

### 9. Start Development Server
```bash
# Option 1: Laravel built-in server
php artisan serve

# Option 2: Using custom batch file
start-server.bat
```

Visit: **http://127.0.0.1:8000**

---

## 🔐 Default Admin Credentials

After seeding, you can login with:

```
Email: admin@theroyalcrest.com
Password: password
```

**⚠️ Important:** Change the default password immediately after first login!

---

## 📁 Project Structure

```
royal-crest-hotel-booking/
├── app/
│   ├── Console/Commands/      # Artisan commands
│   ├── Http/Controllers/      # Controllers
│   │   ├── Admin/            # Admin controllers
│   │   ├── Auth/             # Authentication
│   │   └── Api/              # API controllers
│   ├── Mail/                 # Mailable classes
│   ├── Models/               # Eloquent models
│   └── Notifications/        # Notification classes
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── public/
│   └── images/               # Public images (logo, rooms)
├── resources/
│   ├── views/
│   │   ├── admin/           # Admin panel views
│   │   ├── auth/            # Auth pages
│   │   ├── booking/         # Booking pages
│   │   ├── emails/          # Email templates
│   │   └── layouts/         # Layout templates
│   └── lang/                # Language files
└── routes/
    ├── web.php              # Web routes
    └── api.php              # API routes
```

---

## 🎨 Screenshots

### Customer Booking Flow
- **Home Page** - Hero section with featured rooms
- **Rooms Page** - Browse all available rooms
- **Booking Form** - Multi-step booking process
- **Payment** - Multiple payment method options

### Admin Dashboard
- **Dark Theme** - Professional dark interface
- **Booking Management** - Manage all reservations
- **Calendar View** - Visual booking calendar
- **Reports** - Analytics and revenue reports

---

## 🌐 Multi-language Support

Supported languages:
- 🇺🇸 English
- 🇵🇭 Filipino (Tagalog)
- 🇯🇵 Japanese (日本語)
- 🇰🇷 Korean (한국어)
- 🇨🇳 Chinese (中文)
- 🇪🇸 Spanish (Español)

Language files located in: `resources/lang/`

---

## 📧 Email Features

- **Booking Confirmation** - Sent after booking with CID-embedded images
- **Booking Approved** - Notification when admin approves booking
- **Booking Cancelled** - Notification on cancellation
- **Email Blast** - Mass email to all registered guests
- **OTP Verification** - One-time password for secure login

---

## 🔧 Configuration

### Disable OTP (for testing)
In `.env`:
```env
SKIP_OTP=true
```

### Queue Configuration
For production, use database queue:
```env
QUEUE_CONNECTION=database
```

Then run queue worker:
```bash
php artisan queue:work
```

---

## 🧪 Testing

```bash
# Run PHPUnit tests
php artisan test

# Run specific test
php artisan test --filter=BookingTest
```

---

## 📝 API Documentation

API endpoints available at `/api/*`:
- `/api/login` - User authentication
- `/api/register` - User registration
- `/api/rooms` - List all rooms
- `/api/bookings` - Booking management

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Author

**Mark Joshua Pastoral**
- GitHub: [@markjoshuapastoral](https://github.com/markjoshuapastoral)
- Email: markjoshuapastoral9@gmail.com

---

## 🙏 Acknowledgments

- Laravel Framework
- Bootstrap 5
- Flatpickr (Date picker)
- FullCalendar (Calendar view)
- Font Awesome / Bootstrap Icons

---

## 📞 Support

For issues and questions:
- Open an issue on GitHub
- Email: markjoshuapastoral9@gmail.com

---

## 🗺️ Roadmap

Future enhancements:
- [ ] Online payment gateway integration (PayPal, Stripe)
- [ ] Mobile app (Flutter/React Native)
- [ ] Advanced analytics dashboard
- [ ] Customer review system
- [ ] Room cleaning management
- [ ] Restaurant/dining reservation
- [ ] Multi-property support
- [ ] API rate limiting
- [ ] Unit tests coverage

---

**Made with ❤️ in the Philippines**
