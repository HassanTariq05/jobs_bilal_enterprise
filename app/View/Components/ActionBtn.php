<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActionBtn extends Component
{
    /**
     * Create a new component instance.
     */
    private $route = "";
    private $id = 0;
    private $privilegeEditId = 0;
    private $privilegeDeleteId = 0;
    private $privilegeRestoreId = 0;
    public function __construct($route = "", $id = 0, $privilegeEditId=0, $privilegeDeleteId = 0, $privilegeRestoreId = 0)
    {
        $this->route = $route;
        $this->id = $id;
        $this->privilegeEditId = $privilegeEditId;
        $this->privilegeDeleteId = $privilegeDeleteId;
        $this->privilegeRestoreId = $privilegeRestoreId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $route = $this->route;
        $id = $this->id;
        $privilegeEditId = $this->privilegeEditId;
        $privilegeDeleteId = $this->privilegeDeleteId;
        $privilegeRestoreId = $this->privilegeRestoreId;
        return view('components.action-btn', compact('route', 'id', 'privilegeEditId', 'privilegeDeleteId', 'privilegeRestoreId'));
    }
}
