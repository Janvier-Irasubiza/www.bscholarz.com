<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubPlan;
use App\Models\Subscriber;
use App\Models\SubService;
use App\Models\PlanService;
use App\Models\SubscriberSubscription;
use App\Exports\Subscribers;
use Maatwebsite\Excel\Facades\Excel;

class SubscriptionController extends Controller
{
    public function subs(Request $request) {
        $category = $request->query('plan', 'Basic');
        if ($request->query('download') === 'excel') {
            return Excel::download(new Subscribers($category), 'subscribers.xlsx');
        }
        $plan = SubPlan::where('name', $category)->first();

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

        return view('admin.subs', compact('subscribers', 'category'));
    }

    public function subs_plans(Request $request) {
        $category = $request->query('plan', 'Basic');
        $plan = SubPlan::where('name', $category)->first();
        $subscribers = SubscriberSubscription::where('plan_id', $plan->id)->count();
        return view('admin.subs-plans', compact('plan', 'category', 'subscribers'));
    }

    public function subs_services() {
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

    public function updateService(Request $request) {
        $request->validate([
            'service_id' => 'required|exists:sub_services,id',
            'name' => 'required|string|max:255',
        ]);
    
        $service = SubService::findOrFail($request->service_id);
        $service->name = $request->name;
        $service->save();
    
        return response()->json(['message' => 'Service updated successfully'], 200);
    }
    
    
    public function deleteService(Request $request) {
        $request->validate([
            'service_id' => 'required|exists:sub_services,id',
        ]);
    
        $service = SubService::findOrFail($request->service_id);
        $service->delete();
    
        return response()->json(['message' => 'Service deleted successfully'], 200);
    }
    
    public function subs_plan_services(Request $request) {
        // Fetch services already assigned to the plan
        $plan_services = PlanService::where('plan_id', $request->plan)->pluck('service_id')->toArray();
    
        // Fetch all services
        $all_services = SubService::all();
    
        // Exclude services already assigned to the plan
        $available_services = $all_services->filter(function($service) use ($plan_services) {
            return !in_array($service->id, $plan_services); // Filter services not assigned to the plan
        });
    
        // Fetch only the services assigned to the plan
        $assigned_services = SubService::whereIn('id', $plan_services)->get();
    
        return response()->json([
            'available_services' => $available_services->values(), // Return available services
            'assigned_services' => $assigned_services // Return assigned services
        ]);
    }

    public function addServiceToPlan(Request $request) {
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

    public function removeServiceFromPlan(Request $request) {
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
    
    public function exportSubsXcel(Request $request) {

        $category = $request->query('plan', 'Basic');
        $plan = SubPlan::where('name', $category)->first();

        return Excel::download(new Subscribers($plan), 'subscribers.xlsx');
    }
    
}
