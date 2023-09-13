<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Conference extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    // public static function boot() {

	//     parent::boot();

	//     // static::created(function($item) {
	//     //    $item->permission_tag = Str::slug($item->title);
	//     // });

	//     static::creating(function($item) {
	//         $item->permission_tag = Str::slug($item->title);
	//     });
	    
	// }

    public function registrants(){
        return $this->hasMany(Application::class);
    }

    public function abstracts(){
        return $this->hasMany(ConferenceAbstract::class, 'conference_id');
    }

    public function sponsors(){
        return $this->hasMany(Sponsor::class);
    }

    public function payment_categories(){
        return $this->hasMany(PaymentCategory::class);
    }



}
