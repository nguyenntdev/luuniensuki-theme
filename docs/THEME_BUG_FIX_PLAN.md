# Moodle Theme Bug Fix and Imperial Color Scheme Implementation Plan

**Date:** 2025-12-10  
**Status:** Planning Phase  
**Priority:** High

## Executive Summary

This document outlines the comprehensive plan to fix critical bugs in the Moodle theme and align the color scheme with the Lưu Niên Sử Kí (luuniensuki) website design system.

## Current Issues

### 1. Dark Theme Not Working
- **Problem:** Theme remains in light mode even when dark mode is enabled
- **Root Cause:** 
  - User preference `dark-mode-on` may not be properly stored/retrieved
  - CSS variables not switching between light/dark modes
  - Bootstrap `data-bs-theme` attribute not being set correctly

### 2. Logo Duplication
- **Problem:** Logo appears twice in the navbar
- **Root Cause:** Both light and dark logos are being displayed simultaneously
- **Location:** `templates/navbar.mustache` lines 67-70

### 3. Transparent Navbar
- **Problem:** Navbar background is transparent or not visible
- **Root Cause:** CSS variable `--moove-navbar-bg-color` not being applied correctly
- **Location:** `scss/moove/_navbar.scss` line 12

## Implementation Plan

### Phase 1: Investigation and Analysis ✓

**Tasks:**
1. ✓ Review dark mode implementation in `amd/src/darkmode.js`
2. ✓ Check user preference handling in `classes/output/core_renderer.php`
3. ✓ Analyze navbar template structure in `templates/navbar.mustache`
4. ✓ Review SCSS variable definitions in `scss/moove/darkandlightvariables.scss`
5. ✓ Compare color schemes between Moodle theme and luuniensuki website

**Findings:**
- Dark mode uses user preference `dark-mode-on` stored via `set_user_preference()`
- Logo switching relies on CSS display properties controlled by `data-bs-theme` attribute
- Color variables are defined but may not match luuniensuki design system
- Navbar background uses CSS custom property `--moove-navbar-bg-color`

### Phase 2: Fix Dark Mode Toggle (Priority: Critical)

**File:** `classes/output/core_renderer.php`

**Issue:** Line 127-131 - Dark mode preference logic may have issues

**Current Behavior:**
- Default value for preference is empty string `''`
- This causes issues with boolean evaluation
- Imperial theme should default to dark mode

**Proposed Fix:**
```php
// Change default from '' to false, and set imperial theme to default dark
$darkmode = get_user_preferences('dark-mode-on', true); // Default to true for imperial theme
if ($settings->enabledarkmode && $darkmode) {
    $additionalclasses[] = 'moove-darkmode';
    $colormode = 'dark';
}
```

**File:** `classes/api/darkmode.php`

**Issue:** Line 59-61 - Preference toggle uses string 'false' instead of boolean

**Proposed Fix:**
```php
$darkmode = get_user_preferences('dark-mode-on', true);
$newvalue = \!$darkmode;
set_user_preference('dark-mode-on', $newvalue);
```

### Phase 3: Fix Logo Duplication (Priority: High)

**File:** `scss/moove/_navbar.scss`

**Current Implementation:** Lines 1-3 and 91-98

**Issue:** CSS rules are correct, but `data-bs-theme` attribute may not be set on body

**Verification Steps:**
1. Check if `body_attributes()` in core_renderer.php sets `data-bs-theme` correctly
2. Verify JavaScript doesn't override the attribute
3. Ensure no conflicting CSS rules

**Expected Behavior:**
- Light mode: Show `.logo.light`, hide `.logo.dark`
- Dark mode: Show `.logo.dark`, hide `.logo.light`

### Phase 4: Fix Transparent Navbar (Priority: High)

**File:** `scss/moove/darkandlightvariables.scss`

**Issue:** CSS custom properties may not be defined at `:root` level

**Current Code (lines 2-13):**
```scss
:root,
[data-bs-theme="dark"] {
    --moove-navbar-bg-color: #{$deep-navy};
    // ... other variables
}
```

**Problem:** This sets the same value for both `:root` and `[data-bs-theme="dark"]`

**Proposed Fix:**
```scss
:root {
    // Default to dark mode (Imperial theme)
    --moove-navbar-bg-color: #{$deep-navy};
    --moove-secondary-navigation-bg-color: #{$navy-lighter};
    // ... other dark mode variables
}

@if $enable-dark-mode {
    @include color-mode(light) {
        // Light mode overrides
        --moove-navbar-bg-color: #{$ivory};
        --moove-secondary-navigation-bg-color: #{$imperial-gold};
        // ... other light mode variables
    }
}
```

### Phase 5: Align Color Scheme with Luuniensuki Website (Priority: Medium)

**Reference:** `luuniensuki/src/index.css` lines 12-87

