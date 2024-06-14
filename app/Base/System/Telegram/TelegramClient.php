<?php

namespace App\Base\System\Telegram; // Declares the namespace for the Teleporter\System\Telegram package.

use GuzzleHttp\Client; // Importing the GuzzleHttp\Client class for making HTTP requests.
use App\Base\System\Traits\Telegram\TelegramCapabilityTrait; // Importing a trait for adding Telegram capabilities to the class.

class TelegramClient // Definition of the TelegramClient class.
{
    use TelegramCapabilityTrait; // Utilizes the TelegramCapabilityTrait to add Telegram-related functionality to this class.

    protected $sendFileEndPoint = "https://api.telegram.org/bot"; // Holds the base URL for sending files to Telegram.
    protected $parameters; // Stores parameters for requests.

    /**
     * Constructor method for the TelegramClient class.
     *
     * @param string $token The authentication token required for accessing Telegram's API.
     * @param string $chatID The identifier for the chat where messages will be sent.
     */
    public function __construct(protected $token, protected $chatID)
    {
        // Initializes a new instance of the TelegramClient class with the provided token and chat ID.
        // Sets up the necessary parameters for interacting with the Telegram API.
    }

    /**
     * Sends an HTTP request to the specified URL with the given method and parameters.
     *
     * @param string $url The URL to send the request to.
     * @param string $method The HTTP method to use for the request (e.g., GET, POST).
     * @param array $parameters The parameters to include in the request.
     * @return mixed The response content from the request.
     */
    private function request(string $url, string $method, array $parameters): mixed
    {
        // Checks if parameters are provided, if not initializes an empty array.
        if (!$parameters) {
            $parameters = array();
        }

        // Adds the method parameter to the parameters array.
        $parameters["method"] = $method;

        // Initializes a new Guzzle HTTP client.
        $client = new Client();

        try {
            // Sends a POST request to the specified URL with JSON-encoded parameters.
            $response = $client->post($url, [
                'json' => $parameters,
                'connect_timeout' => 5,
                'timeout' => 60,
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]);

            // Decodes the JSON response body into an associative array.
            $result = json_decode($response->getBody()->getContents(), true);

            return $result; // Returns the response content.
        } catch (\Throwable $th) {
            // Catches any exceptions that occur during the request and returns the error message.
            return $th->getMessage();
        }
    }

    /**
     * Generates the final URL by appending the token to the provided endpoint.
     *
     * @param string $endPoint The base endpoint URL.
     * @return string The final URL with the token appended.
     */
    public function getFinalUrl($endPoint): string
    {
        // Concatenates the token with the provided endpoint to form the final URL.
        return $endPoint . $this->token . "/";
    }

    /**
     * Get the value of parameters
     */
    public function getParameters()
    {
        // Returns the value of the parameters property.
        return $this->parameters;
    }

    /**
     * Set the value of parameters
     *
     * @param array $parameters The parameters to set.
     * @return  self
     */
    public function setParameters($parameters)
    {
        // Sets the value of the parameters property to the provided parameters array.
        $this->parameters = $parameters;

        // Returns the instance of the class for method chaining.
        return $this;
    }
}
