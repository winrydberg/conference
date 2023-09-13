<?php

namespace App\Jobs;

use App\Mail\AbstractApprovalEmail;
use App\Mail\AbstractRejectionEmail;
use App\Models\Conference;
use App\Models\ConferenceAbstract;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessAbstractApproval implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ConferenceAbstract $abstract;
    public Conference $conference;
    public $state;
    /**
     * Create a new job instance.
     */
    public function __construct(ConferenceAbstract $abstract, Conference $conference, $state)
    {
        $this->abstract = $abstract;
        $this->conference = $conference;
        $this->state = $state;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            if($this->state == '1'){
                Mail::to($this->abstract->email)->send(new AbstractApprovalEmail($this->abstract, $this->conference));
            }else if($this->state == '0'){
                Mail::to($this->abstract->email)->send(new AbstractRejectionEmail($this->abstract, $this->conference));
            }

        }catch(Exception $e){
            Log::error($e);
        }
    }
}
