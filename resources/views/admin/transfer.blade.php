@section('title', 'Application info')

<x-app-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 20px 32px 20px">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2">

    <div class="container-fluid">
    <div class="card-header-tab card-header py-3 d-flex" style="border-bottom: 1px solid rgba(0, 0, 0, 0.192)">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                    Transfer Money
                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">

                    <a style="font-weight: 500; border: 1.3px solid;" href="{{ route('admin.revenue') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                    Got To Revenue
                    </a>

                    </div>
                    </div>
    <form method="post" action="" class="mt-6 space-y-6 mt-4 mb-3">
        @csrf

        <div>
            <x-input-label for="emp" :value="__('Transfer to')" />
            <select name="emp" id="" class="mt-1 block w-full" style="border: 2px solid #383838; border-radius: 6px; padding: 6px 10px">
                <option value="">Select receiver</option>
                <option value="">07812874324 - Maguire
                </option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('emp')" />
        </div>

        <div>
            <x-input-label for="amount" :value="__('Amount')" />
            <x-text-input id="amount" name="amount" type="text" class="mt-1 block w-full" value="" required autocomplete="amount" placeholder="Enter amount"/>
            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
        </div>

        <div class="flex items-center gap-4">
        <x-primary-button class="apply-btn" style="border: none">
                {{ __('transfer') }}
            </x-primary-button>
        </div>
    </form>
    </div>


    </div>
</div>

</x-app-layout>