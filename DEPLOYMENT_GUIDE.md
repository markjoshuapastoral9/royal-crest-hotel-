# 🚀 Royal Crest Hotel - Deployment Guide

## 📋 **PRE-DEPLOYMENT CHECKLIST**

Before deploying, make sure you have:
- [ ] All code pushed to GitHub
- [ ] `.env.example` file updated
- [ ] Database migrations ready
- [ ] Composer dependencies installed
- [ ] NPM build completed locally (test)

---

## 🎯 **OPTION 1: RAILWAY (RECOMMENDED)**

### **Step 1: Push to GitHub**
```bash
git add .
git commit -m "Prepare for Railway deployment"
git push origin main
```

### **Step 2: Deploy on Railway**
1. Go to: **https://railway.app**
2. Click **"Start a New Project"**
3. Click **"Deploy from GitHub repo"**
4. Select: **`royal-crest-hotel`**
5. Railway will auto-detect Laravel

### **Step 3: Add MySQL Database**
1. In Railway dashboard → **"New"** → **"Database"** → **"MySQL"**
2. Wait for database to provision
3. Copy the database credentials

### **Step 4: Configure Environment Variables**
In Railway project settings → **"Variables"**, add these:

```env
APP_NAME="The Royal Crest"
APP_ENV=production
APP_KEY=base64:6pGiXcSDhkAL5Rks8dh2s50PIFk96mkM1u/XRkZ2ijI=
APP_DEBUG=false
APP_URL=https://your-app.railway.app

DB_CONNECTION=mysql
DB_HOST=<from Railway MySQL>
DB_PORT=<from Railway MySQL>
DB_DATABASE=<from Railway MySQL>
DB_USERNAME=<from Railway MySQL>
DB_PASSWORD=<from Railway MySQL>

SESSION_DRIVER=database
SESSION_LIFETIME=240

CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=markjoshuapastoral9@gmail.com
MAIL_PASSWORD=damygagcrtqoculb
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=markjoshuapastoral9@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

SKIP_OTP=false
```

### **Step 5: Run Migrations**
In Railway → **"Settings"** → **"Deploy"** → Add one-time command:
```bash
php artisan migrate --force --seed
```

### **Step 6: Generate App Key (if needed)**
```bash
php artisan key:generate --force
```

### **Step 7: Access Your Site**
Railway will give you a URL like: `https://royal-crest-hotel.railway.app`

---

## 🎯 **OPTION 2: RENDER.COM**

### **Step 1: Create Render Account**
1. Go to: **https://render.com**
2. Sign up with GitHub

### **Step 2: Create Web Service**
1. **"New +"** → **"Web Service"**
2. Connect repository: `royal-crest-hotel`
3. Configure:
   - **Name**: royal-crest-hotel
   - **Environment**: Docker or PHP
   - **Build Command**: `composer install --no-dev && npm install && npm run build`
   - **Start Command**: `php artisan serve --host=0.0.0.0 --port=$PORT`

### **Step 3: Add MySQL Database**
1. **"New +"** → **"PostgreSQL"** or use external MySQL
2. Copy database credentials

### **Step 4: Environment Variables**
Add all variables from `.env` (same as Railway above)

### **Step 5: Deploy**
Click **"Create Web Service"**

---

## 🎯 **OPTION 3: HEROKU**

### **Step 1: Install Heroku CLI**
Download from: https://devcenter.heroku.com/articles/heroku-cli

### **Step 2: Create Procfile**
```
web: vendor/bin/heroku-php-apache2 public/
```

### **Step 3: Deploy**
```bash
# Login
heroku login

# Create app
heroku create royal-crest-hotel

# Add MySQL addon
heroku addons:create cleardb:ignite

# Get database URL
heroku config:get CLEARDB_DATABASE_URL

# Set environment variables
heroku config:set APP_KEY=base64:6pGiXcSDhkAL5Rks8dh2s50PIFk96mkM1u/XRkZ2ijI=
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false

# Push to Heroku
git push heroku main

# Run migrations
heroku run php artisan migrate --force
```

