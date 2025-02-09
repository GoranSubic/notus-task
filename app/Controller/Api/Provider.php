<?php

namespace App\Controller\Api;

use App\Controller\Api\Parser;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class Provider
 *
 * This class handles the API requests related to providers.
 *
 * @category Controller
 * @package  App\Controller\Api
 * @author   Goran Subic <gsubic@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     goransubic.vercel.app
 */
class Provider
{
    private $apiUrl = "https://dummyjson.com/products/";
    private $client;

    public function __construct()
    {
        $this->client = new Client(
            [
            'base_uri' => $this->apiUrl,
            'timeout'  => 5.0, // Set timeout for requests
            ]
        );
    }

    /**
     * Fetch and parse products with pagination and sorting.
     *
     * @param int|null    $limit  Number of products per page
     * @param int|null    $skip   Number  of products to skip (pagination)
     * @param string|null $sortBy Field to sort by (e.g., 'price', 'title')
     * @param string|null $order  Sorting order ('asc' or 'desc')
     *
     * @return array Formatted response
     */
    public function getProducts(?int $limit, ?int $skip, ?string $sortBy, ?string $order)
    {
        $limit = $limit ?? 10;
        $skip = $skip ?? 0;
        $sortBy = $sortBy ?? 'id';
        $order = $order ?? 'asc';

        // Build query parameters
        $queryParams = [
            'limit' => $limit,
            'skip'  => $skip,
        ];

        try {
            // Send API request
            $response = $this->client->request('GET', '', ['query' => $queryParams]);

            // Decode JSON response
            $data = json_decode($response->getBody(), true);

            // Check if API returned products
            if (!isset($data['products']) || !isset($data['total'])) {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Invalid API response']);
                return;
            }

            // Sort results locally if sorting is needed
            if ($sortBy && isset($data['products'][0][$sortBy])) {
                usort(
                    $data['products'],
                    function ($a, $b) use ($sortBy, $order) {
                        return $order === 'asc' ? $a[$sortBy] <=> $b[$sortBy] : $b[$sortBy] <=> $a[$sortBy];
                    }
                );
            }

            // Parse and return formatted response
            $result = Parser::parseProducts($data['products'], $data['total'], $limit, $skip);
            header('Content-Type: application/json');
            echo json_encode($result);
            return;

        } catch (RequestException $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'API Request Failed: ' . $e->getMessage()]);
            return;
        }
    }

    /**
     * Retrieves the product details based on the provided product ID.
     *
     * @param int $id The ID of the product to retrieve.
     * 
     * @return mixed The product details or null if not found.
     */
    public function getProduct($id)
    {
        // Check if the provided ID is numeric
        if (!is_numeric($id)) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid product ID']);
            return;
        }

        try {
            // Send API request
            $response = $this->client->request('GET', $this->apiUrl . $id);

            // Decode JSON response
            $data = json_decode($response->getBody(), true);

            // Check if API returned product id
            if (!isset($data['id'])) {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Invalid API response']);
                return;
            }

            // Parse and return formatted response
            $result = Parser::parseProduct($data);
            header('Content-Type: application/json');
            echo json_encode($result);
            return;

        } catch (RequestException $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'API Request Failed: ' . $e->getMessage()]);
            return;
        }

    }

    /**
     * Search for products based on a query.
     *
     * @param string $query The search query.
     *
     * @return void
     */
    public function searchProducts()
    {
        // Securely get the query parameter
        // $query = $_GET['q'] ?? '';
        $query = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS);
        $limit = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT, ['options' => ['default' => 10, 'min_range' => 1]]);
        $skip = filter_input(INPUT_GET, 'skip', FILTER_VALIDATE_INT, ['options' => ['default' => 0, 'min_range' => 0]]);

        if ($query === null) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Query parameter is missing']);
            return;
        }

        if (!is_numeric($limit) || $limit < 0) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid limit parameter']);
            return;
        }

        if (!is_numeric($skip) || $skip < 0) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid skip parameter']);
            return;
        }

        // Build query parameters
        $queryParams = [
            'q' => $query,
            'limit' => $limit,
            'skip'  => $skip,
        ];

        try {
            // Send API request
            $response = $this->client->request('GET', 'search', ['query' => $queryParams]);

            // Decode JSON response
            $data = json_decode($response->getBody(), true);

            // Check if API returned products
            if (!isset($data['products'])) {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Invalid API response']);
                return;
            }

            // Parse and return formatted response
            $result = Parser::parseProducts($data['products'], $data['total'], $limit, $skip);
            header('Content-Type: application/json');
            echo json_encode($result);
            return;

        } catch (RequestException $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'API Request Failed: ' . $e->getMessage()]);
            return;
        }
    }
}
