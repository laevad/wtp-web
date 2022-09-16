<?php

namespace App\Http\Livewire\Shared;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends  Component{

    use WithFileUploads;
    public $image;

    public $state;


    public function mount(){
        $this->state = auth()->user()->only(['name', 'email']);
//        $this->state['api_key'] = Setting::where('id', 1)->pluck('api_key')->first();

    }

    public function updatedImage(){
        $previousPath = auth()->user()->avatar;
        $path =$this->image->store('/','avatars');
        auth()->user()->update(['avatar'=>$path]);
        Storage::disk('avatars')->delete($previousPath);
        $this->dispatchBrowserEvent('updated', ['message'=>'Profile changed successfully']);
    }

    protected function cleanupOldUploads()
    {
        $storage = Storage::disk('local');
        foreach ($storage->allFiles('livewire-tmp') as $filePathname) {
            $yesterdaysStamp = now()->subSecond(5)->timestamp;
            if ($yesterdaysStamp > $storage->lastModified($filePathname)) {
                $storage->delete($filePathname);
            }
        }
    }
    public function updateProfile(UpdateUserProfileInformation $updateUserProfileInformation){
        $updateUserProfileInformation->update(auth()->user(),[
            'name'=> $this->state['name'],
            'email'=> $this->state['email'],
        ]);

        $this->emit('nameChanged', auth()->user()->name);
        $this->dispatchBrowserEvent('updated', ['message'=>'Profile updated successfully']);
    }

    public function changePassword(UpdateUserPassword $updateUserPassword){
        $updateUserPassword->update(auth()->user(),Arr::only($this->state, ['current_password', 'password','password_confirmation']));
        $this->state['current_password']='';
        $this->state['password']='';
        $this->state['password_confirmation']='';
        $this->dispatchBrowserEvent('updated', ['message'=>'Password updated successfully']);
    }
}
