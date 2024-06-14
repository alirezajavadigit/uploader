<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model // Define the Link model class extending Eloquent Model
{
    use HasFactory; // Use HasFactory trait for model factory support

    /**
     * Define the relationship with the User model.
     *
     * This method establishes a belongsTo relationship with the User model,
     * indicating that each Link belongs to a User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Define the User model relationship
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * These attributes are hidden when the model is converted to an array or JSON.
     *
     * @var array
     */
    protected $hidden = [
        'telegram_url', // Hide the telegram_url attribute from array/json representation
    ];
}
