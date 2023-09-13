<?php

namespace App\Jobs;

use App\Mail\NewAbstractSubmissionEmail;
use App\Models\Application;
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

class ProcessAbstractSubmissionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Application $application;
    public Conference $conference;
    public string $email;
    /**
     * Create a new job instance.
     */
    public function __construct(Application $application, Conference $conference, $email)
    {
        $this->application = $application;
        $this->conference = $conference;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            // $conference = Conference::where('id', $this->conferenceid)->first();
            Mail::to($this->email)->send(new NewAbstractSubmissionEmail($this->application, $this->conference, $this->email));
        }catch(Exception $e){
            Log::error($e);
        }
    }
}
