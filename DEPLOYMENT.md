# 🚀 Deployment Guide - Monarch Hotel Booking System

## Production Deployment Checklist

---

## 📋 Pre-Deployment Requirements

### Server Requirements
- [x] PHP 8.2 or higher
- [x] MySQL 5.7+ or MariaDB 10.3+
- [x] Composer 2.x
- [x] Node.js 18+ & npm
- [x] Apache/Nginx web server
- [x] SSL certificate for HTTPS
- [x] Minimum 2GB RAM
- [x] 10GB disk space

### PHP Extensions Required
```bash
php -m
```
Verify these are installed:
- [x] OpenSSL
- [x] PDO
- [x] Mbstring
- [x] Tokenizer
- [x] XML
- [x] Ctype
- [x] JSON
- [x] BCMath
- [x] Fileinfo
- [x] GD or Imagick (for image processing)

---

## 🔧 Step 1: Server Setup

### For Ubuntu/Debian Server

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP 8.2
sudo apt install php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath -y

# Install MySQL
sudo apt install mysql-server -y

# Secure MySQL
sudo mysql_secure_installation

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install nodejs -y

# Install Nginx
sudo apt install nginx -y
```

---

## 📦 Step 2: Deploy Application

### 1. Upload Files
```bash
# Via Git (recommended)
cd /var/www/
git clone your-repository-url monarch-hotel
cd monarch-hotel

# Or via FTP/SFTP
# Upload all files to /var/www/monarch-hotel/
```

### 2. Set Permissions
```bash
cd /var/www/monarch-hotel

# Set ownership
sudo chown -R www-data:www-data .

# Set directory permissions
sudo find . -type d -exec chmod 755 {} \;

# Set file permissions
sudo find . -type f -exec chmod 644 {} \;

# Storage and cache must be writable
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### 3. Install Dependencies
```bash
# Install PHP packages
composer install --optimize-autoloader --no-dev

# Install Node packages
npm install

# Build frontend assets
npm run build
```

---

## ⚙️ Step 3: Configure Environment

### 1. Create .env File
```bash
cp .env.example .env
nano .env
```

### 2. Update Environment Variables

```env
# Application
APP_NAME="Monarch Hotel"
APP_ENV=production
APP_KEY=  # Will be generated
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=monarch_hotel_production
DB_USERNAME=monarch_user
DB_PASSWORD=STRONG_PASSWORD_HERE

# Mail (Example with Gmail)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=info@monarchhotel.com
MAIL_FROM_NAME="Monarch Hotel"

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Queue
QUEUE_CONNECTION=database

# Cache
CACHE_STORE=database

# File Storage
FILESYSTEM_DISK=public
```

### 3. Generate Application Key
```bash
php artisan key:generate
```

---

## 🗄️ Step 4: Database Setup

### 1. Create Database
```bash
mysql -u root -p
```

```sql
CREATE DATABASE monarch_hotel_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER 'monarch_user'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD_HERE';

GRANT ALL PRIVILEGES ON monarch_hotel_production.* TO 'monarch_user'@'localhost';

FLUSH PRIVILEGES;

EXIT;
```

### 2. Run Migrations
```bash
php artisan migrate --force
```

### 3. Seed Initial Data (Optional for Production)
```bash
# Only if you want demo data
php artisan db:seed --force

# Or seed specific essential data only
php artisan db:seed --class=RoomTypeSeeder --force
php artisan db:seed --class=AmenitySeeder --force
php artisan db:seed --class=UserSeeder --force
```

### 4. Create Admin User
```bash
php artisan tinker
```

```php
$admin = App\Models\User::create([
    'name' => 'Hotel Administrator',
    'email' => 'admin@yourdomain.com',
    'password' => bcrypt('YOUR_SECURE_PASSWORD'),
    'email_verified_at' => now(),
    'role' => 'admin'
]);

$admin->assignRole('admin');
exit
```

---

## 🔗 Step 5: Storage Link

```bash
php artisan storage:link
```

---

## 🌐 Step 6: Web Server Configuration

### Nginx Configuration

Create `/etc/nginx/sites-available/monarch-hotel`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/monarch-hotel/public;

    # SSL Configuration
    ssl_certificate /etc/ssl/certs/your-certificate.crt;
    ssl_certificate_key /etc/ssl/private/your-private-key.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";

    index index.php;

    charset utf-8;

    # Increase upload size
    client_max_body_size 20M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Cache static assets
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 365d;
        add_header Cache-Control "public, immutable";
    }
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/monarch-hotel /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Apache Configuration (.htaccess)

