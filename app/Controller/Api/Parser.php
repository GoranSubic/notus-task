<?php

namespace App\Controller\Api;

/**
 * Class Parser
 *
 * This class is responsible for parsing data within the application.
 *
 * @category Controller
 * @package  App\Controller\Api
 * @author   Goran Subic <gsubic@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     goransubic.vercel.app
 */
class Parser
{
    /**
     * Parses product data into the required format.
     *
     * @param array $products      Raw product data from API
     * @param int   $totalProducts Total number of products (for pagination)
     * @param int   $limit         Number of products per page
     * @param int   $skip          Number of skipped products (to calculate current page)
     * 
     * @return array Formatted response
     */
    public static function parseProducts(array $products, int $totalProducts, int $limit, int $skip): array
    {
        // Calculate pagination values
        $page = ($limit > 0) ? floor($skip / $limit) + 1 : 1;
        $totalPages = ($limit > 0) ? ceil($totalProducts / $limit) : 1;

        // Transform products into required format
        $formattedProducts = array_map(
            function ($product) {
                return self::parseProduct($product, false);
            },
            $products
        );

        // Return formatted response
        return [
            'data' => $formattedProducts,
            'meta' => [
                'total_pages' => $totalPages,
                'page'        => $page,
                'per_page'    => $limit
            ]
        ];
    }

    /**
     * Parses product data into the required format.
     *
     * @param array $product Raw product data from API
     * @param bool  $single  Whether to parse a single product or a list
     *
     * @return array Formatted response
     */
    public static function parseProduct(array $product, $single = true): array
    {
        $parsed = [
            'id'                => $product['id'],
            'title'             => $product['title'] ?? 'No title',
            'description'       => $product['description'] ?? 'No description',
            'price'             => number_format($product['price'] ?? 0, 2, ',', '.') . ' €', // Format price
            'stock'             => self::parseStock($product['stock'] ?? 0),
            'thumbnail'         => $product['thumbnail'] ?? 'https://cdn.dummyjson.com/products/images/beauty/Red%20Nail%20Polish/thumbnail.png', // Default thumbnail
        ];

        if ($single) {
            $parsed['category'] = $product['category'] ?? 'No category';
            $parsed['tags'] = self::parseTags($product['tags'] ?? []);
        } else {
            $parsed['short_description'] = mb_substr($product['description'] ?? 'No description', 0, 30); // First 30 characters
        }

        return $parsed;
    }

    /**
     * Parses stock availability into human-readable format.
     *
     * @param array $tags Array of tags
     *
     * @return string Readable stock message
     */
    private static function parseTags(array $tags)
    {
        return implode(', ', $tags);
    }

    /**
     * Parses stock availability into human-readable format.
     *
     * @param int $stock Stock quantity
     * 
     * @return string Readable stock message
     */
    private static function parseStock(int $stock)
    {
        if ($stock == 0) {
            return 'No stock';
        } elseif ($stock < 5) {
            return 'Get it while you can';
        } else {
            return 'On Stock';
        }
    }
}
