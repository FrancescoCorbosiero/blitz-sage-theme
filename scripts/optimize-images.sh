#!/bin/bash

##
# Image Optimization Script for Blitz Theme
# Optimizes all images in resources/images directory
# Requires: optipng, jpegoptim, imagemagick
##

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}Blitz Theme - Image Optimizer${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

# Check dependencies
MISSING_DEPS=()

if ! command -v optipng &> /dev/null; then
    MISSING_DEPS+=("optipng")
fi

if ! command -v jpegoptim &> /dev/null; then
    MISSING_DEPS+=("jpegoptim")
fi

if ! command -v convert &> /dev/null; then
    MISSING_DEPS+=("imagemagick")
fi

if [ ${#MISSING_DEPS[@]} -gt 0 ]; then
    echo -e "${RED}Missing dependencies: ${MISSING_DEPS[*]}${NC}"
    echo ""
    echo "Install with:"
    echo "  macOS: brew install optipng jpegoptim imagemagick"
    echo "  Ubuntu/Debian: apt-get install optipng jpegoptim imagemagick"
    exit 1
fi

# Directories to optimize
IMAGES_DIR="resources/images"
PUBLIC_DIR="public"

if [ ! -d "$IMAGES_DIR" ]; then
    echo -e "${RED}Images directory not found: $IMAGES_DIR${NC}"
    exit 1
fi

# Statistics
PNG_COUNT=0
JPG_COUNT=0
WEBP_COUNT=0
ORIGINAL_SIZE=0
OPTIMIZED_SIZE=0

echo -e "${GREEN}Optimizing images in: $IMAGES_DIR${NC}"
echo ""

# Optimize PNG files
echo -e "${YELLOW}Optimizing PNG files...${NC}"
while IFS= read -r -d '' file; do
    echo "  Processing: $(basename "$file")"
    
    # Get original size
    ORIG_SIZE=$(stat -f%z "$file" 2>/dev/null || stat -c%s "$file")
    ORIGINAL_SIZE=$((ORIGINAL_SIZE + ORIG_SIZE))
    
    # Optimize
    optipng -o7 -quiet "$file"
    
    # Get new size
    NEW_SIZE=$(stat -f%z "$file" 2>/dev/null || stat -c%s "$file")
    OPTIMIZED_SIZE=$((OPTIMIZED_SIZE + NEW_SIZE))
    
    PNG_COUNT=$((PNG_COUNT + 1))
done < <(find "$IMAGES_DIR" -type f -iname "*.png" -print0)

# Optimize JPEG files
echo ""
echo -e "${YELLOW}Optimizing JPEG files...${NC}"
while IFS= read -r -d '' file; do
    echo "  Processing: $(basename "$file")"
    
    # Get original size
    ORIG_SIZE=$(stat -f%z "$file" 2>/dev/null || stat -c%s "$file")
    ORIGINAL_SIZE=$((ORIGINAL_SIZE + ORIG_SIZE))
    
    # Optimize
    jpegoptim --max=85 --strip-all --quiet "$file"
    
    # Get new size
    NEW_SIZE=$(stat -f%z "$file" 2>/dev/null || stat -c%s "$file")
    OPTIMIZED_SIZE=$((OPTIMIZED_SIZE + NEW_SIZE))
    
    JPG_COUNT=$((JPG_COUNT + 1))
done < <(find "$IMAGES_DIR" -type f \( -iname "*.jpg" -o -iname "*.jpeg" \) -print0)

# Generate WebP versions
echo ""
echo -e "${YELLOW}Generating WebP versions...${NC}"
while IFS= read -r -d '' file; do
    webp_file="${file%.*}.webp"
    
    if [ ! -f "$webp_file" ]; then
        echo "  Creating: $(basename "$webp_file")"
        convert "$file" -quality 85 "$webp_file"
        WEBP_COUNT=$((WEBP_COUNT + 1))
    fi
done < <(find "$IMAGES_DIR" -type f \( -iname "*.jpg" -o -iname "*.jpeg" -o -iname "*.png" \) -print0)

# Calculate savings
if [ $ORIGINAL_SIZE -gt 0 ]; then
    SAVED=$((ORIGINAL_SIZE - OPTIMIZED_SIZE))
    PERCENT=$((100 * SAVED / ORIGINAL_SIZE))
else
    SAVED=0
    PERCENT=0
fi

# Convert bytes to human readable
human_readable() {
    local bytes=$1
    if [ $bytes -lt 1024 ]; then
        echo "${bytes}B"
    elif [ $bytes -lt 1048576 ]; then
        echo "$((bytes / 1024))KB"
    else
        echo "$((bytes / 1048576))MB"
    fi
}

# Display results
echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}Optimization Complete!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo "Files processed:"
echo "  PNG files: $PNG_COUNT"
echo "  JPEG files: $JPG_COUNT"
echo "  WebP created: $WEBP_COUNT"
echo ""
echo "Size reduction:"
echo "  Original: $(human_readable $ORIGINAL_SIZE)"
echo "  Optimized: $(human_readable $OPTIMIZED_SIZE)"
echo "  Saved: $(human_readable $SAVED) (${PERCENT}%)"
echo ""