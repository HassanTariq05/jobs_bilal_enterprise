<?php

namespace App\View\Components;

use Closure;
use App\Models\Fleet;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ComboFleet extends Component
{
    /**
     * Create a new component instance.
     */
    private $selected = 0;
    private $inline = 0;
    public function __construct($selected = 0, $inline = 0)
    {
        $this->selected = $selected;
        $this->inline = $inline;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $selected = $this->selected;
        $inline = $this->inline;
        $rows = Fleet::all();
        return view('components.combo-fleet', compact('rows', 'selected', 'inline'));
    }
}
