<?php

namespace App\Livewire\Event;

use App\Jobs\InviteImportJob;
use App\Models\Event;
use Illuminate\Support\Facades\Bus;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ImportInvites extends Component
{
    use WithFileUploads;
    public $imported_excel_file;
    public $error;
    public $imports;
    public $event;

    public $batchId;
    public $importing = false;
    public $importFilePath;
    public $importFinished = false;

    protected $rules = [
        'imported_excel_file' => 'required|mimes:csv,txt,xls,xlsx',
    ];


    public function mount(){

        $this->importComplete = false;
    }


    public function save()
    {
        $this->validate();
        $this->importing = true;
        $this->importFilePath = $this->imported_excel_file->store('imported_excel_file', 'public');

        $batch = Bus::batch([
            new InviteImportJob($this->importFilePath, $this->event),
        ])->dispatch();
        $this->batchId = $batch->id;
    }

    public function getImportBatchProperty()
    {
        if (!$this->batchId) {
            return null;
        }

        return Bus::findBatch($this->batchId);
    }

    public function updateImportProgress()
    {
        $this->importFinished = $this->importBatch->finished();

        if ($this->importFinished) {
            Storage::delete($this->importFilePath);
            $this->importing = false;
        }
    }

    public function render()
    {
        return view('livewire.event.import-invites');
    }
}
