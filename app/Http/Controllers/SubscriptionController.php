<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Utils;
use Illuminate\Http\Request;
use App\Models\SubPlan;
use App\Models\Subscriber;
use App\Models\SubService;
use App\Models\PlanService;
use App\Models\SubscriberSubscription;
use App\Models\Applicant_info;
use App\Exports\Subscribers;
use App\Mail\SubsMail;
use Maatwebsite\Excel\Facades\Excel;
use Mail;

class SubscriptionController extends Controller
{

    public function membership()
    {
        $plans = SubPlan::all();
        return view("membership", compact("plans"));
    }

    public function membership_form(Request $request)
    {

        // Fetch the authenticated user's email and corresponding subscriber record.
        $subscriber = Subscriber::where('email', $request->subscriber)->first();

        // If the user is not authenticated via the 'client' guard, redirect to subscriber form.
        if (!$subscriber) {
            if (auth()->guard('client')->check()) {
                $user = auth()->guard('client')->user();
                $subscriber = new Subscriber();
                $subscriber->names = $user->names;
                $subscriber->email = $user->email;
                $subscriber->phone = $user->phone_number;
                $subscriber->save();
            } else {
                return redirect()->route('membership.subsciber-form', ['plan' => $request->plan]);
            }
        }

        // Fetch all subscription plans.
        $plans = SubPlan::all();

        // Fetch the requested plan by UUID or handle null scenario.
        $requested_plan = SubPlan::where('uuid', $request->plan)->first();
        if (!$requested_plan) {
            return redirect()->back()->withErrors(['error' => 'The requested plan does not exist.']);
        }

        // Return the view with the required data.
        return view('member-form', compact('plans', 'requested_plan', 'subscriber'));
    }



    public function subscribe_form(Request $request)
    {
        $plan = SubPlan::where('uuid', $request->plan)->first();
        return view('subscribe', compact('plan'));
    }

    public function submit_subscriber_info(Request $request)
    {
        $validatedData = $request->validate(
            [
                'plan' => 'required',
                'names' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:100',
                'phone_number' => 'required|max:20',
                'email' => 'required|string|email|max:100',
            ],
            [
                'names.regex' => 'The names field must only contain letters and spaces.',
            ]
        );

        // Validate plan existence
        $plan = SubPlan::where('uuid', $validatedData['plan'])->first();
        if (!$plan) {
            return back()->with('error', 'Plan Not Found');
        }

        // Create or update subscriber
        $subscriber = Subscriber::firstOrCreate(
            ['email' => $validatedData['email']],
            [
                'phone' => $validatedData['phone_number'],
                'names' => $validatedData['names'],
            ]
        );

        // Create or update applicant info
        $applicant_info = Applicant_info::firstOrCreate(
            ['email' => $validatedData['email']],
            [
                'phone_number' => $validatedData['phone_number'],
                'names' => $validatedData['names'],
            ]
        );

        // Fetch the requested plan by UUID or handle null scenario.
        $requested_plan = SubPlan::where('uuid', $request->plan)->first();
        if (!$requested_plan) {
            return redirect()->back()->withErrors(['error' => 'The requested plan does not exist.']);
        }

        // dd($subscriber);

        return redirect()
            ->route('membership.form', [
                'plan' => $plan->uuid,
                'subscriber' => $subscriber->email,
            ]);
    }

    public function submit_membership(Request $request)
    {
        $validatedData = $request->validate(
            [
                'plan' => 'required',
                'subscriber' => 'required',
                'period' => 'required',
                'duration' => 'required',
                'amount' => 'required|string',
            ],
        );

        $plan = SubPlan::where('uuid', $validatedData['plan'])->first();
        if (!$plan) {
            return back()->with('error', 'Plan Not Found');
        }

        $subscriber = Subscriber::findOrFail($validatedData['subscriber']);
        if (!$subscriber) {
            return back()->with('error', 'Subscriber Not Found');
        }

        $subscriber_subscription = new SubscriberSubscription();
        $subscriber_subscription->subscriber_id = $subscriber->id;
        $subscriber_subscription->plan_id = $plan->id;
        $subscriber_subscription->start_date = Carbon::now()->startOfDay();
        $subscriber_subscription->end_date = Carbon::createFromFormat('d/m/Y', $validatedData['duration'])->format('Y-m-d');
        ;
        $subscriber_subscription->is_active = 0;
        $subscriber_subscription->amount = $validatedData['amount'];
        $subscriber_subscription->save();

        return redirect()->route('membership.pay', ['subscription' => $subscriber_subscription->uuid]);
    }

