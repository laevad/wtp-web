<?php
namespace App\Http\Livewire\Shared;

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



}
