#\!/bin/bash
# Navigate to Moodle root directory and clear caches

echo "🔍 Looking for Moodle installation..."

# Common Moodle installation paths
MOODLE_PATHS=(
    "/var/www/html/moodle"
    "/var/www/moodle"
    "/usr/share/nginx/html/moodle"
    "/opt/moodle"
    "/home/*/public_html/moodle"
)

MOODLE_ROOT=""

for path in "${MOODLE_PATHS[@]}"; do
    if [ -f "$path/admin/cli/purge_caches.php" ]; then
        MOODLE_ROOT="$path"
        break
    fi
done

if [ -z "$MOODLE_ROOT" ]; then
    echo "❌ Could not find Moodle installation"
    echo "Please run manually from Moodle root:"
    echo "  cd /path/to/moodle"
    echo "  php admin/cli/purge_caches.php"
    exit 1
fi

echo "✅ Found Moodle at: $MOODLE_ROOT"
echo "🧹 Clearing all caches..."

cd "$MOODLE_ROOT"
php admin/cli/purge_caches.php

if [ $? -eq 0 ]; then
    echo "✅ Caches cleared successfully\!"
    echo ""
    echo "Next steps:"
    echo "1. Hard refresh your browser (Ctrl+Shift+R)"
    echo "2. Check if dark mode is now working"
    echo "3. Toggle dark mode switch to test"
else
    echo "❌ Failed to clear caches"
    echo "Please check Moodle permissions and try manually"
fi
