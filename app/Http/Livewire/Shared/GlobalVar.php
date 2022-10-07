<?php
namespace App\Http\Livewire\Shared;

use App\Models\Status;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class GlobalVar extends  Component{


    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme ='bootstrap';
    public bool $disable =false;
    public $state = [];
    public $showEditModal = false;
    public $viewMode= false;
    public $user;
    public $vehicle;
    public $userBeignRemoved = null;
    public $vehicleBeingRemoved = null;
    public $searchTerm ;
    public $photo ='';
    public $sortColumnName ='created_at';
    public $sortDirection = 'desc';
    protected $queryString = ['searchTerm'=>['except'=>'']];
    public $listeners = ['deleteConfirmed'=> 'deleteUser', 'deleteSelected'=>'deletedSelectedRows'];
    public $selectedRows = [];
    public $selectedPageRows = false;


    /*ADD USER*/
    public function addNew(){
        $this->showEditModal= false;
        $this->viewMode= false;
        //        $this->reset();
        $this->photo = null;
        $this->state = [];
        $this->dispatchBrowserEvent('show-form');
    }

    /*EDIT*/
    public function edit(User $user){
        //        $this->reset();
        $this->state = [];
        $this->viewMode=false;
        $this->showEditModal = true;
        $this->state = $user->toArray();
        $this->user = $user;
        $this->dispatchBrowserEvent('show-form');
    }


    /*SORT*/
    public function sortedBy($columnName){
        if ($this->sortColumnName === $columnName){
            $this->sortDirection = $this->swapSortDirection();

        }else{
            $this->sortDirection = 'asc';
        }
        $this->sortColumnName = $columnName;
    }
    public function swapSortDirection(){
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    /*SEARCH*/
    public function updatedSearchTerm(){
        $this->resetPage();
    }

    /*SELECTED*/
    public function updatedSelectedPageRows($value){

        if ($value){
            $this->selectedRows = $this->users->pluck('id')->map(function ($id){
                return (string) $id;
            });
        }else{
            $this->reset(['selectedRows', 'selectedPageRows']);
        }

    }

    public function getUsersProperty(){
        return User::query()->where('role_id', '!=',User::ROLE_ADMIN)
            ->latest()->paginate(5);
    }


    /*DELETE*/
    public function deleteUser(){
        try {
            $user = User::query()->where('id', '=' , $this->userBeignRemoved)->first();
            $previousPath = $user->avatar;
            Storage::disk('avatars')->delete($previousPath);
            $client = User::findOrFail($this->userBeignRemoved);
            $client->delete();
            $this->reset(['selectedRows', 'selectedPageRows']);
            $this->dispatchBrowserEvent('deleted', ['message'=>'User deleted successfully']);
        }catch (\Exception){
            $this->reset(['selectedRows', 'selectedPageRows']);
            $this->resetPage();
            $this->dispatchBrowserEvent('error-booking', ['message'=>'User deleted unsuccessfully']);
        }
    }

    public function confirmUserRemoval($userId){
        $this->userBeignRemoved = $userId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }
    public function confirmSelectedUserRemoval(){
        $this->dispatchBrowserEvent('show-select-delete-confirmation');
    }

    public function deletedSelectedRows(){
       try{
           if ($this->selectedPageRows){
               $selectedR =$this->selectedRows->toArray();
           }else{
               $selectedR =$this->selectedRows;
           }
           foreach ($selectedR as  $selected){
               $user = User::query()->where('id', '=' ,$selected)->first();
               if ( $user->avatar !=null){
                   $previousPath = $user->avatar;
                   Storage::disk('avatars')->delete($previousPath);
               }
           }

           User::whereIn('id',$this->selectedRows)->delete();
           $this->dispatchBrowserEvent('deleted',['message'=>'All selected user/s got deleted.']);
           $this->reset(['selectedRows', 'selectedPageRows']);
           $this->resetPage();
       }catch (\Exception){
           $this->reset(['selectedRows', 'selectedPageRows']);
           $this->resetPage();
           $this->dispatchBrowserEvent('error-booking', ['message'=>'User deleted unsuccessfully']);
       }
    }


    public function setInitialPhoto($name): string
    {
        $path = 'storage/avatars/';
        $fontPath = public_path('fonts/Oliciy.ttf');
        $char = strtoupper($name[0]);
        $newAvatarName = rand(12,34353).time().'_avatar.png';
        $dest = $path.$newAvatarName;

        $createAvatar = makeAvatar($fontPath,$dest,$char);
        return $createAvatar ? $newAvatarName : '';
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

    /*unselect selected row if click next / previous*/
    public  int $cPage =0 ;

    public function cPageChanges($currPage){
        if ($this->cPage != $currPage){
            $this->cPage = $currPage;
            $this->reset(['selectedRows', 'selectedPageRows']);
        }
    }

    /* change the user status [active, inactive]*/
    public function changeUserStatus(User $user, $status){
        Validator::make(['status_id'=>$status],[
                'status_id'=>[
                    'required',
                    Rule::in(Status::INACTIVE, Status::ACTIVE),
                ],
            ]
        )->validate();
        if ( $status == 1){
            $stats = 'ACTIVE';
        }elseif ($status == 2) {
            $stats = 'INACTIVE';
        }else{
            $stats= '';
        }
        $user->update(['status_id'=> $status]);
        $this->dispatchBrowserEvent('updated', ['message'=>"Status changed to {$stats} successfully!"]);
    }
    /* change the vehicle status [active, inactive, maintenance]*/
    public function changeVehicleStatus(Vehicle $vehicle, $status){
        Validator::make(['status_id'=>$status],[
                'status_id'=>[
                    'required',
                    Rule::in(VehicleStatus::INACTIVE, VehicleStatus::ACTIVE, VehicleStatus::MAINTENANCE),
                ],
            ]
        )->validate();
        if ( $status == VehicleStatus::ACTIVE){
            $stats = 'ACTIVE';
        }elseif ($status == VehicleStatus::INACTIVE) {
            $stats = 'INACTIVE';
        }elseif ($status == VehicleStatus::MAINTENANCE) {
            $stats = 'MAINTENANCE';
        }
        else{
            $stats= '';
        }
        $vehicle->update(['status_id'=> $status]);
        $this->dispatchBrowserEvent('updated', ['message'=>"Vehicle status changed to {$stats} successfully!"]);
    }

    /* get the user status */
        public function getUserStatus(): Collection
        {
       return  Status::all();
    }
}
