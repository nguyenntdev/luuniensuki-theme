# Imperial Vietnamese Heritage Theme Implementation Guide

## Overview

This document provides a comprehensive guide to the Imperial Vietnamese Heritage theme implementation for the Moove Moodle theme, inspired by the Lưu Niên Sử Kí design system.

## Implementation Summary

**Total Implementation**: 9 Phases, 59 Tasks  
**Status**: ✅ Complete  
**Branch**: `feature/imperial-theme`  
**Theme Preset**: `imperial` (optional alongside `classic`)

---

## Architecture

### Theme Preset System

The imperial theme is implemented as an **optional preset** alongside the classic Moove theme:

- **Classic Preset**: Original Moove theme (blue/light)
- **Imperial Preset**: Vietnamese heritage theme (gold/dark)

**Activation**: Site Administration → Appearance → Themes → Moove → Theme Style Preset → Select "Imperial Vietnamese Heritage"

### File Structure

```
theme/moove/
├── scss/
│   ├── imperial.scss                    # Main entry point
│   └── moove/
│       ├── _imperial-variables.scss     # Color system
│       ├── _gradients.scss              # Gold gradients
│       ├── _typography.scss             # Serif fonts
│       ├── _animations.scss             # Keyframe animations
│       ├── _patterns.scss               # Vietnamese patterns
│       ├── _utilities.scss              # Utility classes
│       ├── _cards.scss                  # Card components
│       ├── _buttons-imperial.scss       # Button styles
│       ├── _accessibility-enhanced.scss # A11y features
│       ├── _loading.scss                # Loading states
│       ├── _frontpage-imperial.scss     # Hero/landing
│       ├── _navbar-imperial.scss        # Navigation
│       └── _drawers-imperial.scss       # Sidebar/drawers
├── fonts/
│   └── imperial/
│       ├── fonts.css                    # Font-face declarations
│       ├── playfair-latin.woff2         # Serif font
│       ├── playfair-vietnamese.woff2    # Vietnamese subset
│       ├── inter-latin.woff2            # Sans-serif font
│       └── inter-vietnamese.woff2       # Vietnamese subset
└── docs/
    ├── COLOR_ACCESSIBILITY_TEST.md      # WCAG compliance
    └── IMPERIAL_THEME_IMPLEMENTATION.md # This file
```

---

## Design System

### Color Palette

**Primary Colors:**
- Imperial Gold: `#C4A35A` / `hsl(43, 74%, 49%)` - Primary brand color
- Deep Navy: `hsl(222, 47%, 6%)` - Background
- Imperial Red: `hsl(0, 72%, 51%)` - Accent
- Jade Green: `hsl(160, 45%, 35%)` - Success
- Bronze: `hsl(25, 60%, 40%)` - Light mode accent
- Ivory: `hsl(43, 30%, 92%)` - Light mode background

**Accessibility:**
- All color combinations meet WCAG AA standards (4.5:1 minimum)
- Imperial Gold on Deep Navy: ~8.5:1 (exceeds AAA)
- Documented in `docs/COLOR_ACCESSIBILITY_TEST.md`

### Typography

**Fonts:**
- **Headings**: Playfair Display (serif) - Elegant, historical
- **Body**: Inter / Be Vietnam Pro (sans-serif) - Modern, readable
- **Line Height**: 1.8 for Vietnamese text (diacritics support)
- **Self-hosted**: woff2 format with Vietnamese unicode-range

**Font Loading:**
- Preload links in `classes/output/core_renderer.php`
- `font-display: swap` for performance
- Vietnamese-optimized subsets

### Visual Effects

**Animations:**
- fadeInUp, glow-pulse, float, aurora, gradient-shift
- scale-in, slide-in-right, slide-in-left
- shimmer (loading), ripple (buttons)
- GPU-accelerated (transform, opacity)
- `prefers-reduced-motion` support

