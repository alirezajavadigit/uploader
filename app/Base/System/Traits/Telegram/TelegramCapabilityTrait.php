<?php

namespace App\Base\System\Traits\Telegram; // Defines the namespace for the Teleporter\System\Traits\Telegram package.

use GuzzleHttp\Client;

trait TelegramCapabilityTrait // Defines the TelegramCapabilityTrait trait.
{
    /**
     * Sends a photo to the specified chat using the Telegram API.
     *
     * @param string $photoUrl The URL of the photo to be sent.
     * @return mixed The result of the request to send the photo.
     */
    public function sendPhoto(string $photoUrl): mixed
    {
        // Sets the parameters for sending a photo, including the chat ID and photo URL.
        $this->setParameters(["chat_id" => $this->chatID, "photo" => $photoUrl]);

        // Sends a request to the Telegram API to send the photo, using the sendPhoto method.
        // The method call is made via the request method, which handles the HTTP request.
        // The result of the request is stored in the $result variable.
        $result = $this->request($this->getFinalUrl($this->sendFileEndPoint), "sendPhoto", $this->getParameters());

        // Returns the result of the request, which may contain information about the success or failure of the operation.
        return $result;
    }

    /**
     * Sends a document to the specified chat using the Telegram API.
     *
     * @param string $docUrl The URL of the document to be sent.
     * @return mixed The result of the request to send the document.
     */
    public function sendDocument(string $docUrl): mixed
    {
        // Sets the parameters for sending a document, including the chat ID and document URL.
        $this->setParameters(["chat_id" => $this->chatID, "document" => $docUrl]);

        // Sends a request to the Telegram API to send the document, using the sendDocument method.
        // The method call is made via the request method, which handles the HTTP request.
        // The result of the request is stored in the $result variable.
        $result = $this->request($this->getFinalUrl($this->sendFileEndPoint), "sendDocument", $this->getParameters());

        // Returns the result of the request, which may contain information about the success or failure of the operation.
        return $result;
    }

    /**
     * Sends an audio file to the specified chat using the Telegram API.
     *
     * @param string $audioUrl The URL of the audio file to be sent.
     * @return mixed The result of the request to send the audio file.
     */
    public function sendAudio(string $audioUrl): mixed
    {
        // Sets the parameters for sending an audio file, including the chat ID and audio URL.
        $this->setParameters(["chat_id" => $this->chatID, "audio" => $audioUrl]);

        // Sends a request to the Telegram API to send the audio file, using the sendAudio method.
        // The method call is made via the request method, which handles the HTTP request.
        // The result of the request is stored in the $result variable.
        $result = $this->request($this->getFinalUrl($this->sendFileEndPoint), "sendAudio", $this->getParameters());

        // Returns the result of the request, which may contain information about the success or failure of the operation.
        return $result;
    }

    /**
     * Sends a video to the specified chat using the Telegram API.
     *
     * @param string $videoUrl The URL of the video to be sent.
     * @return mixed The result of the request to send the video.
     */
    public function sendVideo(string $videoUrl): mixed
    {
        // Sets the parameters for sending a video, including the chat ID and video URL.
        $this->setParameters(["chat_id" => $this->chatID, "video" => $videoUrl]);

        // Sends a request to the Telegram API to send the video, using the sendVideo method.
        // The method call is made via the request method, which handles the HTTP request.
        // The result of the request is stored in the $result variable.
        $result = $this->request($this->getFinalUrl($this->sendFileEndPoint), "sendVideo", $this->getParameters());

        // Returns the result of the request, which may contain information about the success or failure of the operation.
        return $result;
    }

    /**
     * Retrieves information about a file from Telegram using its ID.
     *
     * @param string $fileID The ID of the file to retrieve information for.
     * @return array|null Information about the file, or null if the file does not exist or an error occurs.
     */
    public function getFile($fileID)
    {
        // Initializes a new Guzzle HTTP client.
        $client = new Client();

        // Sends a GET request to the Telegram API to retrieve information about the file with the specified ID.
        // The query parameter 'file_id' is included in the request URL to specify the ID of the file.
        $response = $client->get($this->getFinalUrl($this->sendFileEndPoint) . 'getFile', [
            'query' => ['file_id' => $fileID],
        ]);

        // Decodes the JSON response body into an associative array.
        $result = json_decode($response->getBody()->getContents(), true);

        // Returns the decoded result, which contains information about the file, or null if an error occurs.
        return $result;
    }
}
