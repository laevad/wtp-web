<?php
namespace App\Http\Livewire\Shared;

use App\Models\Status;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Clients extends  GlobalVar {





    public function updateUser(): RedirectResponse
    {
        $validatedData = $this->validateClient();
        $previousPath = $this->user->avatar;
        if ($this->photo){
            Storage::disk('avatars')->delete($previousPath);
            $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        }else{
            $newPath = $this->setInitialPhoto($validatedData['name']);
            Storage::disk('avatars')->delete($previousPath);
            $validatedData['avatar'] = $newPath;
        }
        $this->user->update($validatedData);
        $this->showEditModal = false;
        $this->disable = false;
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Client updated successfully']);
        return redirect()->back();
    }

    public function createUser(): RedirectResponse
    {
        $validatedData = $this->validateClient();
        $validatedData['password'] = bcrypt('1234');
        $validatedData['role_id'] = User::ROLE_CLIENT;
        if ($this->photo){
            $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        }else{
            $validatedData['avatar'] = $this->setInitialPhoto($validatedData['name']);
        }

        User::create($validatedData);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Client added successfully']);
        $this->resetPage();
        $this->disable = false;
        return redirect()->back();
    }


    public function getUsersProperty()
    {
//        dd();
        return User::query()->where('role_id', '=',User::ROLE_CLIENT)
            ->latest()->paginate(5);
    }


    public function validateClient()
    {
        if ($this->showEditModal){
            return Validator::make($this->state,[
                'name'=>'required|min:4|max:60',
                'email'=>'nullable|email|unique:users,email,'.$this->user->id.'|min:6|max:60|regex:/(.+)@(.+)\.(.+)/i',
                'mobile'=>'required|numeric|phone|unique:users,mobile,'.$this->user->id,
                'status_id'=>[
                    'required',
                    Rule::in(Status::INACTIVE, Status::ACTIVE),
                ],
            ], ['status_id.required'=>'The status field is required.'])->validate();
        }
        return Validator::make($this->state,[
            'name'=>'required|min:4|max:200',
            'email'=>'nullable|email|unique:users,email|min:6|max:60|regex:/(.+)@(.+)\.(.+)/i',
            'mobile'=>'required|numeric|phone|unique:users,mobile',
            'status_id'=>[
                'required',
                Rule::in(Status::INACTIVE, Status::ACTIVE),
            ],
        ], ['status_id.required'=>'The status field is required.'])->validate();

    }

}
