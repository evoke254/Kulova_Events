<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use App\Imports\InvitessImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InviteImportJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $uploadFile;
    public $event;
    /**
     * Create a new job instance.
     */
    public function __construct($uploadFile, $event)
    {
        $this->uploadFile = $uploadFile;
        $this->event = $event;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Excel::import(new InvitessImport($this->event), storage_path('app/public/'.$this->uploadFile));
    }

}
