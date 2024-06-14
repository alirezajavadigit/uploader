<?php

namespace App\Models;

// Import necessary Laravel classes and traits
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable // Define the User model class extending Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // Use traits: HasApiTokens, HasFactory, and Notifiable

    /**
     * The attributes that are mass assignable.
     *
     * These attributes can be filled using mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', // Name attribute
        'email', // Email attribute
        'password', // Password attribute
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * These attributes will be hidden when the model is serialized to arrays or JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', // Hide the password attribute
        'remember_token', // Hide the remember_token attribute
    ];

    /**
     * The attributes that should be cast.
     *
     * These attributes are cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Cast email_verified_at attribute to datetime type
    ];

    /**
     * Define a one-to-many relationship with the Link model.
     *
     * This method specifies that a User has many Link records.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function links()
    {
        return $this->hasMany(Link::class); // Define the hasMany relationship with Link model
    }
}
