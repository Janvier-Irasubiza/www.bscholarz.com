<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="px-3 lg:px-8 space-y-6">
            <div class="sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="d-flex gap-5 justify-content-between px-4 ">


                    <div class="w-full">
                    @include('profile.partials.update-profile-information-form')
                    </div>

                    @if(Auth::guard('staff'))

                    <div class="w-full">  
                        <table class="table align-middle mb-0 bg-white">
                            <thead class="bg-light">
                                <tr>
                                <th>Activity on my account</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($history as $record)
                                
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center" style="margin: 0px">
                                        <div class="w-full" style="padding: 0px 5px">
                                            <p class="fw-bold mb-1">{{ $record->activity }}</p>
                                            <p class="text-muted mb-0" style="font-size: 15px">{{ $record->done_at }}</p>
                                        </div>
                                        
                                        <div class="text-right w-full" style="padding: 0px 5px">
                                            <p class="text-muted mb-0" style="font-size: 15px"> {{ $record->details }} </p>
                                        </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    
                    @else

                    <div class="w-full">
                    @include('profile.partials.update-password-form')
                    </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
