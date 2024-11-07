<?php

namespace App\Exports;

use App\Models\Subscriber;
use App\Models\SubscriberSubscription;
use App\Models\SubPlan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class Subscribers implements FromView
{
    protected $category;

    public function __construct($category)
    {
        $this->category = $category;
    }

    public function view(): View
    {
        $plan = SubPlan::where('name', $this->category)->first();

        $subscribers = [];

        if ($plan) {
            $subscriptions = SubscriberSubscription::where('plan_id', $plan->id)->get();
            foreach ($subscriptions as $subscription) {
                $subscriber = Subscriber::find($subscription->subscriber_id);
                if ($subscriber) {
                    $subscribers[] = [
                        'subscriber' => $subscriber,
                        'start_date' => $subscription->start_date,
                        'end_date' => $subscription->end_date
                    ];
                }  
            }
        }

        return view('exports.subscribers', ['subscribers' => $subscribers, 'category' => $this->category]);
    }
}


