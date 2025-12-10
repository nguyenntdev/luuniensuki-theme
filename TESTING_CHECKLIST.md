# Theme Bug Fix Testing Checklist

## Pre-Testing Setup

- [ ] All code changes committed and pushed
- [ ] Moodle caches cleared (`php admin/cli/purge_caches.php`)
- [ ] Browser cache cleared or using incognito mode
- [ ] Logged in as administrator

## Test 1: Dark Mode Default State

**Expected:** Theme should be in dark mode by default for new users

- [ ] Log out completely
- [ ] Clear browser cookies for Moodle site
- [ ] Log in as a fresh user (or create new test user)
- [ ] **Verify:** Page loads in dark mode
- [ ] **Verify:** Body has `data-bs-theme="dark"` attribute
- [ ] **Verify:** Body has `moove-darkmode` class

**How to check:**
1. Right-click page → Inspect
2. Check `<body>` element attributes
3. Should see: `<body ... class="... moove-darkmode ..." data-bs-theme="dark">`

## Test 2: Navbar Background

**Expected:** Navbar should have solid dark background, not transparent

- [ ] **Verify:** Navbar background is solid deep navy `hsl(222, 47%, 6%)`
- [ ] **Verify:** Navbar is clearly visible against page content
- [ ] **Verify:** No transparency or see-through effect

**How to check:**
1. Inspect navbar element
2. Check computed styles
3. `background-color` should be `rgb(13, 17, 28)` or similar dark color

## Test 3: Logo Display (Dark Mode)

**Expected:** Only ONE logo should be visible in dark mode

- [ ] **Verify:** Only dark logo is visible
- [ ] **Verify:** Light logo is hidden (display: none)
- [ ] **Verify:** No logo duplication

**How to check:**
1. Inspect navbar logo area
2. Check for `<img class="logo light">` - should have `display: none`
3. Check for `<img class="logo dark">` - should be visible

## Test 4: Dark Mode Toggle

**Expected:** Clicking toggle should switch to light mode

- [ ] Click dark mode toggle switch
- [ ] **Verify:** Theme switches to light mode immediately
- [ ] **Verify:** Body `data-bs-theme` changes to "light"
- [ ] **Verify:** `moove-darkmode` class is removed from body
- [ ] **Verify:** Navbar background changes to light color `hsl(43, 30%, 92%)`

## Test 5: Logo Display (Light Mode)

**Expected:** Only ONE logo should be visible in light mode

- [ ] **Verify:** Only light logo is visible
- [ ] **Verify:** Dark logo is hidden (display: none)
- [ ] **Verify:** No logo duplication

## Test 6: Preference Persistence (Same Session)

**Expected:** Theme preference should persist on page reload

- [ ] With light mode active, reload the page (F5)
- [ ] **Verify:** Page loads in light mode
- [ ] Click toggle to switch to dark mode
- [ ] Reload page again
- [ ] **Verify:** Page loads in dark mode

## Test 7: Preference Persistence (New Session)

**Expected:** Theme preference should persist across sessions

- [ ] Set theme to light mode
- [ ] Log out completely
- [ ] Log back in with same user
- [ ] **Verify:** Theme is still in light mode
- [ ] Set theme to dark mode
- [ ] Log out and log back in
- [ ] **Verify:** Theme is still in dark mode

## Test 8: Color Scheme Verification

**Expected:** Colors should match luuniensuki design system

### Dark Mode Colors:
- [ ] Background: Deep navy `hsl(222, 47%, 6%)` / `rgb(13, 17, 28)`
- [ ] Text: Ivory `hsl(43, 20%, 96%)` / `rgb(248, 247, 243)`
- [ ] Links: Imperial gold `hsl(43, 74%, 49%)` / `rgb(196, 163, 90)`
- [ ] Cards: Navy card `hsl(222, 40%, 8%)` / `rgb(12, 16, 26)`
- [ ] Borders: `hsl(222, 30%, 18%)` / `rgb(32, 37, 52)`

### Light Mode Colors:
- [ ] Background: Ivory `hsl(43, 30%, 92%)` / `rgb(241, 238, 230)`
- [ ] Text: Deep navy `hsl(222, 47%, 6%)` / `rgb(13, 17, 28)`
- [ ] Links: Bronze `hsl(25, 60%, 40%)` / `rgb(163, 92, 41)`
- [ ] Navbar: Ivory `hsl(43, 30%, 92%)`

**How to check:**
1. Inspect elements with DevTools
2. Check computed `background-color`, `color` values
3. Compare with expected RGB values

## Test 9: Visual Consistency

- [ ] All text is readable (good contrast)
- [ ] No flickering when switching modes
- [ ] Smooth transitions between light/dark modes
- [ ] No broken layouts or overlapping elements
- [ ] Icons and images display correctly
- [ ] Buttons have proper styling

## Test 10: Cross-Browser Testing

Test in multiple browsers:
- [ ] Chrome/Chromium
- [ ] Firefox
- [ ] Safari (if available)
- [ ] Edge

## Test 11: Responsive Design

Test on different screen sizes:
- [ ] Desktop (1920x1080)
- [ ] Laptop (1366x768)
- [ ] Tablet (768x1024)
- [ ] Mobile (375x667)

## Bug Verification Summary

| Bug | Status | Notes |
|-----|--------|-------|
| Dark theme not working | ✅ Fixed | Default is now dark mode |
| Logo duplication | ✅ Fixed | Only one logo shows at a time |
| Transparent navbar | ✅ Fixed | Solid background in both modes |
| Color scheme alignment | ✅ Fixed | Matches luuniensuki design |

## Issues Found During Testing

Document any issues here:

1. 
2. 
3. 

## Sign-off

- [ ] All tests passed
- [ ] No critical issues found
- [ ] Ready for production deployment

**Tested by:** _______________  
**Date:** _______________  
**Moodle Version:** _______________  
**Browser(s):** _______________