**Target Color System:**
```scss
// From luuniensuki website - exact HSL values
$background: hsl(222, 47%, 6%);        // --background
$foreground: hsl(43, 20%, 96%);        // --foreground
$card: hsl(222, 40%, 8%);              // --card
$primary: hsl(43, 74%, 49%);           // --primary (Imperial Gold)
$secondary: hsl(222, 35%, 12%);        // --secondary (Navy Lighter)
$muted: hsl(222, 30%, 15%);            // --muted
$muted-foreground: hsl(43, 15%, 75%);  // --muted-foreground
$border: hsl(222, 30%, 18%);           // --border
```

**Action Items:**
1. Update `scss/moove/_imperial-variables.scss` to match exact HSL values
2. Ensure consistency between SCSS variables and CSS custom properties
3. Add missing semantic colors (success, info, warning, danger)
4. Implement gradient and shadow variables from luuniensuki

### Phase 6: Update Bootstrap Dark Mode Variables

**File:** Create or update Bootstrap variable overrides

**Required Variables:**
```scss
// Bootstrap 5 dark mode color overrides
$body-bg-dark: $deep-navy;
$body-color-dark: $foreground-primary;
$border-color-dark: $border-color;
$link-color-dark: $imperial-gold;
$link-hover-color-dark: $imperial-gold-light;

// Enable dark mode
$enable-dark-mode: true;
```

### Phase 7: Testing Checklist

**Dark Mode Toggle:**
- [ ] Toggle switch appears for logged-in users
- [ ] Clicking toggle switches between light and dark modes
- [ ] Preference persists across page reloads
- [ ] Preference persists across sessions
- [ ] Body element has correct `data-bs-theme` attribute

**Logo Display:**
- [ ] Only one logo displays in light mode
- [ ] Only one logo displays in dark mode
- [ ] Correct logo shows for each mode
- [ ] No flickering or duplication on mode switch

**Navbar Appearance:**
- [ ] Navbar has solid background color (not transparent)
- [ ] Background color matches design system
- [ ] Navbar is visible in both light and dark modes
- [ ] Text and icons are readable against background

**Color Consistency:**
- [ ] All colors match luuniensuki website
- [ ] Cards have correct background colors
- [ ] Borders are visible and correct color
- [ ] Links use imperial gold color
- [ ] Buttons match design system

### Phase 8: Implementation Steps

**Step 1: Fix Dark Mode Preference Logic**
1. Edit `classes/api/darkmode.php` - fix toggle logic
2. Edit `classes/output/core_renderer.php` - fix default value and body attributes
3. Test preference storage and retrieval

**Step 2: Fix Navbar Background**
1. Edit `scss/moove/darkandlightvariables.scss` - restructure CSS variables
2. Verify `--moove-navbar-bg-color` is defined correctly
3. Clear Moodle theme cache

**Step 3: Verify Logo Display**
1. Check body `data-bs-theme` attribute is set
2. Verify CSS rules in `_navbar.scss` are applied
3. Test logo switching in both modes

**Step 4: Update Color Scheme**
1. Edit `scss/moove/_imperial-variables.scss` - match luuniensuki colors
2. Edit `scss/moove/darkandlightvariables.scss` - update CSS custom properties
3. Verify all UI elements use correct colors

**Step 5: Clear Caches and Test**
1. Run: `php admin/cli/purge_caches.php`
2. Or use: Site Administration → Development → Purge all caches
3. Test all functionality in both light and dark modes

## Files to Modify

### Critical Priority:
1. `classes/api/darkmode.php` - Fix preference toggle
2. `classes/output/core_renderer.php` - Fix default dark mode
3. `scss/moove/darkandlightvariables.scss` - Fix CSS variables structure

### High Priority:
4. `scss/moove/_imperial-variables.scss` - Match luuniensuki colors
5. `scss/moove/_navbar.scss` - Verify navbar styles

### Medium Priority:
6. `amd/src/darkmode.js` - Verify JavaScript logic
7. `templates/navbar.mustache` - Verify template structure

## Success Criteria

1. ✅ Dark mode is enabled by default for new users
2. ✅ Toggle switch correctly switches between light and dark modes
3. ✅ Only one logo displays at a time
4. ✅ Navbar has solid, visible background in both modes
5. ✅ All colors match the luuniensuki website design system
6. ✅ User preferences persist across sessions
7. ✅ No visual glitches or flickering

## Rollback Plan

If issues occur:
1. Backup current files before making changes
2. Use git to revert changes: `git checkout -- <file>`
3. Clear caches after reverting
4. Document any issues encountered

## References

- Moodle Theme Documentation: https://moodledev.io/docs/4.4/apis/plugintypes/theme
- Bootstrap 5 Dark Mode: https://getbootstrap.com/docs/5.3/customize/color-modes/
- Luuniensuki Design System: `luuniensuki/src/index.css`
- Imperial Theme Variables: `scss/moove/_imperial-variables.scss`

## Next Steps

1. Review and approve this plan
2. Create backup of current theme files
3. Begin implementation starting with Phase 2
4. Test each phase before proceeding to next
5. Document any deviations from plan
