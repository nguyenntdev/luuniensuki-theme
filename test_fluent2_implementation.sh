#!/bin/bash
# ================================================================
# Fluent 2 Implementation - Compilation & Test Script
# ================================================================

set -e # Exit on error

echo "================================================"
echo "Luuniensuki Theme - Fluent 2 Implementation"
echo "Compilation & Testing"
echo "================================================"
echo ""

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Check if we're in the theme directory
if [ ! -f "version.php" ]; then
    echo -e "${RED}Error: Must be run from theme root directory${NC}"
    exit 1
fi

echo -e "${YELLOW}Step 1: Checking file structure...${NC}"
# Check token files exist
REQUIRED_FILES=(
    "scss/tokens/_fluent-global.scss"
    "scss/tokens/_fluent-alias.scss"
    "scss/tokens/_fluent-component.scss"
    "scss/tokens/_fluent-light-overrides.scss"
    "scss/luuniensuki/_fluent-integration.scss"
)

for file in "${REQUIRED_FILES[@]}"; do
    if [ -f "$file" ]; then
        echo -e "${GREEN}✓${NC} Found: $file"
    else
        echo -e "${RED}✗${NC} Missing: $file"
        exit 1
    fi
done

echo ""
echo -e "${YELLOW}Step 2: Validating SCSS syntax...${NC}"

# Basic syntax check (look for obvious errors)
for scss_file in scss/imperial.scss scss/default.scss; do
    if grep -q "@import" "$scss_file"; then
        echo -e "${GREEN}✓${NC} $scss_file has imports"
    else
        echo -e "${RED}✗${NC} $scss_file missing imports"
        exit 1
    fi
done

echo ""
echo -e "${YELLOW}Step 3: Compilation ready${NC}"
echo "To compile SCSS in production:"
echo "  1. SSH to Moodle server"
echo "  2. Navigate to Moodle root"
echo "  3. Run: php admin/cli/build_theme_css.php --themes=luuniensuki"
echo ""
echo "  Or use the theme's regenerate script:"
echo "  php theme/luuniensuki/regenerate_css.php"
echo ""

echo -e "${YELLOW}Step 4: File count summary...${NC}"
echo "Token files: $(find scss/tokens -name '*.scss' | wc -l)"
echo "Component files: $(find scss/luuniensuki -name '*.scss' | wc -l)"
echo "Total SCSS files: $(find scss -name '*.scss' | wc -l)"
echo ""

echo -e "${GREEN}================================================${NC}"
echo -e "${GREEN}✓ All checks passed!${NC}"
echo -e "${GREEN}================================================${NC}"
echo ""
echo "Next steps:"
echo "1. Commit changes to git"
echo "2. Deploy to server at 47.236.61.220"
echo "3. Compile CSS on server"
echo "4. Clear Moodle caches"
echo ""

