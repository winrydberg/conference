<?php

namespace App\Jobs;

use App\Mail\VerificationMail;
use App\Models\Conference;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessVerificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $emailtype;
    public $email;
    public $conferenceid;
    public $actiontype;
    /**
     * Create a new job instance.
     */
    public function __construct($emailtype, $email, $actiontype, $conferenceid)
    {
        $this->emailtype = $emailtype;
        $this->email = $email;
        $this->conferenceid = $conferenceid;
        $this->actiontype = $actiontype;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            $conference = Conference::where('id', $this->conferenceid)->first();
            Mail::to($this->email)->send(new VerificationMail($this->emailtype, $this->email, $conference?->token, $this->actiontype));
        }catch(Exception $e){
            Log::error($e);
        }
        
    }
}
