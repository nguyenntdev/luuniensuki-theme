# Cache Clearing Instructions

## After Making Theme Changes

Moodle caches compiled CSS and other theme assets. After making changes to SCSS files or PHP classes, you **must** clear the cache for changes to take effect.

## Method 1: CLI (Recommended for Development)

From your Moodle root directory (not the theme directory):

```bash
php admin/cli/purge_caches.php
```

## Method 2: Admin UI

1. Log in as administrator
2. Navigate to: **Site Administration → Development → Purge all caches**
3. Click "Purge all caches" button

## Method 3: Rebuild Theme CSS Only

From your Moodle root directory:

```bash
php admin/cli/build_theme_css.php --themes=moove
```

## When to Clear Cache

Clear cache after:
- ✅ Modifying any SCSS files
- ✅ Changing PHP classes (renderers, settings, etc.)
- ✅ Updating mustache templates
- ✅ Modifying JavaScript files in `amd/src/`
- ✅ Changing theme settings via admin UI
- ✅ Switching between theme presets (Classic ↔ Imperial)

## Development Mode

For active development, enable theme designer mode to reduce caching:

1. **Site Administration → Appearance → Themes → Theme designer mode**
2. Check "Enable theme designer mode"
3. Save changes

⚠️ **Warning:** Disable this in production as it impacts performance!

## Verifying Changes

After clearing cache:
1. Hard refresh browser: `Ctrl+Shift+R` (Windows/Linux) or `Cmd+Shift+R` (Mac)
2. Check browser console for any CSS/JS errors
3. Verify changes are visible

## Troubleshooting

If changes still don't appear:
1. Clear browser cache completely
2. Try incognito/private browsing mode
3. Check file permissions on `moodledata/` directory
4. Verify SCSS compilation has no errors in Moodle logs

