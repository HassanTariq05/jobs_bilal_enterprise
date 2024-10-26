<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use Illuminate\Support\Facades\DB;

class Combobox extends Component
{
    /**
     * Create a new component instance.
     */
    private $of = "";
    private $selected = 0;
    private $label = '';
    private $ref = '';
    private $inline = 1;
    private $autofocus = false;
    private $class = '';
    public function __construct($of = "", $selected = 0, $label = '', $ref = '', $inline = 1, $autofocus = false, $class = '')
    {
        $this->of = $of;
        $this->selected = $selected;
        $this->label = $label;
        $this->ref = $ref;
        $this->inline = $inline;
        $this->autofocus = $autofocus;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $rows = [];
        if ($this->of) {
            $rows = DB::table($this->of)->whereNull('deleted_at')->orderBy('title')->get();
        }
        $selected = $this->selected;
        $label = $this->label;
        $ref = $this->ref;
        $inline = $this->inline;
        $autofocus = $this->autofocus;
        $class = $this->class;
        
        return view("components.combobox", compact('rows', 'selected', 'label', 'ref', 'inline', 'autofocus', 'class'));
    }
}