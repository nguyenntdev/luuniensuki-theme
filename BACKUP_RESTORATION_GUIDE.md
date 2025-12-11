# Luuniensuki Theme - Backup & Restoration Guide

**Backup Created:** 2024-12-11 07:22:34 UTC  
**Backup Location:** `/root/backups/luuniensuki-theme_backup_20251211_072234.tar.gz`  
**Backup Size:** 3.1 MB  
**Server:** 47.236.61.220

---

## 🔒 Backup Information

### What's Included in the Backup:
- ✅ All theme source files (SCSS, PHP, Mustache templates)
- ✅ AMD JavaScript modules (src and build)
- ✅ Language strings
- ✅ Configuration files
- ✅ Fonts and assets
- ✅ Documentation

### What's Excluded:
- ❌ `.git` directory (version control - use git for history)
- ❌ `node_modules` (can be reinstalled via npm)
- ❌ Source maps (can be regenerated)

---

## 📋 Pre-Restoration Checklist

Before restoring, ensure you have:

- [ ] SSH access to the server (47.236.61.220)
- [ ] Root or sudo privileges
- [ ] The backup file accessible
- [ ] Moodle site in maintenance mode (recommended)
- [ ] Current database backup (if needed)

---

## 🔄 Full Restoration Procedure

### Step 1: Connect to Server

```bash
ssh root@47.236.61.220
# Enter password: [G^('0j.
```

### Step 2: Enable Moodle Maintenance Mode (Recommended)

```bash
# Find your Moodle installation directory
MOODLE_DIR="/var/www/html/moodle"  # Adjust if different

# Enable maintenance mode
sudo -u www-data php ${MOODLE_DIR}/admin/cli/maintenance.php --enable

# Or via web interface:
# Site administration → Server → Maintenance mode → Enable
```

### Step 3: Backup Current Theme (Safety)

```bash
# Create a safety backup of the current state
cd /var/www/html/moodle/theme  # Adjust path to your Moodle theme directory
sudo tar -czf /root/backups/luuniensuki-current_$(date +%Y%m%d_%H%M%S).tar.gz luuniensuki/

# Verify backup created
ls -lh /root/backups/
```

### Step 4: Restore Theme Files

```bash
# Navigate to Moodle themes directory
cd /var/www/html/moodle/theme

# Remove current theme directory (BE CAREFUL!)
sudo rm -rf luuniensuki/

# Extract backup
sudo tar -xzf /root/backups/luuniensuki-theme_backup_20251211_072234.tar.gz -C ./
sudo mv theme luuniensuki  # If needed, adjust based on extraction

# Alternative: Extract directly to target
sudo mkdir -p luuniensuki
sudo tar -xzf /root/backups/luuniensuki-theme_backup_20251211_072234.tar.gz -C luuniensuki/
```

### Step 5: Set Correct Permissions

```bash
# Set ownership (www-data is typical for Apache/Nginx)
sudo chown -R www-data:www-data /var/www/html/moodle/theme/luuniensuki

# Set directory permissions
sudo find /var/www/html/moodle/theme/luuniensuki -type d -exec chmod 755 {} \;

# Set file permissions
sudo find /var/www/html/moodle/theme/luuniensuki -type f -exec chmod 644 {} \;
```

### Step 6: Clear Moodle Caches

```bash
# Clear all caches via CLI
sudo -u www-data php ${MOODLE_DIR}/admin/cli/purge_caches.php

# Or manually delete cache directories
sudo rm -rf ${MOODLE_DIR}/moodledata/cache/*
sudo rm -rf ${MOODLE_DIR}/moodledata/localcache/*
```

### Step 7: Upgrade Theme (if needed)

```bash
# Run Moodle upgrade script to ensure database is updated
sudo -u www-data php ${MOODLE_DIR}/admin/cli/upgrade.php --non-interactive
```

### Step 8: Disable Maintenance Mode

```bash
# Disable maintenance mode
sudo -u www-data php ${MOODLE_DIR}/admin/cli/maintenance.php --disable
```

### Step 9: Verify Restoration

