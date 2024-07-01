<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TaskFilter extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $writerList;
    public $sendUrl;
    public $buyerList;
    public function __construct($writerList,$sendUrl,$buyerList)
    {
        $this->writerList = $writerList;
        $this->sendUrl = $sendUrl;
        $this->buyerList = $buyerList;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.task-filter');
    }
}