    public function membershipPaymentForm(Request $request)
    {

        $subscription = SubscriberSubscription::where('uuid', $request->subscription)->first();
        $plan = SubPlan::find($subscription->plan_id);

        return view('service-pay', compact('subscription', 'plan'));
    }

    public function subscriptionSuccess(Request $request)
    {
        // Example data, replace with your actual logic
        $plan = SubPlan::find($request->plan_id); // Or session('plan_id')

        return view('subscription.success', compact('plan'));
    }

    public function subs(Request $request)
    {
        $category = $request->query('plan', 'Basic');
        $plan = SubPlan::where('name', $category)->first();

        $subscribers = [];

        if ($plan) {
            $subscriptions = SubscriberSubscription::where('plan_id', $plan->id)->paginate(10);
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

        if ($request->query('download') === 'excel') {
            if (!empty($subscribers)) {
                return Excel::download(new Subscribers($category), 'subscribers.xlsx');
            } else {
                return back()->with('error', 'No subscribers found for this plan.');
            }
        }

        return view('admin.subs', compact('subscribers', 'category'));
    }

    public function subs_plans(Request $request)
    {
        $category = $request->query('plan', 'Basic');
        $plan = SubPlan::where('name', $category)->first();
        $subscribers = SubscriberSubscription::where('plan_id', $plan->id)->count();
        return view('admin.subs-plans', compact('plan', 'category', 'subscribers'));
    }

    public function subs_services()
    {
        $all_services = SubService::all();
        return response()->json($all_services);
    }

    public function storeService(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create new service
        $service = new SubService();
        $service->name = $request->name;
        $service->save();

        // Redirect back with success message
        return response()->json(['message' => 'Service created successfully'], 201);
    }

    public function updateService(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:sub_services,id',
            'name' => 'required|string|max:255',
        ]);

        $service = SubService::findOrFail($request->service_id);
        $service->name = $request->name;
        $service->save();

