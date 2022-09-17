<?php
namespace App\Http\Livewire\Shared;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class Clients extends  GlobalVar {




    public function updateUser(): RedirectResponse
    {
        $validatedData = Validator::make($this->state,[
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$this->user->id,
            'mobile'=>'required|numeric|unique:users,mobile,'.$this->user->id,
        ])->validate();

        if ($this->photo){
            $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        }
        $this->user->update($validatedData);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Client updated successfully']);
        return redirect()->back();
    }

    public function createUser(): RedirectResponse
    {
        $validatedData = Validator::make($this->state,[
            'name'=>'required|unique:users',
            'email'=>'required|email|unique:users',
            'mobile'=>'required|numeric|unique:users',
        ])->validate();
        $validatedData['password'] = bcrypt('1234');
        $validatedData['role_id'] = User::ROLE_CLIENT;
        if ($this->photo){
            $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        }
        User::create($validatedData);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Client added successfully']);
        $this->resetPage();
        return redirect()->back();
    }


}
