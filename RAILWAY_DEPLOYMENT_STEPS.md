# 🚂 RAILWAY DEPLOYMENT - Complete Guide

## ✅ **CURRENT STATUS:**

Your code is ready with the composer.json fix! Now we need to:
1. Push to GitHub
2. Let Railway auto-deploy

---

## 📤 **STEP 1: PUSH TO GITHUB (Do this first!)**

### **Option A: Use the script I created**
```powershell
cd e:\royal-crest-hotel
.\push-to-github.ps1
```

### **Option B: Manual commands**
```powershell
cd e:\royal-crest-hotel
git pull origin main --rebase
git push origin main
```

### **If you get credential prompts:**
- Enter your GitHub username
- Enter your Personal Access Token (PAT) as password
  - Don't have a PAT? Create one at: https://github.com/settings/tokens
  - Select scope: `repo` (full control of private repositories)

---

## 🚂 **STEP 2: RAILWAY DEPLOYMENT**

### **A. If Railway is already deployed and watching your repo:**

Railway will **automatically redeploy** when you push to GitHub! Just:
1. Push to GitHub (Step 1 above)
2. Go to your Railway dashboard
3. Watch the build logs - it should start building automatically
4. Wait for "Build succeeded" ✅

---

### **B. If starting fresh on Railway:**

#### **1. Go to Railway Dashboard**
Open: https://railway.app/dashboard

#### **2. Create New Project**
- Click **"+ New"** button (top right)
- Select **"Deploy from GitHub repo"**

#### **3. Authorize GitHub**
- Click **"Configure GitHub App"**
- Select your repositories
- Choose: `royal-crest-hotel`

#### **4. Railway Auto-Detects Laravel**
Railway will automatically:
- ✅ Detect PHP 8.2
- ✅ Run `composer install`
- ✅ Build assets with npm
- ✅ Start your Laravel app

#### **5. Add MySQL Database**
1. In Railway project → Click **"+ New"**
2. Select **"Database"**
3. Choose **"MySQL"**
4. Wait ~1 minute for provisioning

#### **6. Copy Database Credentials**
1. Click on **MySQL** service
2. Go to **"Variables"** tab
3. Copy these values:
   - `MYSQL_HOST`
   - `MYSQL_PORT` 
   - `MYSQL_DATABASE`
   - `MYSQL_USER`
   - `MYSQL_PASSWORD`
   - `MYSQL_URL` (or construct it)

#### **7. Configure Laravel Environment Variables**
1. Click on your **web** service (Laravel app)
2. Go to **"Variables"** tab
3. Click **"+ New Variable"**
4. Add these **one by one**:

```env
APP_NAME=The Royal Crest
APP_ENV=production
APP_KEY=base64:6pGiXcSDhkAL5Rks8dh2s50PIFk96mkM1u/XRkZ2ijI=
APP_DEBUG=false
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}

DB_CONNECTION=mysql
DB_HOST=${{MYSQL_HOST}}
DB_PORT=${{MYSQL_PORT}}
DB_DATABASE=${{MYSQL_DATABASE}}
DB_USERNAME=${{MYSQL_USER}}
DB_PASSWORD=${{MYSQL_PASSWORD}}

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

SKIP_OTP=false
```

**Note:** The `${{VARIABLE}}` syntax tells Railway to reference other services!

#### **8. Generate Public Domain**
1. In your **web** service → **"Settings"** tab
2. Scroll to **"Networking"**
3. Click **"Generate Domain"**
4. You'll get: `https://your-app.railway.app`

#### **9. Run Database Migrations**
After first deployment:

1. Go to **web** service → **"Settings"**
2. Find **"Custom Start Command"** (optional, or use one-time command)
3. Temporarily run migration:
   - Go to **"Deployments"** tab
   - Click latest deployment
   - Click **"View Logs"**
   - Or use Railway CLI (see below)

**Using Railway CLI for migrations:**
```bash
# Install Railway CLI
npm install -g @railway/cli

# Login
railway login

# Link to project
railway link

# Run migration
railway run php artisan migrate --force

# Seed database (optional)
railway run php artisan db:seed --force
```

#### **10. Access Your Live Site! 🎉**
Open your Railway domain in browser!

---

## 🔍 **TROUBLESHOOTING**

### **If build fails:**
1. Check **"Deployments"** → **"Build Logs"**
2. Common issues:
   - Composer dependencies issue → Check composer.json
   - Node build fail → Check package.json scripts
   - PHP version mismatch → Railway uses PHP 8.2 by default

### **If site shows errors:**
1. Check **"Deployments"** → **"Deploy Logs"**
2. Common issues:
   - Database not connected → Check environment variables
   - Missing APP_KEY → Set it in variables
   - Migrations not run → Run `php artisan migrate --force`

### **If database connection fails:**
1. Verify MySQL service is running (green status)
2. Check all `DB_*` variables are set correctly
3. Make sure services are in same project (Railway connects them automatically)

---

## 📋 **POST-DEPLOYMENT CHECKLIST**

- [ ] Site loads without errors
- [ ] Can access homepage
- [ ] Can register/login
- [ ] Database is connected
- [ ] Can create bookings
- [ ] Email sending works
- [ ] Images load properly
- [ ] HTTPS is active (automatic on Railway)

---

## 🎯 **NEXT STEPS AFTER DEPLOYMENT**

### **1. Set up custom domain (optional)**
1. Go to **"Settings"** → **"Networking"**
2. Add your custom domain
3. Update DNS records at your domain provider

### **2. Monitor your app**
- Railway provides real-time logs
- Check **"Metrics"** tab for usage
- Free tier: $5 monthly credit

### **3. Update deployment**
Every time you push to GitHub, Railway will:
- ✅ Auto-detect changes
- ✅ Build new version
- ✅ Deploy automatically
- ✅ Zero-downtime deployment

---

## 💰 **RAILWAY PRICING**

**Free Tier:**
- $5 monthly credit
- Enough for small apps and testing
- No credit card required for trial

**If you exceed:**
- Add payment method
- Pay-as-you-go pricing
- ~$5-20/month for small Laravel apps

---

## 🆘 **NEED HELP?**

### **Railway Issues:**
- Railway Docs: https://docs.railway.app
- Railway Discord: https://discord.gg/railway
- Railway Status: https://status.railway.app

### **Laravel Issues:**
- Check logs in Railway dashboard
- Run artisan commands via Railway CLI
- SSH into container (available via Railway CLI)

---

## ✅ **SUMMARY:**

**Right now, do this:**
1. ✅ Push to GitHub: `git push origin main`
2. ✅ Go to Railway dashboard
3. ✅ Wait for auto-deployment OR
4. ✅ Follow "Starting Fresh" steps above

**The fix is already in your code** - Railway just needs the latest version from GitHub!

---

**Good luck! 🚀 Your Royal Crest Hotel will be live soon!**
