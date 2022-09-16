<?php

namespace App\View\Components\Nav;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Item extends Component
{
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

    public function getNavUrl(): string
    {
        return request()->segment(1).'.'.$this->currentPage;
    }

    public function render(): View|Factory|Htmlable|string|Closure|Application
    {
        return view('components.nav.item');
    }
}