Laravel includes `.htaccess` in `public/` folder. Ensure `mod_rewrite` is enabled:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

---

## 🔒 Step 7: SSL Certificate

### Using Let's Encrypt (Free)

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx -y

# Get certificate
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renewal (already set up by certbot)
sudo certbot renew --dry-run
```

---

## 🔐 Step 8: Security Hardening

### 1. Environment File Security
```bash
chmod 600 .env
```

### 2. Disable Directory Listing
Add to `.htaccess` or server config:
```apache
Options -Indexes
```

### 3. Hide Laravel Version
Edit `public/.htaccess`, add:
```apache
ServerSignature Off
```

### 4. Enable Firewall
```bash
sudo ufw allow 'Nginx Full'
sudo ufw allow OpenSSH
sudo ufw enable
```

### 5. Fail2Ban (Protection against brute force)
```bash
sudo apt install fail2ban -y
sudo systemctl enable fail2ban
```

---

## ⚡ Step 9: Performance Optimization

### 1. Cache Configuration
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Optimize Autoloader
```bash
composer dump-autoload --optimize
```

### 3. Enable OPcache
Edit `/etc/php/8.2/fpm/php.ini`:
```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.revalidate_freq=60
```

Restart PHP-FPM:
```bash
sudo systemctl restart php8.2-fpm
```

---

## 📧 Step 10: Email Configuration

### Gmail SMTP (Development/Small scale)
1. Enable 2-factor authentication in Gmail
2. Generate App Password: https://myaccount.google.com/apppasswords
3. Use in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=tls
```