        return response()->json(['message' => 'Service updated successfully'], 200);
    }


    public function deleteService(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:sub_services,id',
        ]);

        $service = SubService::findOrFail($request->service_id);
        $service->delete();

        return response()->json(['message' => 'Service deleted successfully'], 200);
    }

    public function subs_plan_services(Request $request)
    {
        // Fetch services already assigned to the plan
        $plan_services = PlanService::where('plan_id', $request->plan)->pluck('service_id')->toArray();

        // Fetch all services
        $all_services = SubService::all();

        // Exclude services already assigned to the plan
        $available_services = $all_services->filter(function ($service) use ($plan_services) {
            return !in_array($service->id, $plan_services); // Filter services not assigned to the plan
        });

        // Fetch only the services assigned to the plan
        $assigned_services = SubService::whereIn('id', $plan_services)->get();

        return response()->json([
            'available_services' => $available_services->values(), // Return available services
            'assigned_services' => $assigned_services // Return assigned services
        ]);
    }

    public function addServiceToPlan(Request $request)
    {
        // Validate the request to ensure service_id and plan_id are provided
        $request->validate([
            'service_id' => 'required|exists:sub_services,id',
            'plan_id' => 'required|exists:sub_plans,id'
        ]);

        // Check if the service is already added to the plan
        $existingService = PlanService::where('plan_id', $request->plan_id)
            ->where('service_id', $request->service_id)
            ->first();

        if ($existingService) {
            return response()->json(['message' => 'Service is already added to this plan'], 400);
        }

        // Add service to plan
        PlanService::create([
            'plan_id' => $request->plan_id,
            'service_id' => $request->service_id,
        ]);

        return response()->json(['message' => 'Service added successfully'], 200);
    }

    public function removeServiceFromPlan(Request $request)
    {
        // Validate the request to ensure service_id and plan_id are provided
        $request->validate([
            'service_id' => 'required|exists:sub_services,id',
            'plan_id' => 'required|exists:sub_plans,id'
        ]);

        // Find the service entry in the PlanService table
        $planService = PlanService::where('plan_id', $request->plan_id)
            ->where('service_id', $request->service_id)
            ->first();

        // Check if the service exists in the plan
        if (!$planService) {
            return response()->json(['message' => 'Service not found in this plan'], 404);
        }

        // Delete the service from the plan
        $planService->delete();

        return response()->json(['message' => 'Service removed successfully'], 200);
    }

    public function exportSubsXcel(Request $request)
    {

        $category = $request->query('plan', 'Basic');
        $plan = SubPlan::where('name', $category)->first();

        return Excel::download(new Subscribers($plan), 'subscribers.xlsx');
    }

    public function sendMessage(Request $request)
    {
        try {
            // Decode JSON strings if needed
            $selectedPlans = $request->input('selected_plans', []);
            $subject = $request->input('subject');
            $comMethods = $request->input('contact_methods', []);
            $message = $request->input('desc');

            // Decode JSON strings if they're not already arrays
            if (is_string($selectedPlans)) {
                $selectedPlans = json_decode($selectedPlans, true) ?: [];
            }
            if (is_string($comMethods)) {
                $comMethods = json_decode($comMethods, true) ?: [];
            }

            if (empty($selectedPlans)) {
                return response()->json(['status' => 'error', 'message' => 'No plans selected.'], 400);
            }

            if (empty($comMethods)) {
                return response()->json(['status' => 'error', 'message' => 'No communication method selected.'], 400);
            }

            $allSubscribers = [];

            foreach ($selectedPlans as $planName) {
                $plan = SubPlan::where('name', $planName)->first();
                if (!$plan) {
                    return response()->json(['status' => 'error', 'message' => "Plan '{$planName}' not found."], 404);
                }

                $subscriptions = SubscriberSubscription::where('plan_id', $plan->id)->get();
                foreach ($subscriptions as $subscription) {
                    $subscriber = Subscriber::find($subscription->subscriber_id);
                    if ($subscriber) {
                        $allSubscribers[] = [
                            'subscriber' => $subscriber,
                            'start_date' => $subscription->start_date,
                            'end_date' => $subscription->end_date
                        ];
                    }
                }
            }

            if (empty($allSubscribers)) {
                return response()->json(['status' => 'error', 'message' => 'No subscribers found for selected plans.'], 404);
            }

            $util = new Utils();
            $notification = new Notifications();
            $smsData = [
                'key' => $notification->getSmsApiKey(),
                'message' => $message,
                'recipients' => []
            ];

            // Send messages to each subscriber in the list
            foreach ($allSubscribers as $data) {
                $subscriber = $data['subscriber'];
                if ($subscriber->phone) {
                    $smsData['recipients'][] = $util->formatPhoneNumber($subscriber->phone);
                }
                $this->sendMessageToSubscriber($subscriber, $subject, $message, $comMethods);
            }

            if (!empty($smsData['recipients']) && in_array('sms', $comMethods)) {
                $response = $notification->sendSms($smsData);

                if ($response['status'] === 200) {
                    return response()->json(['status' => 'success', 'message' => $response['message']], 200);
                } else {
                    return response()->json(['status' => 'error', 'message' => $response['message']], 500);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Messages sent successfully',
            ], 200);

        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error("Error sending messages: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went wrong, try again'], 500);
        }
    }


    protected function sendMessageToSubscriber($subscriber, $subject, $message, $comMethods)
    {
        if (in_array('email', $comMethods)) {
            // Ensure email exists and is valid before sending
            if (!empty($subscriber->email)) {
                Mail::to($subscriber->email)->send(new SubsMail($subject, $message, $subscriber->name));
            }
        }
    }


}