---

## 🎯 **OPTION 4: DIGITAL OCEAN APP PLATFORM**

### **Step 1: Create Account**
Go to: **https://www.digitalocean.com/products/app-platform**

### **Step 2: Create App**
1. Click **"Create App"**
2. Connect GitHub repository
3. Select `royal-crest-hotel`

### **Step 3: Configure**
- **Type**: Web Service
- **Build Command**: `composer install && npm run build`
- **Run Command**: `php artisan serve --host=0.0.0.0 --port=8080`

### **Step 4: Add Database**
1. Add **MySQL** component
2. Configure environment variables

### **Step 5: Deploy**
Click **"Create Resources"**

---

## 🎯 **OPTION 5: TRADITIONAL SHARED HOSTING**

### **Popular PHP Hosting (with cPanel):**
- **InfinityFree** (Free): https://infinityfree.net
- **000webhost** (Free): https://www.000webhost.com
- **Hostinger** (Paid, $2/mo): https://www.hostinger.com
- **Namecheap** (Paid, $2/mo): https://www.namecheap.com

### **Deployment Steps:**
1. **Export Project Files**
   ```bash
   composer install --no-dev
   npm run build
   ```

2. **Upload via FTP**
   - Upload all files to `public_html` or `www`
   - Point domain to `/public` folder

3. **Import Database**
   - Export local database: `mysqldump -u root monarch_hotel > database.sql`
   - Import via phpMyAdmin

4. **Update .env**
   - Update database credentials
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`

5. **Set Permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

---

## 🔥 **COMPARISON TABLE**

| Platform | Free Tier | Ease | Speed | Database | Auto-Deploy | SSL |
|----------|-----------|------|-------|----------|-------------|-----|
| **Railway** | ✅ $5/mo | ⭐⭐⭐⭐⭐ | Fast | ✅ Included | ✅ | ✅ |
| **Render** | ✅ Limited | ⭐⭐⭐⭐ | Medium | ✅ Included | ✅ | ✅ |
| **Heroku** | ⚠️ Credit card | ⭐⭐⭐ | Medium | ⚠️ Addon | ✅ | ✅ |
| **DigitalOcean** | ❌ $5/mo | ⭐⭐⭐⭐ | Fast | ✅ Included | ✅ | ✅ |
| **Shared Hosting** | ✅ Some free | ⭐⭐ | Slow | ✅ Included | ❌ | ⚠️ |

---

## 🎖️ **MY RECOMMENDATION: RAILWAY**

**Why?**
1. **Super easy** - One-click deploy
2. **Free tier** - $5 monthly credit (enough for testing)
3. **MySQL included** - No external database needed
4. **Auto-deploy** - Push to GitHub = instant deploy
5. **SSL automatic** - HTTPS out of the box

---

## 🛠️ **PRODUCTION OPTIMIZATION**

Before deploying, optimize your app:

```bash
# 1. Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 2. Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Build assets
npm run build

# 4. Update composer
composer install --optimize-autoloader --no-dev
```

---

## 🚨 **IMPORTANT SECURITY NOTES**

### **Update these in production .env:**
```env
APP_ENV=production
APP_DEBUG=false
SKIP_OTP=false
SESSION_SECURE_COOKIE=true
```

### **Hide sensitive files:**
Make sure `.env` is in `.gitignore` (already done)

---

## 📞 **NEED HELP?**

If you encounter issues, check:
1. **Logs**: Railway/Render provide real-time logs
2. **Database**: Make sure migrations ran successfully
3. **Storage**: Ensure `storage/` and `bootstrap/cache/` are writable
4. **Environment**: Double-check all `.env` variables

---

## ✅ **POST-DEPLOYMENT CHECKLIST**

- [ ] Site loads without errors
- [ ] Database connected (test login)
- [ ] Email sending works (test contact form)
- [ ] File uploads work (test room images)
- [ ] Booking system functional
- [ ] Payment system configured
- [ ] SSL certificate active (HTTPS)
- [ ] Custom domain connected (optional)

---

**Good luck with your deployment! 🚀**