### SendGrid (Recommended for Production)
1. Create account at https://sendgrid.com
2. Get API key
3. Configure:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
```

### Mailgun, Amazon SES, etc.
Follow Laravel documentation: https://laravel.com/docs/12.x/mail

---

## 🔄 Step 11: Queue & Scheduler Setup

### 1. Configure Supervisor (Queue Worker)

Create `/etc/supervisor/conf.d/monarch-hotel.conf`:

```ini
[program:monarch-hotel-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/monarch-hotel/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/monarch-hotel/storage/logs/queue.log
stopwaitsecs=3600
```

Start queue:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start monarch-hotel-queue:*
```

### 2. Configure Cron (Task Scheduler)

```bash
sudo crontab -e -u www-data
```

Add:
```cron
* * * * * cd /var/www/monarch-hotel && php artisan schedule:run >> /dev/null 2>&1
```

---

## 💾 Step 12: Backup Strategy

### 1. Database Backup Script

Create `/var/www/monarch-hotel/backup.sh`:

```bash
#!/bin/bash
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
BACKUP_DIR="/var/backups/monarch-hotel"
DB_NAME="monarch_hotel_production"
DB_USER="monarch_user"
DB_PASS="YOUR_DB_PASSWORD"

mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_$TIMESTAMP.sql.gz

# Backup uploads
tar -czf $BACKUP_DIR/storage_$TIMESTAMP.tar.gz /var/www/monarch-hotel/storage/app/public

# Keep only last 7 days
find $BACKUP_DIR -type f -mtime +7 -delete

echo "Backup completed: $TIMESTAMP"
```

Make executable:
```bash
chmod +x /var/www/monarch-hotel/backup.sh
```

### 2. Schedule Automated Backups

```bash
sudo crontab -e
```

Add (daily at 2 AM):
```cron
0 2 * * * /var/www/monarch-hotel/backup.sh
```

---

## 📊 Step 13: Monitoring & Logging

### 1. Laravel Logs
```bash
tail -f /var/www/monarch-hotel/storage/logs/laravel.log
```

### 2. Web Server Logs
```bash
# Nginx
tail -f /var/log/nginx/access.log
tail -f /var/log/nginx/error.log

# Apache
tail -f /var/log/apache2/access.log
tail -f /var/log/apache2/error.log
```

### 3. Set Up Log Rotation

Create `/etc/logrotate.d/monarch-hotel`:

```
/var/www/monarch-hotel/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
}
```

---

## 🧪 Step 14: Post-Deployment Testing

### Functionality Checklist

```bash
# Test homepage
curl -I https://yourdomain.com

# Test admin login
# Visit: https://yourdomain.com/login

# Check storage link
ls -la /var/www/monarch-hotel/public/storage

# Test email
php artisan tinker
>>> Mail::raw('Test email', function($msg) { $msg->to('test@example.com')->subject('Test'); });

# Check queue status
sudo supervisorctl status monarch-hotel-queue:*

# Check scheduled tasks
php artisan schedule:list
```

### Manual Testing
1. [ ] Homepage loads
2. [ ] Browse rooms
3. [ ] Create booking as guest
4. [ ] Register new account
5. [ ] Login as customer
6. [ ] View customer dashboard
7. [ ] Login as admin
8. [ ] View admin dashboard
9. [ ] Manage bookings
10. [ ] Upload images
11. [ ] Create promotion
12. [ ] Generate report PDF
13. [ ] Send email notification
14. [ ] Submit contact form

---

## 🔄 Step 15: Deployment Updates

### For Future Updates

```bash
cd /var/www/monarch-hotel

# Pull latest code
git pull origin main

# Update dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Run migrations
php artisan migrate --force

# Clear all caches
php artisan optimize:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart services
sudo supervisorctl restart monarch-hotel-queue:*
sudo systemctl reload php8.2-fpm
sudo systemctl reload nginx
```

---

## 🆘 Troubleshooting

### Issue: 500 Internal Server Error
```bash
# Check Laravel logs
tail -50 storage/logs/laravel.log

# Check permissions
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

# Clear cache
php artisan optimize:clear
```

### Issue: Database Connection Failed
```bash
# Test MySQL connection
mysql -u monarch_user -p monarch_hotel_production

# Check .env credentials
cat .env | grep DB_

# Verify user permissions
mysql -u root -p
SHOW GRANTS FOR 'monarch_user'@'localhost';
```

### Issue: Images Not Uploading
```bash
# Check storage permissions
ls -la storage/app/public

# Recreate symlink
rm public/storage
php artisan storage:link

# Check PHP upload limits in php.ini
grep -E "upload_max_filesize|post_max_size" /etc/php/8.2/fpm/php.ini
```

### Issue: Emails Not Sending
```bash
# Test mail configuration
php artisan tinker
>>> Mail::raw('Test', function($msg) { $msg->to('test@example.com')->subject('Test'); });

# Check queue is running
sudo supervisorctl status monarch-hotel-queue:*

# Check mail logs
tail -50 storage/logs/laravel.log | grep -i mail
```

---

## 📈 Performance Monitoring

### Install Laravel Telescope (Optional - Dev/Staging only)
```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

**⚠️ Never enable Telescope in production!**

### Use Tools Like:
- **New Relic** - Application performance monitoring
- **DataDog** - Infrastructure monitoring
- **Sentry** - Error tracking
- **Google Analytics** - User behavior tracking

---

## 🔐 Change Default Admin Password

```bash
php artisan tinker
```

```php
$admin = App\Models\User::where('email', 'admin@monarchhotel.com')->first();
$admin->password = bcrypt('NEW_SECURE_PASSWORD');
$admin->save();
exit
```

---

## ✅ Final Production Checklist

- [ ] All `.env` variables configured correctly
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] Strong `APP_KEY` generated
- [ ] Database credentials secured
- [ ] SSL certificate installed and working
- [ ] File permissions set correctly
- [ ] Storage link created
- [ ] Email sending tested
- [ ] Queue workers running
- [ ] Cron jobs scheduled
- [ ] Backups automated
- [ ] Firewall enabled
- [ ] Admin password changed
- [ ] Error pages customized
- [ ] Monitoring tools configured
- [ ] All caches optimized
- [ ] Application tested end-to-end

---

## 🎉 Deployment Complete!

Your Monarch Hotel Booking System is now live and ready to accept bookings!

**Access URLs:**
- Public Site: https://yourdomain.com
- Admin Panel: https://yourdomain.com/admin
- Customer Dashboard: https://yourdomain.com/customer

**Remember to:**
1. Monitor server resources
2. Review logs regularly
3. Keep dependencies updated
4. Test backups periodically
5. Monitor email deliverability

---

**Need Help?**

- Laravel Docs: https://laravel.com/docs/12.x
- Laravel Forge (Automated Deployment): https://forge.laravel.com
- Laravel Vapor (Serverless): https://vapor.laravel.com

