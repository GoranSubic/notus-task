<?php

namespace App\Controller\Api;

use App\Controller\Api\Parser;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

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
     * Retrieves the product details based on the provided product ID.
     *
     * @param int $id The ID of the product to retrieve.
     * 
     * @return mixed The product details or null if not found.
     */
    public function getProduct($id)
    {
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
}
