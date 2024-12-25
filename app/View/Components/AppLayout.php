<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\Message;
use App\Models\MessageReply;
use App\Models\Comment;

class AppLayout extends Component
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

        $recommendedComments = Comment::where('recommended_to', auth('staff')->user()->id)
            ->doesntHave('replies')
            ->count();

        return view('layouts.app', compact('nots', 'recommendedComments'));
    }
}
