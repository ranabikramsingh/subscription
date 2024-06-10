<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubscriptionPlanBox extends Component
{
    public $plan;
    public function __construct($plan)
    {
        $this->plan = $plan;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.subscription-plan-box');
    }
}
