<?php

namespace App\View\Components\Nav;

use Illuminate\View\Component;

class Item extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public string $icon;
    public string $currentPage;





    public function __construct($icon, $currentPage)
    {
        $this->icon = $icon;
        $this->currentPage = $currentPage;
    }


    public function isCurrent(): bool
    {
        if( request()->segment(2) == $this->currentPage ) return  true;
        return false;
    }

    public function render()
    {


        return view('components.nav.item');
    }
}
