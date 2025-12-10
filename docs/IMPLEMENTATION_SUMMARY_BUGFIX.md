# Moodle Theme Bug Fix - Implementation Summary

## Overview

This document provides a quick reference for fixing the three critical bugs in the Moodle theme and aligning it with the Lưu Niên Sử Kí website design.

## Quick Diagnosis

### Issue 1: Dark Theme Not Working ❌
**Symptom:** Theme stays in light mode even when dark mode is enabled  
**Root Cause:** User preference defaults to empty string instead of boolean  
**Location:** `classes/output/core_renderer.php` line 127, `classes/api/darkmode.php` line 59

### Issue 2: Logo Duplication 👥
**Symptom:** Two logos appear in navbar  
**Root Cause:** `data-bs-theme` attribute not being set on body element  
**Location:** `classes/output/core_renderer.php` line 137, `templates/navbar.mustache` lines 67-70

### Issue 3: Transparent Navbar 👻
**Symptom:** Navbar background is invisible  
**Root Cause:** CSS custom property `--moove-navbar-bg-color` not defined correctly  
**Location:** `scss/moove/darkandlightvariables.scss` lines 2-27

## Quick Fixes

### Fix 1: Dark Mode Preference (5 minutes)

**File:** `classes/api/darkmode.php`
```php
// Line 59: Change from
$darkmode = get_user_preferences('dark-mode-on', 'false');

// To:
$darkmode = get_user_preferences('dark-mode-on', true);

// Line 61: Change from
set_user_preference('dark-mode-on', \!$darkmode);

// To:
$newvalue = \!$darkmode;
set_user_preference('dark-mode-on', $newvalue);
```

**File:** `classes/output/core_renderer.php`
```php
// Line 127: Change from
$darkmode = get_user_preferences('dark-mode-on', '');

// To:
$darkmode = get_user_preferences('dark-mode-on', true);
```

### Fix 2: Navbar Background (10 minutes)

**File:** `scss/moove/darkandlightvariables.scss`

Replace lines 1-27 with:
```scss
// Imperial Theme: Dark mode is default
:root {
    // Imperial Vietnamese Heritage - Dark Mode (Default)
    --moove-secondary-navigation-bg-color: hsl(222, 35%, 12%);
    --moove-navbar-bg-color: hsl(222, 47%, 6%);
    --moove-bg-white: hsl(222, 40%, 8%);
    --moove-link-color: hsl(43, 74%, 49%);
    --moove-gray-bg: hsl(222, 47%, 6%);
    --moove-text-color: hsl(43, 20%, 96%);
    --moove-border-color: hsl(222, 30%, 18%);
    --moove-card-bg: hsl(222, 40%, 8%);
}

@if $enable-dark-mode {
    @include color-mode(light) {
        // Light mode with warm ivory tones
        --moove-secondary-navigation-bg-color: hsl(43, 74%, 49%);
        --moove-navbar-bg-color: hsl(43, 30%, 92%);
        --moove-bg-white: hsl(43, 30%, 92%);
        --moove-link-color: hsl(25, 60%, 40%);
        --moove-gray-bg: hsl(43, 20%, 95%);
        --moove-text-color: hsl(222, 47%, 6%);
        --moove-border-color: hsl(43, 20%, 85%);
        --moove-card-bg: hsl(0, 0%, 100%);
    }
}
```

### Fix 3: Logo Display (Already Fixed)

The CSS is already correct in `scss/moove/_navbar.scss`. The issue will be resolved once Fix 1 is applied and the `data-bs-theme` attribute is properly set.

## Color Scheme Alignment

### Current vs Target Colors

| Element | Current | Target (Luuniensuki) | Status |
|---------|---------|---------------------|--------|
| Background | `hsl(222, 47%, 6%)` | `hsl(222, 47%, 6%)` | ✅ Match |
| Foreground | `hsl(43, 20%, 96%)` | `hsl(43, 20%, 96%)` | ✅ Match |
| Primary Gold | `#C4A35A` | `hsl(43, 74%, 49%)` | ✅ Match |
| Card BG | `hsl(222, 40%, 8%)` | `hsl(222, 40%, 8%)` | ✅ Match |
| Border | `hsl(222, 30%, 18%)` | `hsl(222, 30%, 18%)` | ✅ Match |
| Navbar BG | Variable | `hsl(222, 47%, 6%)` | ⚠️ Fix needed |

**Good News:** The color values are already aligned\! We just need to ensure they're applied correctly via CSS custom properties.

## Implementation Order

1. **First:** Fix dark mode preference logic (classes/api/darkmode.php, classes/output/core_renderer.php)
2. **Second:** Fix navbar CSS variables (scss/moove/darkandlightvariables.scss)
3. **Third:** Clear all caches (`php admin/cli/purge_caches.php`)
4. **Fourth:** Test in browser

## Testing Checklist

After implementing fixes:

- [ ] Log in to Moodle
- [ ] Check if dark mode is enabled by default
- [ ] Verify navbar has solid dark background
- [ ] Verify only ONE logo is visible
- [ ] Click dark mode toggle
- [ ] Verify theme switches to light mode
- [ ] Verify navbar changes to light background
- [ ] Verify logo switches (if different logos configured)
- [ ] Reload page - verify preference persists
- [ ] Log out and log back in - verify preference persists

## Cache Clearing Commands

```bash
# Method 1: CLI (recommended)
php admin/cli/purge_caches.php

# Method 2: Admin UI
# Navigate to: Site Administration → Development → Purge all caches

# Method 3: Specific theme cache
php admin/cli/build_theme_css.php --themes=moove
```

## Estimated Time

- **Investigation:** ✅ Complete (1 hour)
- **Fix Implementation:** 30 minutes
- **Testing:** 15 minutes
- **Total:** ~45 minutes

## Risk Assessment

| Risk | Likelihood | Impact | Mitigation |
|------|-----------|--------|------------|
| Breaks existing functionality | Low | Medium | Test thoroughly, have rollback plan |
| Cache issues | Medium | Low | Clear all caches after changes |
| User preferences reset | Low | Low | Only changing default, not existing prefs |
| CSS not compiling | Low | Medium | Verify SCSS syntax before committing |

## Rollback Procedure

If something goes wrong:

```bash
# 1. Revert changes
git checkout HEAD -- classes/api/darkmode.php
git checkout HEAD -- classes/output/core_renderer.php
git checkout HEAD -- scss/moove/darkandlightvariables.scss

# 2. Clear caches
php admin/cli/purge_caches.php

# 3. Verify site is working
```

## Support Resources

- **Moodle Docs:** https://docs.moodle.org/dev/Themes
- **Bootstrap Dark Mode:** https://getbootstrap.com/docs/5.3/customize/color-modes/
- **Theme Config:** `config.php`
- **Full Plan:** `docs/THEME_BUG_FIX_PLAN.md`

## Notes

- The imperial theme is designed to default to dark mode (matching the luuniensuki website)
- Light mode is available as an option for users who prefer it
- All color values are already aligned with the design system
- The main issues are in preference handling and CSS variable application

---

**Status:** Ready for implementation  
**Last Updated:** 2025-12-10  
**Next Action:** Begin implementation with Fix 1 (Dark Mode Preference)
