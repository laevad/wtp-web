<?php
namespace App\Http\Livewire\Shared;

use App\Models\Status;
use App\Models\User;
use App\Rules\LicenseNumberRule;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Drivers extends GlobalVar{
    public $viewMode = false;
    public function addNew(){
        $this->showEditModal= false;
        $this->state = ['status_id'=>Status::ACTIVE,
            'date_of_joining'=>now()->toFormattedDate(),
            ];
        $this->photo = null;
        $this->viewMode = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function confirmUserRemoval($userId){
        $this->userBeignRemoved = $userId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }
    public function confirmSelectedUserRemoval(){
        $this->dispatchBrowserEvent('show-select-delete-confirmation');
    }
    public function createUser(): RedirectResponse
    {
        $validatedData =  $this->validateDriver();

        $validatedData['password'] = bcrypt('1234');
        $validatedData['role_id'] = User::ROLE_DRIVER;
        $validatedData['age'] = Carbon::parse($validatedData['date_of_birth'])->age;
        if ($this->photo){
            $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        }
        else{
            $validatedData['avatar'] = $this->setInitialPhoto($validatedData['name']);
        }


        User::create($validatedData);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Driver added successfully']);
        $this->resetPage();
        $this->disable = false;
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
        $this->showEditModal = false;
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
        $validatedData = $this->validateDriver();

        $previousPath = $this->user->avatar;
        if ($this->photo){
            $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        }else{
            $newPath = $validatedData['name'];
            Storage::disk('avatars')->delete($previousPath);
            $validatedData['avatar'] = $newPath;
        }
        $this->user->update($validatedData);
        $this->disable = false;
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Driver updated successfully']);
        return redirect()->back();
    }


    public function markAsActive(){
        User::whereIn('id', $this->selectedRows)->update(['status_id'=>Status::ACTIVE]);
        $this->dispatchBrowserEvent('updated',['message'=>'Driver/s marked as active']);
        $this->reset(['selectedRows', 'selectedPageRows']);
    }
    public function markAsInactive(){
        User::whereIn('id', $this->selectedRows)->update(['status_id'=>Status::INACTIVE]);
        $this->dispatchBrowserEvent('updated',['message'=>'Driver/s marked as inactive']);
        $this->reset(['selectedRows', 'selectedPageRows']);
    }

    public function validateDriver(){
        if ($this->showEditModal){
            return  Validator::make($this->state,[
                'name'=>'required|min:4|max:200|regex:/^[\pL\s-]+$/u',
                'email'=>'nullable|email|unique:users,email,'.$this->user->id.'|min:6|max:60|regex:/(.+)@(.+)\.(.+)/i',
                'mobile'=>'required|numeric|phone|unique:users,mobile,'.$this->user->id,
               /*date of birth = date format and before 2010*/
                'date_of_birth'=>'required|min:4|max:150|date|before:2010-01-01',
                'license_number'=>[
                    'required',
                    'min:4',
                    'max:150',
                    'unique:users,license_number,'.$this->user->id, new LicenseNumberRule(),
                ],
                /*total_experience limit to 50 yrs*/
                'total_experience'=>'required|numeric|min:0|max:50',
                'license_expiry_date'=>'required|date',
                'date_of_joining'=>'required|date',
                'status_id'=>'required',
                'address'=>'',
                'age'=>''
            ])->validate();
        }
        return Validator::make($this->state,[
            'name'=>'required|min:4|max:200|regex:/^[\pL\s-]+$/u',
            'email'=>'nullable|email|unique:users,email|min:6|max:60|regex:/(.+)@(.+)\.(.+)/i',
            'mobile'=>'required|numeric|phone|unique:users,mobile',
            /*date of birth = date format and before 2010*/
            'date_of_birth'=>'required|min:4|max:150|date|before:2010-01-01',
            'license_number'=>[
                'required',
                'min:4',
                'max:150',
                'unique:users,license_number', new LicenseNumberRule(),
            ],
            /*total_experience limit to 50 yrs*/
            'total_experience'=>'required|numeric|min:0|max:50',
            'license_expiry_date'=>'required|date|after:today',
            'date_of_joining'=>'required|date',
            'status_id'=>'required',
            'address'=>'',
            'age'=>''
        ])->validate();
    }


}
