<?php

namespace App\Http\Controllers\V1;

use App\Models\Link; // Import the Link model to interact with the links table in the database
use Illuminate\Http\Request; // Import the Request class for handling incoming HTTP requests
use App\Http\Controllers\Controller; // Import the base Controller class to extend it

/**
 * Class DownloadController
 *
 * This controller handles file download requests based on dynamic URL parameters.
 */
class DownloadController extends Controller // Define the DownloadController class that extends the base Controller class
{
    /**
     * Handles the download request.
     *
     * This method builds a URL string from the provided parameters, searches for 
     * a matching private URL in the Link model, and if found, serves the file for download.
     *
     * @param int $year The year part of the URL
     * @param int $month The month part of the URL
     * @param int $day The day part of the URL
     * @param string $dayName The day name part of the URL
     * @param int $hour The hour part of the URL
     * @param int $minute The minute part of the URL
     * @param int $second The second part of the URL
     * @param string $filename The name of the file to be downloaded
     * @return void
     */
    public function download($year, $month, $day, $dayName, $hour, $minute, $second, $filename) // Method to handle the download request
    {
        // Concatenate the provided parameters to form the private URL string
        $url = $year . "/" . $month . "/" . $day . "/" . $dayName . "/" . $hour . "/" . $minute . "/" . $second . "/" . $filename;

        // Query the Link model to find the first record matching the constructed private URL
        $link = Link::where("private_url", $url)->first();

        // Check if a matching record was found in the database
        if ($link) {
            // Extract the telegram_url from the found Link record for file download
            $link = $link->telegram_url;

            // Set the Content-Type header to indicate that the response is a binary stream
            header('Content-Type: application/octet-stream');

            // Set the Content-Transfer-Encoding header to Binary to indicate binary data transfer
            header("Content-Transfer-Encoding: Binary");

            // Set the Content-Disposition header to attachment, which suggests the browser to download the file
            header("Content-disposition: attachment; filename=\"" . basename($link) . "\"");

            // Read and output the file from the URL specified by telegram_url, triggering the file download
            readfile($link);
        }
    }
}
