<?php

namespace App\Helpers;

use Illuminate\Support\Facades\View;

/**
 * SEO Helper Class for AgroSpace
 * Manage meta tags, Open Graph, Twitter Cards, and Schema.org
 */
class SEO
{
    protected static $title;
    protected static $description;
    protected static $keywords;
    protected static $canonical;
    protected static $image;
    protected static $images = [];
    protected static $author;
    protected static $type = 'website';
    protected static $siteName = 'AgroSpace';
    protected static $locale = 'fr_CM';

    /**
     * Set page title
     */
    public static function setTitle(string $title): void
    {
        self::$title = $title;
        View::share('seoTitle', $title);
    }

    /**
     * Set meta description
     */
    public static function setDescription(string $description): void
    {
        self::$description = $description;
        View::share('seoDescription', $description);
    }

    /**
     * Set meta keywords
     */
    public static function setKeywords(string $keywords): void
    {
        self::$keywords = $keywords;
        View::share('seoKeywords', $keywords);
    }

    /**
     * Set canonical URL
     */
    public static function setCanonical(string $url): void
    {
        self::$canonical = $url;
        View::share('seoCanonical', $url);
    }

    /**
     * Set OG image
     */
    public static function setImage(string $image): void
    {
        self::$image = $image;
        View::share('seoImage', $image);
    }

    /**
     * Add multiple images
     */
    public static function addImages(array $images): void
    {
        self::$images = array_merge(self::$images, $images);
        View::share('seoImages', self::$images);
    }

    /**
     * Set author
     */
    public static function setAuthor(string $author): void
    {
        self::$author = $author;
        View::share('seoAuthor', $author);
    }

    /**
     * Set OG type
     */
    public static function setType(string $type): void
    {
        self::$type = $type;
        View::share('seoType', $type);
    }

    /**
     * Generate meta tags HTML
     */
    public static function render(): string
    {
        $html = '';

        // Title
        if (self::$title) {
            $html .= '<title>' . e(self::$title) . '</title>' . PHP_EOL;
            $html .= '<meta name="title" content="' . e(self::$title) . '">' . PHP_EOL;
        }

        // Description
        if (self::$description) {
            $html .= '<meta name="description" content="' . e(self::$description) . '">' . PHP_EOL;
        }

        // Keywords
        if (self::$keywords) {
            $html .= '<meta name="keywords" content="' . e(self::$keywords) . '">' . PHP_EOL;
        }

        // Canonical
        if (self::$canonical) {
            $html .= '<link rel="canonical" href="' . e(self::$canonical) . '">' . PHP_EOL;
        }

        // Open Graph
        $html .= '<meta property="og:type" content="' . e(self::$type) . '">' . PHP_EOL;
        $html .= '<meta property="og:site_name" content="' . e(self::$siteName) . '">' . PHP_EOL;
        $html .= '<meta property="og:locale" content="' . e(self::$locale) . '">' . PHP_EOL;

        if (self::$title) {
            $html .= '<meta property="og:title" content="' . e(self::$title) . '">' . PHP_EOL;
        }

        if (self::$description) {
            $html .= '<meta property="og:description" content="' . e(self::$description) . '">' . PHP_EOL;
        }

        if (self::$canonical) {
            $html .= '<meta property="og:url" content="' . e(self::$canonical) . '">' . PHP_EOL;
        }

        if (self::$image) {
            $html .= '<meta property="og:image" content="' . e(self::$image) . '">' . PHP_EOL;
            $html .= '<meta property="og:image:width" content="1200">' . PHP_EOL;
            $html .= '<meta property="og:image:height" content="630">' . PHP_EOL;
        }

        // Twitter Card
        $html .= '<meta name="twitter:card" content="summary_large_image">' . PHP_EOL;

        if (self::$title) {
            $html .= '<meta name="twitter:title" content="' . e(self::$title) . '">' . PHP_EOL;
        }

        if (self::$description) {
            $html .= '<meta name="twitter:description" content="' . e(self::$description) . '">' . PHP_EOL;
        }

        if (self::$image) {
            $html .= '<meta name="twitter:image" content="' . e(self::$image) . '">' . PHP_EOL;
        }

        return $html;
    }

    /**
     * Get title
     */
    public static function getTitle(): ?string
    {
        return self::$title;
    }

    /**
     * Get description
     */
    public static function getDescription(): ?string
    {
        return self::$description;
    }

    /**
     * Reset all values
     */
    public static function reset(): void
    {
        self::$title = null;
        self::$description = null;
        self::$keywords = null;
        self::$canonical = null;
        self::$image = null;
        self::$images = [];
        self::$author = null;
        self::$type = 'website';
    }
}