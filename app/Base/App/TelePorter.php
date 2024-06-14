<?php

namespace App\Base\App; // Namespace declaration indicating the location of this class within the project.

use App\Base\System\Traits\App\UploadTrait; // Imports the UploadTrait for adding file upload capabilities to the class.

class TelePorter
{ // Definition of the TelePorter class.

    use UploadTrait; // Utilizes the UploadTrait to add file upload functionality to this class.

    protected $getFileEndPoint = "https://api.telegram.org/file/bot"; // Holds the base URL for fetching files from Telegram.
    protected $fileDirectory; // Property to hold the directory where files will be teleported.
    protected $fileName; // Property to store the name of the file to be teleported.
    protected $file; // Property to hold the actual file content.

    /**
     * Constructor method for the TelePorter class.
     *
     * @param string $token The authentication token required for teleportation.
     * @param string $chatID The identifier for the chat where teleportation will occur.
     */
    public function __construct(protected $token, protected $chatID)
    {
        // Initializes a new instance of the TelePorter class with the provided token and chat ID.
        // Sets up the necessary parameters for teleportation functionality.
    }
}
