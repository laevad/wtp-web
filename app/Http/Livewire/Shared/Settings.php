<?php

namespace App\Http\Livewire\Shared;
use App\Models\ApiKey;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends  Component{

    use WithFileUploads;

    public $image;
    public $state;
    public $api;


    public function mount(){
        $this->state = auth()->user()->only(['name', 'email']);
        $this->api['name'] = ApiKey::where('id', ApiKey::API_ID)->pluck('name')->first();
    }

    /*UPDATE IMAGE*/
    public function updatedImage(){
        $previousPath = auth()->user()->avatar;
        $path =$this->image->store('/','avatars');
        auth()->user()->update(['avatar'=>$path]);
        Storage::disk('avatars')->delete($previousPath);
        $this->dispatchBrowserEvent('updated', ['message'=>'Profile changed successfully']);
    }

//    CLEAN
    protected function cleanupOldUploads()
    {
        $storage = Storage::disk('local');
        foreach ($storage->allFiles('livewire-tmp') as $filePathname) {
            $yesterdaysStamp = now()->hour(2)->timestamp;
            if ($yesterdaysStamp > $storage->lastModified($filePathname)) {
                $storage->delete($filePathname);
            }
        }
    }

    /*UPDATE DETAILS*/
    /**
     * @throws ValidationException
     */
    public function updateProfile(){
        $this->update(auth()->user(),[
            'name'=> $this->state['name'],
            'email'=> $this->state['email'],
        ]);

        $this->emit('nameChanged', auth()->user()->name);
        $this->dispatchBrowserEvent('updated', ['message'=>'Profile updated successfully']);
    }


    /*CHANGE PASS*/
    /**
     * @throws ValidationException
     */
    public function changePassword(){
        $this->updatePass(auth()->user(),Arr::only($this->state, ['current_password', 'password','password_confirmation']));
        $this->state['current_password']='';
        $this->state['password']='';
        $this->state['password_confirmation']='';
        $this->dispatchBrowserEvent('updated', ['message'=>'Password updated successfully']);
    }


    /*update API*/
    public function apiKey(){
        $validatedData = Validator::make($this->api,[
            'name'=>'nullable',
        ])->validate();
        ApiKey::where('id', '=', ApiKey::API_ID)->update($validatedData);
        $this->dispatchBrowserEvent('updated', ['message'=>'Google API updated successfully']);

    }



    /*CUSTOM FUNCTION=====================================*/
    /*custom update*/
    /**
     * @throws ValidationException
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ])->validateWithBag('updateProfileInformation');

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {

        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
        }
    }

    /*custom update pass*/
    /**
     * @throws ValidationException
     */
    public function updatePass($user, array $input)
    {
        Validator::make($input, [
            'current_password' => ['required', 'string'],
            'password' =>['required', 'string', 'confirmed',Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()],
        ])->after(function ($validator) use ($user, $input) {
            if (! isset($input['current_password']) || ! Hash::check($input['current_password'], $user->password)) {
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
            }
        })->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }

}
