<?php

namespace App\Http\Controllers\V1;

use Illuminate\Support\Str; // Import Str class for string manipulation
use App\Base\App\TelePorter; // Import TelePorter class (assuming it's a custom class)
use Illuminate\Http\Request; // Import Request class
use Illuminate\Support\Facades\URL; // Import URL facade for generating URLs
use App\Http\Controllers\Controller; // Import base Controller class
use Illuminate\Support\Facades\Cookie; // Import Cookie facade for handling cookies
use Illuminate\Support\Facades\Session; // Import Session facade for session handling
use App\Http\Requests\V1\StoreFileRequest; // Import StoreFileRequest form request class
use App\Models\Link; // Import Link model
use App\Models\User; // Import User model
use Carbon\Carbon; // Import Carbon for date/time manipulation

class UploadController extends Controller // Define the UploadController class extending Controller
{
    public function index()
    {
        // Check if user cookie is not set
        if (!Cookie::get("user")) {
            $token = Str::random(100); // Generate a random token
            $minutes = 100000000; // Token expiration time in minutes (arbitrarily large)
            $user = new User(); // Create a new User instance
            $user->rememeberToken = $token; // Assign the generated token to rememberToken (typo: should be 'rememberToken')
            $user->save(); // Save the user instance to the database
            return Cookie::queue('user', $token, $minutes); // Set the 'user' cookie with the generated token
        }

        // User cookie is set, retrieve user's links
        $user = User::where("rememeberToken", Cookie::get("user"))->first(); // Find the user by rememberToken
        $links = $user->links; // Get all links associated with the user
        return view('index', compact('links')); // Return the 'index' view with links data
    }

    public function upload(StoreFileRequest $request)
    {
        $telePorter = new TelePorter(env('TELEGRAM_BOT_TOKEN'), env('CHAT_ID')); // Instantiate TelePorter with Telegram bot token and chat ID

        if ($request->hasFile("file")) { // Check if file is uploaded
            $fileName = time() . '.' . $request->file->extension(); // Generate a unique filename based on current time and file extension
            $request->file->move(public_path('file'), $fileName); // Move uploaded file to 'public/file' directory

            $url =  URL::to("/") . "/file/" . $fileName; // Construct URL to access the uploaded file
            $fileUrl = $telePorter->upload($url); // Upload the file to Telegram using TelePorter and get the Telegram URL

            $user = User::where("rememeberToken", Cookie::get("user"))->first(); // Find the user by rememberToken
            $link = new Link(); // Create a new Link instance
            $link->telegram_url = $fileUrl; // Assign the Telegram URL of the uploaded file
            $link->file_name = $request->file->getClientOriginalName(); // Get the original filename of the uploaded file
            $link->user_id = $user->id; // Assign the user ID to the link
            $link->private_url = Carbon::now()->format("Y/m/d/l/H/i/s/") . $fileName; // Generate a private URL based on current timestamp and filename
            $link->save(); // Save the link instance to the database

            unlink(public_path("file/" . $fileName)); // Delete the temporary file from 'public/file' directory
        }

        return redirect()->back()->with("success", 'با موفقیت اپلود شد!'); // Redirect back with success message
    }
}