**Patterns:**
- pattern-van-may (Vietnamese cloud motif)
- pattern-thuy-ba (Vietnamese wave motif)
- Dot, grid, diagonal, hexagon patterns
- SVG data URIs for performance

---

## Key Features

### 1. Glass Morphism
- Navbar: `backdrop-filter: blur(10px)`
- Dropdowns: rgba backgrounds with blur
- Cards: glass variant with transparency

### 2. Gradient System
- Gold gradients for headings and CTAs
- Multi-layer backgrounds with radial glows
- Animated gradient shifts

### 3. Hover Effects
- Card lift: `translateY(-4px)` with gold shadow
- Button ripple: Click animation
- Icon glow: `drop-shadow` filter
- Nav underline: Animated gold bar

### 4. Accessibility
- Gold focus rings (2px solid)
- Skip-to-content link
- Touch targets: min 44x44px
- High contrast mode support
- Screen reader utilities

### 5. Dark Mode First
- Dark mode as default experience
- Light mode: Ivory backgrounds, bronze accents
- Smooth transitions (0.3s ease)
- Logo color switching

---

## Performance Optimizations

1. **Font Loading**: Preload, woff2 format, unicode-range subsets
2. **Animations**: GPU-accelerated, transform/opacity only
3. **Patterns**: SVG data URIs (no HTTP requests)
4. **CSS**: Modular SCSS, conditional loading
5. **Images**: Lazy loading, responsive images

---

## Browser Compatibility

**Tested Browsers:**
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

**Features with Fallbacks:**
- `backdrop-filter`: Fallback to solid backgrounds
- CSS Grid: Flexbox fallback
- Custom properties: SCSS variables fallback

---

## Migration Guide

### For Administrators

**Step 1: Backup**
```bash
git checkout -b backup-before-imperial
git commit -am "Backup before imperial theme"
```

**Step 2: Merge Feature Branch**
```bash
git merge feature/imperial-theme
```

**Step 3: Clear Caches**
- Site Administration → Development → Purge all caches
- Or: `php admin/cli/purge_caches.php`

**Step 4: Activate Theme**
- Site Administration → Appearance → Themes → Moove
- Theme Style Preset → Select "Imperial Vietnamese Heritage (Lưu Niên Sử Kí)"
- Save changes

**Step 5: Verify**
- Check frontpage appearance
- Test navigation and dropdowns
- Verify dark/light mode switching
- Test on mobile devices

### Rollback Procedure

If issues occur:
```bash
# Revert to classic preset
Site Administration → Themes → Moove → Theme Preset → Classic

# Or revert code
git checkout backup-before-imperial
php admin/cli/purge_caches.php
```

---

## Customization

### Changing Colors

Edit `scss/moove/_imperial-variables.scss`:
```scss
$imperial-gold: #YOUR_COLOR;
$deep-navy: hsl(222, 47%, 6%);
```

### Adding Custom Patterns

Edit `scss/moove/_patterns.scss`:
```scss
.pattern-custom {
    background-image: url("data:image/svg+xml,...");
}
```

### Modifying Animations

Edit `scss/moove/_animations.scss`:
```scss
@keyframes custom-animation {
    from { opacity: 0; }
    to { opacity: 1; }
}
```

---

## Support & Resources

**Documentation:**
- Moodle Theme Development: https://docs.moodle.org/dev/Themes
- WCAG Guidelines: https://www.w3.org/WAI/WCAG21/quickref/
- Vietnamese Typography: Unicode U+1EA0-1EF9

**Testing Tools:**
- WAVE Accessibility: https://wave.webaim.org/
- Contrast Checker: https://webaim.org/resources/contrastchecker/
- Lighthouse: Chrome DevTools

---

**Implementation Date**: December 9, 2025  
**Version**: 1.0.0  
**Theme**: Moove with Imperial Vietnamese Heritage Preset  
**Design System**: Lưu Niên Sử Kí (Imperial Chronicles)

