<?php

namespace App\View\Components;

use Closure;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ComboUsers extends Component
{
    /**
     * Create a new component instance.
     */
    private $selected = 0;
    private $label = '';
    private $ref = '';
    private $inline = 0;
    private $escape = 0;
    public function __construct($selected = 0, $label = '', $ref = '', $inline = 0, $escape = 0)
    {
        $this->selected = $selected;
        $this->label = $label;
        $this->ref = $ref;
        $this->inline = $inline;
        $this->escape = $escape;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $escape = $this->escape;
        $where = " id>1 ";
        if($this->escape){
            $where.=" AND id!=$escape";
        }
        $rows = User::whereRaw($where)->orderBy('name')->get();
        $selected = $this->selected;
        $label = $this->label;
        $ref = $this->ref;
        $inline = $this->inline;
        return view('components.combo-users', compact('rows', 'selected', 'label', 'ref', 'inline', 'escape'));
    }
}
