<?php
namespace App\Http\Livewire\Shared;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Drivers extends GlobalVar{
    public $viewMode = false;
    public function addNew(){
        $this->showEditModal= false;
        $this->state = ['status'=>'ACTIVE'];
        $this->photo = null;
        $this->viewMode = false;
        $this->dispatchBrowserEvent('show-form');
    }

    /**
     * @throws ValidationException
     */
    public function createUser(): RedirectResponse
    {
        $validatedData = Validator::make($this->state,[
            'name'=>'required|unique:users',
            'email'=>'required|email|unique:users',
            'mobile'=>'required|numeric',
            'age'=>'required|numeric',
            'license_number'=>'required|numeric',
            'total_experience'=>'required|numeric',
            'license_expiry_date'=>'required|date',
            'date_of_joining'=>'required|date',
            'status'=>'required',
            'address'=>''
        ])->validate();
        $validatedData['password'] = bcrypt('1234');
        $validatedData['role_id'] = User::ROLE_DRIVER;

        if ($this->photo){
            $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        }
        User::create($validatedData);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Driver added successfully']);
        $this->resetPage();
        return redirect()->back();
    }


    public function getUsersProperty(): LengthAwarePaginator
    {
        return User::query()->where('role_id', '=',User::ROLE_DRIVER)
            ->latest()->paginate(5);
    }


    /*View*/
    public function view(User $user){
        //        $this->reset();
        $this->state = [];
        $this->viewMode = true;
        $this->state = $user->toArray();
        $this->user = $user;
        $this->dispatchBrowserEvent('show-form');
    }


    /**
     * @throws ValidationException
     */
    public function updateUser(): RedirectResponse
    {
        $validatedData = Validator::make($this->state,[
            'name'=>'required|unique:users,email,'.$this->user->id,
            'email'=>'required|email|unique:users,email,'.$this->user->id,
            'mobile'=>'required|numeric',
            'age'=>'required|numeric',
            'license_number'=>'required|numeric',
            'total_experience'=>'required|numeric',
            'license_expiry_date'=>'required|date',
            'date_of_joining'=>'required|date',
            'status'=>'required',
            'address'=>''
        ])->validate();

        if ($this->photo){
            $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        }
        $this->user->update($validatedData);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Driver updated successfully']);
        return redirect()->back();
    }


    public function markAsActive(){
        User::whereIn('id', $this->selectedRows)->update(['status'=>'ACTIVE']);
        $this->dispatchBrowserEvent('updated',['message'=>'Driver/s marked as active']);
        $this->reset(['selectedRows', 'selectedPageRows']);
    }
    public function markAsInactive(){
        User::whereIn('id', $this->selectedRows)->update(['status'=>'INACTIVE']);
        $this->dispatchBrowserEvent('updated',['message'=>'Driver/s marked as inactive']);
        $this->reset(['selectedRows', 'selectedPageRows']);
    }
}
