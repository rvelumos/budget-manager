<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListingForm extends Component
{
    public $route;
    public $type;
    public $listing;
    public $buttonText;

    public function __construct($route, $type, $listing = null, $buttonText = 'Create Listing')
    {
        $this->route = $route;
        $this->type = $type;
        $this->listing = $listing;
        $this->buttonText = $buttonText;
    }

    public function render()
    {
        return view('components.listing-form');
    }
}
