<?php
namespace App\Http\Livewire\Shared;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class GlobalVar extends  Component{


    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme ='bootstrap';

    public $state = [];
    public $showEditModal = false;
    public $viewMode= false;
    public $user;
    public $vehicle;
    public $userBeignRemoved = null;
    public $vehicleBeignRemoved = null;
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
        return User::query()->where('role_id', '=',User::ROLE_ADMIN)
            ->latest()->paginate(5);
    }


    /*DELETE*/
    public function deleteUser(){
        $user = User::query()->where('id', '=' , $this->userBeignRemoved)->first();
        $previousPath = $user->avatar;
        Storage::disk('avatars')->delete($previousPath);
        $client = User::findOrFail($this->userBeignRemoved);
        $client->delete();
        $this->reset(['selectedRows', 'selectedPageRows']);
        $this->dispatchBrowserEvent('deleted', ['message'=>'User deleted successfully']);
    }

    public function confirmUserRemoval($userId){
        $this->userBeignRemoved = $userId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }
    public function confirmSelectedUserRemoval(){
        $this->dispatchBrowserEvent('show-select-delete-confirmation');
    }

    public function deletedSelectedRows(){
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
}
