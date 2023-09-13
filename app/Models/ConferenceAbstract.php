<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ConferenceAbstract extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the user's first name.
     */
    protected function approved(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value == true ? 'Approved' : 'Not Approved / Rejected',
        );
    }
}