1. **Access your Moodle site** via browser
2. **Navigate to:** Site administration → Appearance → Themes → Theme selector
3. **Verify theme** appears in the list
4. **Test theme** by viewing a course page
5. **Check console** for any JavaScript errors (F12 → Console)

---

## 🚨 Emergency Quick Restore

If you need to restore immediately without detailed steps:

```bash
# One-liner restore (CAUTION: Destructive!)
cd /var/www/html/moodle/theme && \
sudo rm -rf luuniensuki && \
sudo mkdir luuniensuki && \
sudo tar -xzf /root/backups/luuniensuki-theme_backup_20251211_072234.tar.gz -C luuniensuki/ && \
sudo chown -R www-data:www-data luuniensuki && \
sudo -u www-data php /var/www/html/moodle/admin/cli/purge_caches.php
```

---

## 📦 Restoring from Git (Alternative)

If you prefer to restore from version control:

```bash
cd /var/www/html/moodle/theme/luuniensuki
git fetch origin
git checkout feature/imperial-theme  # Or appropriate branch
git pull origin feature/imperial-theme
sudo chown -R www-data:www-data .
sudo -u www-data php /var/www/html/moodle/admin/cli/purge_caches.php
```

---

## 🔍 Troubleshooting

### Issue: Theme Not Appearing

**Solution:**
```bash
# Verify theme directory exists
ls -la /var/www/html/moodle/theme/luuniensuki

# Check version.php exists and is readable
cat /var/www/html/moodle/theme/luuniensuki/version.php

# Re-run upgrade
sudo -u www-data php /var/www/html/moodle/admin/cli/upgrade.php
```

### Issue: Permission Denied Errors

**Solution:**
```bash
# Reset all permissions
sudo chown -R www-data:www-data /var/www/html/moodle/theme/luuniensuki
sudo chmod -R 755 /var/www/html/moodle/theme/luuniensuki
```

### Issue: Styles Not Loading / Old Styles Showing

**Solution:**
```bash
# Regenerate CSS
cd /var/www/html/moodle/theme/luuniensuki
sudo -u www-data php regenerate_css.php

# Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)
# Or use incognito/private browsing mode
```

### Issue: JavaScript Errors

**Solution:**
```bash
# Rebuild AMD modules
cd /var/www/html/moodle/theme/luuniensuki
npm install
sudo -u www-data php /var/www/html/moodle/admin/cli/build_amd_modules.php
```

---

## 📊 Backup Verification

To verify backup integrity:

```bash
# Test extraction without overwriting
cd /tmp
tar -tzf /root/backups/luuniensuki-theme_backup_20251211_072234.tar.gz | head -20

# Check backup size and contents
tar -tzf /root/backups/luuniensuki-theme_backup_20251211_072234.tar.gz | wc -l
```

Expected: ~500+ files including SCSS, PHP, templates, fonts, etc.

---

## 📞 Support Information

**Theme Version:** 1.0.0
**Moodle Compatibility:** 4.1+
**Theme Type:** Boost child theme
**Repository:** https://github.com/nguyenntdev/luuniensuki-theme
**Branch:** feature/imperial-theme

**Critical Files:**
- `version.php` - Theme version and requirements
- `config.php` - Theme configuration
- `scss/imperial.scss` - Main SCSS entry (Imperial preset)
- `scss/default.scss` - Main SCSS entry (Default preset)
- `lib.php` - Theme functions and callbacks

---

## ✅ Post-Restoration Checklist

After restoration, verify:

- [ ] Theme appears in theme selector
- [ ] Homepage loads correctly
- [ ] Course pages display properly
- [ ] Navigation menus work
- [ ] User menu functions
- [ ] Drawers open/close correctly
- [ ] Footer displays
- [ ] No console errors (F12 DevTools)
- [ ] Responsive design works on mobile
- [ ] Accessibility toolbar functions (if enabled)
- [ ] Colors and branding are correct
- [ ] Custom fonts load properly

---

## 🔐 Security Notes

- **Keep backups secure** - They contain theme source code
- **Rotate backups** - Keep multiple versions, delete old ones
- **Test restores** - Periodically test backup restoration on staging
- **Document changes** - Maintain change log for tracking modifications

---

**END OF RESTORATION GUIDE**

