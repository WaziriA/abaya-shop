<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    //
    protected $table = 'password_reset_tokens';

    protected $primaryKey = 'email';
    public $incrementing = false;

    // Ensure that timestamps are used, if you added the 'updated_at' column
    public $timestamps = true;

    protected $fillable = ['email', 'token', 'created_at', 'updated_at'];
}
