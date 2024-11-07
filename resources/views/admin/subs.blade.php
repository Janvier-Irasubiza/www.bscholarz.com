@section('title', 'Subscriptions')

<x-app-layout>

<x-slot name="header">
</slot>

    <div style="padding: 0px 20px 32px 20px">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="f-20 f-600">Subscriptions</h1>
                    <p class="text-muted mt-2">Subscribers</p>
                </div>
                <a style="" href="{{ route('md.subs-plans') }}" class="scd-btn">View Plans</a>
            </div>
            
            <div class="mt-4">
                @include('components.subs-nav')
            </div>

            <div class="bg-gray p-3 subs-radius">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="f-18 f-500"><strong>{{ $category }}</strong> Subscriptions</h1>
                    <div class="flex gap-3 align-items-center">
                        <!-- <a style="" href="" class="scd-btn" data-bs-toggle="modal" data-bs-target="#composeMessage">Compose a message</a> -->
                        <a href="{{ route('md.subs', ['download' => 'excel', 'plan' => request('plan')]) }}" class="btn btn-primary">Download</a>
                    </div>
                </div>
                <table id="example1" class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">
                        <tr>
                        <th>Client</th>
                        <th>Joined on</th>
                        <th>Plan duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscribers as $entry)
                        <tr>
                            <!-- Subscriber Name, Email, and Phone -->
                            <td>
                                <div class="ms-3">
                                    <p class="mb-1 f-18">{{ $entry['subscriber']->names }}</p>
                                    <p class="text-muted mb-0 f-16">{{ $entry['subscriber']->email }}</p>
                                    <p class="text-muted mb-0 f-16">{{ $entry['subscriber']->phone }}</p>
                                </div>
                            </td>

                            <!-- Country -->
                            <td>
                                <p class="fw-normal mb-1 f-18">{{ $entry['subscriber']->created_at }}</p>
                            </td>

                            <!-- Subscription Duration and Valid Until -->
                            <td>
                                @php
                                    // Calculate months between start and end date
                                    $startDate = \Carbon\Carbon::parse($entry['start_date']);
                                    $endDate = \Carbon\Carbon::parse($entry['end_date']);
                                    $months = $startDate->diffInMonths($endDate);
                                @endphp
                                <p class="fw-normal mb-1 f-18">{{ $months }} months</p>
                                <p class="text-muted mb-0 f-16">Valid until {{ $endDate->format('Y-m-d') }}</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- <compose message> -->
    <div class="modal fade" id="composeMessage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" >
            <div class="modal-content">
                <div class="p-3 d-flex justify-content-between align-items-center"  style="border-bottom: 1px solid #e6e6e6">
                    <div class="text-left">
                        <p class="m-0" style="font-size: 20px;">
                            <strong>Compose a message</strong>
                        </p>
                        <p class="text-muted">For <strong>{{ $category }}</strong> Subscribers</p>
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="font-weight: 500; font-size: 15px">CLOSE</button>
                </div>
                <div class="modal-body text-left" id="">
                    <form action="" method="post">
                        <div>
                            <x-input-label for="names" style="text-align: left" class="text-left w-full" :value="__('Subject')" />
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Subject the communication</p>
                            <x-text-input id="names" class="block mt-1 w-full" style="border-radius: 4px;" type="text" name="names" :value="old('names')" placeholder="Enter subject" required autofocus autocomplete="names" />
                            <x-input-error :messages="$errors->get('names')" class="mt-2" />
                        </div>
                        <div class="mt-3">
                            <x-input-label for="names" style="text-align: left" class="text-left w-full" :value="__('Message')" />
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Details for the communication</p>
                            <textarea placeholder="Type message here..." id="desc" name="desc" class="block w-full" style="border: 2px solid #000; border-top: 0px; border-radius: 6px; border-top-right-radius: 0px; border-top-left-radius: 0px; padding: 6px; font-size: 14px" required ></textarea>
                            <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        </div>
                        <div class="mt-3">
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Send email, or sms or both</p>
                            <div class="d-flex justify-content-start gap-5 align-items-center">
                                <div class>
                                    <div>
                                        <input type="checkbox" name="" id=""> Email
                                    </div>
                                    <div>
                                        <input type="checkbox" name="" id=""> SMS
                                    </div>
                                </div>
                                <button type="submit" class="cst-primary-btn" style="font-weight: 500; font-size: 15px">SEND MESSAGE</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- </compose message> -->

</x-app-layout>