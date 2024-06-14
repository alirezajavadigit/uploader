<?php

namespace App\Base\System\Traits\App; // Defines the namespace for the Teleporter\System\Traits\App package.

use App\Base\System\Telegram\TelegramClient; // Imports the TelegramClient class for interacting with Telegram.

trait UploadTrait // Defines the UploadTrait trait.
{
    /**
     * Uploads a file to Telegram and returns its final URL.
     *
     * @param string $url The URL of the photo to be uploaded.
     * @return string|null The final URL of the uploaded file, or null if the file type is not supported or an error occurs.
     */
    public function upload($url)
    {
        $ext = pathinfo($url, PATHINFO_EXTENSION);
        $category = $this->fileCategory($ext);
        // Initializes a new TelegramClient instance with the provided token and chat ID.
        $telegramClient = new TelegramClient($this->token, $this->chatID);

        // Sends the photo to Telegram using the TelegramClient's sendPhoto method and stores the result.
        if ($category === "image")
            $file = $telegramClient->sendPhoto($url);
        elseif ($category === "document")
            $file = $telegramClient->sendDocument($url);
        elseif ($category === "audio")
            $file = $telegramClient->sendAudio($url);
        elseif ($category === "video")
            $file = $telegramClient->sendVideo($url);
        // Retrieves information about the uploaded file using the TelegramClient's getFile method.
        $result = $telegramClient->getFile($this->getFileID($file));

        // Constructs and returns the final URL of the uploaded file.
        return $telegramClient->getFinalUrl($this->getFileEndPoint) . $result['result']['file_path'];
    }

    /**
     * Extracts the file ID from the response returned by Telegram after uploading a file.
     *
     * @param array $file The response returned by Telegram after uploading a file.
     * @return string|null The ID of the uploaded file, or null if the file type is not supported.
     */
    private function getFileID($file)
    {
        // Checks if the response contains information about a photo file.
        if (isset($file['result']['photo'][0]['file_id'])) {
            // Returns the file ID of the last photo in the array (assuming multiple photos were uploaded).
            return end($file['result']['photo'])['file_id'];
        }
        // Checks if the response contains information about a document file.
        if (isset($file['result']['document'])) {
            // Returns the file ID of the document.
            return $file['result']['document']['file_id'];
        }
        // Checks if the response contains information about an audio file.
        if (isset($file['result']['audio'])) {
            // Returns the file ID of the audio file.
            return $file['result']['audio']['file_id'];
        }
        // Checks if the response contains information about a video file.
        if (isset($file['result']['video'])) {
            // Returns the file ID of the video file.
            return $file['result']['video']['file_id'];
        }
    }

    /**
     * Determines the category of a file based on its extension.
     *
     * @param string $extension The file extension.
     * @return string The category of the file (image, document, audio, video, or unknown).
     */
    private function fileCategory($extension)
    {
        // Define an associative array with categories and their associated file extensions.
        $categories = [
            'image' => ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'tiff'],
            'document' => ['pdf', 'doc', 'docx', 'txt', 'odt', 'rtf', 'xls', 'xlsx', 'ods', 'csv'],
            'audio' => ['mp3', 'wav', 'aac', 'flac'],
            'video' => ['mp4', 'avi', 'mkv', 'mov', 'wmv']
        ];

        // Normalize the extension to lowercase.
        $extension = strtolower($extension);

        // Loop through the categories and return the matching category.
        foreach ($categories as $category => $extensions) {
            if (in_array($extension, $extensions)) {
                // Returns the category if the extension matches one of the extensions in the array.
                return $category;
            }
        }

        // Returns 'unknown' if the extension is not found in any category.
        return 'unknown';
    }
}
