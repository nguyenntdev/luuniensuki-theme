# Quick Fix Reference Card

## 🚨 Three Critical Bugs

1. **Dark theme not working** - Theme stays light
2. **Logo duplicated** - Two logos show at once  
3. **Navbar transparent** - Background invisible

## ⚡ Quick Fixes (15 minutes)

### Fix 1: Dark Mode Toggle
**File:** `classes/api/darkmode.php` (Line 59)
```php
// Change this:
$darkmode = get_user_preferences('dark-mode-on', 'false');

// To this:
$darkmode = get_user_preferences('dark-mode-on', true);
```

**File:** `classes/output/core_renderer.php` (Line 127)
```php
// Change this:
$darkmode = get_user_preferences('dark-mode-on', '');

// To this:
$darkmode = get_user_preferences('dark-mode-on', true);
```

### Fix 2: Navbar Background
**File:** `scss/moove/darkandlightvariables.scss` (Lines 1-13)
```scss
// Replace entire section with:
:root {
    --moove-navbar-bg-color: hsl(222, 47%, 6%);
    --moove-secondary-navigation-bg-color: hsl(222, 35%, 12%);
    --moove-bg-white: hsl(222, 40%, 8%);
    --moove-link-color: hsl(43, 74%, 49%);
    --moove-gray-bg: hsl(222, 47%, 6%);
    --moove-text-color: hsl(43, 20%, 96%);
    --moove-border-color: hsl(222, 30%, 18%);
    --moove-card-bg: hsl(222, 40%, 8%);
}
```

### Fix 3: Clear Cache
```bash
php admin/cli/purge_caches.php
```

## ✅ Verification

After fixes:
- [ ] Navbar has solid dark background
- [ ] Only ONE logo visible
- [ ] Toggle switch works
- [ ] Preference persists after reload

## 📋 Full Documentation

- **Detailed Plan:** `docs/THEME_BUG_FIX_PLAN.md`
- **Summary:** `docs/IMPLEMENTATION_SUMMARY_BUGFIX.md`
- **Diagrams:** `docs/BUGFIX_DIAGRAM.md`

## 🎨 Color Reference (Luuniensuki)

```
Background:  hsl(222, 47%, 6%)   - Deep Navy
Foreground:  hsl(43, 20%, 96%)   - Ivory
Primary:     hsl(43, 74%, 49%)   - Imperial Gold
Card:        hsl(222, 40%, 8%)   - Navy Card
Border:      hsl(222, 30%, 18%)  - Border
```

## 🔄 Rollback

```bash
git checkout HEAD -- classes/api/darkmode.php
git checkout HEAD -- classes/output/core_renderer.php
git checkout HEAD -- scss/moove/darkandlightvariables.scss
php admin/cli/purge_caches.php
```
