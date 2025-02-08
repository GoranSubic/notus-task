<?php

namespace App\Controller\Api;

/**
 * Class Parser
 *
 * This class is responsible for parsing data within the application.
 *
 * @package App\Controller\Api
 */
class Parser
{
    /**
     * Parses product data into the required format.
     *
     * @param array $product Raw product data from API
     * 
     * @return array Formatted response
     */
    public static function parseProduct(array $product): array
    {
        return [
            'id'                => $product['id'],
            'title'             => $product['title'] ?? 'No title',
            'description'       => $product['description'] ?? 'No description',
            'short_description' => mb_substr($product['description'] ?? 'No description', 0, 30), // First 30 characters
            'price'             => number_format($product['price'] ?? 0, 2, ',', '.') . ' €', // Format price
            'stock'             => self::parseStock($product['stock'] ?? 0),
            'thumbnail'         => $product['thumbnail'] ?? 'https://cdn.dummyjson.com/products/images/beauty/Red%20Nail%20Polish/thumbnail.png', // Default thumbnail
        ];
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
