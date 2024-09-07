<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListingTable extends Component
{
    public $items;
    public $type;
    public $title;

    public function __construct($items, $type, $title)
    {
        $this->items = $items;
        $this->type = $type;
        $this->title = $title;
    }

    public function render()
    {
        return view('components.listing-table');
    }
}
