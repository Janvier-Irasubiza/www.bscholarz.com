<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\MessageReply;

class AccountantLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $nots = MessageReply::whereHas('message', function ($query) {
            $query->where('receiver', auth('staff')->user()->id)
                ->orWhere('sender', auth('staff')->user()->id);
        })->where('status', 'unread')
            ->count();
        return view('layouts.accountant', compact('nots'));
    }
}
