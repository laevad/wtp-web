<?php
namespace App\Http\Livewire\Shared;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Settings  extends Component{
    use WithFileUploads;
    public $image;

    public $state;


    public function mount(){
        $this->state = auth()->user()->only(['name', 'email']);
//        $this->state['api_key'] = Setting::where('id', 1)->pluck('api_key')->first();

    }

    protected function cleanupOldUploads()
    {
        $storage = Storage::disk('local');
        foreach ($storage->allFiles('livewire-tmp') as $filePathname) {
            $yesterdaysStamp = now()->subHours(2)->timestamp;
            if ($yesterdaysStamp > $storage->lastModified($filePathname)) {
                $storage->delete($filePathname);
            }
        }
    }
}
