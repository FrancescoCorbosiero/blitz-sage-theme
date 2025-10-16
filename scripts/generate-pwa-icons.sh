#!/bin/bash

##
# PWA Icon Generator for Blitz Theme
# Generates all required icon sizes from a source image
# Requires: ImageMagick
##

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if ImageMagick is installed
if ! command -v convert &> /dev/null; then
    echo -e "${RED}Error: ImageMagick is not installed${NC}"
    echo "Install it with: brew install imagemagick (macOS) or apt-get install imagemagick (Linux)"
    exit 1
fi

# Get source image
SOURCE_IMAGE="${1:-logo.png}"

if [ ! -f "$SOURCE_IMAGE" ]; then
    echo -e "${RED}Error: Source image not found: $SOURCE_IMAGE${NC}"
    echo "Usage: ./scripts/generate-pwa-icons.sh path/to/logo.png"
    exit 1
fi

# Create icons directory
ICONS_DIR="public/icons"
mkdir -p "$ICONS_DIR"

echo -e "${GREEN}Generating PWA icons from: $SOURCE_IMAGE${NC}"

# Icon sizes for PWA
SIZES=(72 96 128 144 152 192 384 512)

# Generate icons
for size in "${SIZES[@]}"; do
    output_file="${ICONS_DIR}/icon-${size}x${size}.png"
    
    echo -e "${YELLOW}Generating ${size}x${size}...${NC}"
    
    convert "$SOURCE_IMAGE" \
        -resize "${size}x${size}" \
        -background none \
        -gravity center \
        -extent "${size}x${size}" \
        "$output_file"
    
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✓ Created: $output_file${NC}"
    else
        echo -e "${RED}✗ Failed: $output_file${NC}"
    fi
done

# Generate favicon
echo -e "${YELLOW}Generating favicon.ico...${NC}"
convert "$SOURCE_IMAGE" \
    -resize 32x32 \
    -background none \
    -gravity center \
    -extent 32x32 \
    "public/favicon.ico"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Created: public/favicon.ico${NC}"
fi

# Generate Apple Touch Icon
echo -e "${YELLOW}Generating apple-touch-icon.png...${NC}"
convert "$SOURCE_IMAGE" \
    -resize 180x180 \
    -background none \
    -gravity center \
    -extent 180x180 \
    "public/apple-touch-icon.png"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Created: public/apple-touch-icon.png${NC}"
fi

# Generate Screenshots (optional - you should replace these with actual screenshots)
SCREENSHOTS_DIR="public/screenshots"
mkdir -p "$SCREENSHOTS_DIR"

echo -e "${YELLOW}Generating placeholder screenshots...${NC}"
echo -e "${YELLOW}Note: Replace these with actual theme screenshots${NC}"

# Desktop screenshot placeholder (1920x1080)
convert -size 1920x1080 \
    -background "#667eea" \
    -fill white \
    -gravity center \
    -pointsize 72 \
    -font Arial \
    label:"Desktop Screenshot\n1920x1080\nReplace with actual screenshot" \
    "${SCREENSHOTS_DIR}/desktop.png"

# Mobile screenshot placeholder (390x844)
convert -size 390x844 \
    -background "#764ba2" \
    -fill white \
    -gravity center \
    -pointsize 36 \
    -font Arial \
    label:"Mobile Screenshot\n390x844\nReplace with actual screenshot" \
    "${SCREENSHOTS_DIR}/mobile.png"

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}PWA Icons Generated Successfully!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo "Generated files:"
echo "  - ${ICONS_DIR}/icon-*.png (8 sizes)"
echo "  - public/favicon.ico"
echo "  - public/apple-touch-icon.png"
echo "  - ${SCREENSHOTS_DIR}/desktop.png"
echo "  - ${SCREENSHOTS_DIR}/mobile.png"
echo ""
echo -e "${YELLOW}Next steps:${NC}"
echo "  1. Replace placeholder screenshots with actual theme screenshots"
echo "  2. Verify manifest.json paths are correct"
echo "  3. Test PWA installation on mobile devices"
echo ""