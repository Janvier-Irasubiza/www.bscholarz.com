@section('title', 'Transaction - Review')

<x-accountant-layout>
    <x-slot name="header">
    </x-slot>

    <div style="padding: 0px 20px 32px 20px" class="mb-4">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2 mb-4">
            <div class="app-inner-layout__content">
                <div class="tab-content">
                    <div>
                        <div class="card">

                            <div style="border-top: none" class="d-block p-3 card-footer">

                                <div class="d-flex gap-3" style="padding-right: 17px">

                                    <div class="col-lg-6">
                                        <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Transaction Information')" />
                                        <div class="mt-3 mb-4">

                                            <div class="bg-white w-full sm:rounded-lg p-3">
                                                <div class="align-items-center no-shadow rm-border bg-transparent widget-chart text-left border rounded">
                                                    <div class="pb-2 pt-2" style="border-bottom: 1px solid #d9d9d9">
                                                        <div class="widget-chart-content col-lg-12 ml-1">
                                                            <div class="widget-description text-focus"><p><small>ID: &nbsp;</small><strong>{{ $payments -> id }}</strong></p></div>
                                                            <div class="widget-subheading"><small style="font-weight: 400">Service: &nbsp;</small>{{ $payments -> application -> discipline-> discipline_name }}</div>
                                                            <div class="widget-subheading"><small style="font-weight: 400">Amount Paid: &nbsp;</small>{{ number_format($payments -> amount) }} <small style="font-weight: 400">frw</small></div>
                                                            <div class="widget-description text-focus"><p><small>Organization: &nbsp;</small>{{ $payments -> application -> discipline->organization }}</p></div>
                                                            <div class="widget-description text-focus"><p><small>Transaction Time: &nbsp;</small>{{ $payments->created_at }}</p></div>
                                                            <div class="widget-description text-focus"><p><small>Service Time: &nbsp;</small>{{ $payments -> application -> served_on }}</p></div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-2 mb-2 d-flex gap-3 justify-content-center">
                                                        <form action="{{ route('approve-transaction', ['transaction' => $payments -> id]) }}" method="POST">
                                                            @csrf <!-- Include CSRF token for security -->
                                                            <button type="submit" class="btn bg-success">
                                                                <span class="mr-1"><strong class="text-white">APPROVE</strong></span>
                                                            </button>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Agent Information')" />
                                        <div class="mt-3 mb-4">

                                            <div class="bg-white w-full sm:rounded-lg p-3">
                                                <div class="align-items-center no-shadow rm-border bg-transparent widget-chart text-left border rounded">
                                                    <div class="pb-2 pt-2" style="border-bottom: 1px solid #d9d9d9">
                                                        <div class="widget-chart-content col-lg-12 ml-1">
                                                            <div class="widget-subheading"><small style="font-weight: 400">Names: &nbsp;</small>{{ $payments -> application -> appAssistant -> names }}</div>
                                                            <div class="widget-description text-focus"><p><small>Phone: &nbsp;</small>{{ $payments -> application -> appAssistant -> phone_number }}</p></div>
                                                            <div class="widget-description text-focus"><p><small>Email: &nbsp;</small>{{ $payments -> application -> appAssistant -> email }}</p></div>
                                                            <div class="widget-description text-focus"><p><small>Role: &nbsp;</small>{{ $payments -> application -> appAssistant -> role }}</p></div>
                                                            <div class="widget-description text-focus"><p><small>Percentage: &nbsp;</small>{{ $payments -> application -> appAssistant -> percentage }}</p></div>
                                                            <div class="widget-description text-focus"><p><small>Current Status: &nbsp;</small>{{ $payments -> application -> appAssistant -> status }}</p></div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-2 mb-2 d-flex gap-3 justify-content-center">
                                                        <a href="#" class="btn btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                            <span class="mr-1"><strong class="text-white">ASK FOR CLARIFICATIONS</strong></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>




                                            <!-- Modal -->
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form action="{{ route('send-clarification-message', ['transaction' => $payments->id]) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-content" style="top: 100px">
                                                                <div class="modal-header">
                                                                    <strong><h1 style="font-size: 14px" class="modal-title fs-5" id="exampleModalLabel">Transaction Clarification</h1></strong>
                                                                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close">
                                                                        <i style="font-size: 24px; margin-left: 0px; margin-top: -10px" class="fa-solid fa-xmark"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="">
                                                                        <x-input-label for="title" :value="__('Title')" />
                                                                        <input style="padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="title" class="block mt-1 w-full" type="text" name="title" placeholder="Give a title to your concern" required />
                                                                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                                                    </div>

                                                                    <div class="mt-3">
                                                                        <x-input-label for="desc" :value="__('Concern description')" />
                                                                        <textarea style="padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="desc" class="block mt-1 w-full" name="desc" placeholder="Describe your concern" required></textarea>
                                                                        <x-input-error :messages="$errors->get('desc')" class="mt-2" />
                                                                    </div>

                                                                    <!-- Hidden inputs for agent information and application details -->
                                                                    <input type="hidden" name="agent_id" value="{{ $payments->application->assistant }}">
                                                                    <input type="hidden" name="application_id" value="{{ $payments->application->app_id }}">

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border: 2px solid #000; color: #000; font-weight: bold">CANCEL</button>
                                                                    <button type="submit" class="btn btn-secondary bg-success" style="border: none; color: #000; font-weight: bold">CLARIFY</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>





                                </div>

                            </div>


                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


</x-accountant-layout>
