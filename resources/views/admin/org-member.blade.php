@section('title', 'Member Info')

<x-app-layout>

    <x-slot name="header">
        </slot>

        <div style="padding: 0px 20px 32px 20px" class="mb-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2 mb-4">
                <div class="app-inner-layout__content">
                    <div class="tab-content">
                        <div>
                            <div class="card">
                                <div class="card-header-tab card-header py-3 d-flex">

                                    <div
                                        class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-5">

                                        <div class="d-flex gap-5 align-items-center">

                                            <div>
                                                <a href="{{ route('admin.org') }}"
                                                    class="d-flex gap-1 align-items-center back-btn"> <span
                                                        class="fa-solid fa-angle-left"
                                                        style="font-size: 23px; color: #595959"></span> Organization</a>
                                            </div>

                                            <div>
                                                {{ $member->names }} <br>
                                                <p class="text-muted mb-0" style="text-transform: none">
                                                    {{ $member->email }}
                                                </p>
                                                <p class="text-muted mb-0" style="text-transform: none">
                                                    {{ $member->phone_number }}
                                                </p>
                                            </div>

                                            <div>
                                                <small>
                                                    Dept:
                                                    @if(isset($member->department))
                                                        <span
                                                            style="padding: 0px 20px; text-align: center; border: 1px solid #00000023; color: #808080; border-radius: 4px"
                                                            name="dept" class="block mt-1 w-full input-holder">
                                                            {{ $member->department->name }} </span>
                                                    @endif

                                                    @if(isset($dept))
                                                        <span
                                                            style="padding: 0px 20px; text-align: center; border: 1px solid #00000023; color: #808080; border-radius: 4px"
                                                            name="dept" class="block mt-1 w-full input-holder">
                                                            {{ $dept->name }}
                                                        </span>
                                                    @endif
                                                </small>

                                            </div>

                                        </div>

                                    </div>
                                    <div
                                        class="btn-actions-pane-right text-capitalize d-flex justify-content-end align-items-center text-right col-lg-7">

                                        @if($member->working_status == 'Working')
                                            <span
                                                class="badge bg-success rounded-pill px-3 py-2">{{ $member->working_status }}</span>

                                            &nbsp;
                                            <a style="font-weight: 500; border: 1.3px solid;"
                                                class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 btn-danger"
                                                data-toggle="modal" data-target="#seek"> <i class="fa-solid fa-trash"></i>
                                                &nbsp; Invalidate </a>

                                        @elseif(isset($dept))
                                            <span
                                                class="badge bg-danger rounded-pill px-3 py-2">{{ $member->working_status }}</span>
                                            &nbsp;
                                            <a href="{{ route('admin.validate-it-emp', ['assistant' => $member->id]) }}"
                                                style="font-weight: 500; border: 1.3px solid;"
                                                class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 btn-success">Validate</a>

                                        @else
                                            <span
                                                class="badge bg-danger rounded-pill px-3 py-2">{{ $member->working_status }}</span>
                                            &nbsp;
                                            <a href="{{ route('admin.validate-emp', ['assistant' => $member->id]) }}"
                                                style="font-weight: 500; border: 1.3px solid;"
                                                class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 btn-success">Validate</a>

                                        @endif

                                        <!-- Modal -->
                                        <div class="modal fade" id="seek" data-backdrop="static" tabindex="-1"
                                            role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog w-mdal modal-dialog-centered d-flex align-items-center"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div>
                                                            <h5 class="modal-title" style="text-align: left"
                                                                id="staticBackdropLabel">{{ $member->names }}</h5>
                                                            <small style="font-size: 14px;" class="text-muted mb-0">
                                                                <span class="email">{{ $member->phone_number }}</span>
                                                                - <span
                                                                    class="phone-number">{{ $member->email }}</span></small>
                                                        </div>

                                                        <button type="button" class="close btn btn-danger"
                                                            style="border: 3px solid;" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span style="color: #000" aria-hidden="true"
                                                                class="fa fa-times"></span>
                                                        </button>

                                                    </div>

                                                    @if(isset($dept))

                                                        <form action="{{ route('admin.invalidate-it-emp') }}" method="post"
                                                            class="space-y-2"> @csrf

                                                    @else

                                                        <form action="{{ route('admin.invalidate-emp') }}" method="post"
                                                            class="space-y-2"> @csrf

                                                    @endif

                                                            <div class="modal-body">

                                                                <input
                                                                    style="padding: 6px 10px; text-align: left; border: 1px solid #00000050; color: #808080; border-radius: 4px"
                                                                    value="{{ $member->id }}" name="assistant"
                                                                    id="assistant"
                                                                    class="block mt-1 w-full input-holder assistant"
                                                                    hidden />

                                                                <div class="mt-4 w-full">
                                                                    <x-input-label for="issue" style="text-align: left"
                                                                        class="text-left w-full"
                                                                        :value="__('Reason')" />
                                                                    <p style="font-size: 14px; text-align: left"
                                                                        class="text-muted mb-0 text-left w-full">Reson
                                                                        of invalidation</p>
                                                                    <input placeholder="Type reason here..."
                                                                        id="reply_input" name="reason"
                                                                        class="block w-full"
                                                                        style="border: 2px solid #000; border-radius: 6px; padding: 6px; font-size: 14px"
                                                                        required />
                                                                    <x-input-error :messages="$errors->get('reason')"
                                                                        class="mt-2" />
                                                                </div>

                                                                <div class="mt-4 w-full">
                                                                    <x-input-label for="issue" style="text-align: left"
                                                                        class="text-left w-full"
                                                                        :value="__('Decision')" />
                                                                    <p style="font-size: 14px; text-align: left"
                                                                        class="text-muted mb-0 text-left w-full">
                                                                        Decision of invalidation</p>
                                                                    <input placeholder="Type decision here..."
                                                                        id="reply_input" name="decision"
                                                                        class="block w-full"
                                                                        style="border: 2px solid #000; border-radius: 6px; padding: 6px; font-size: 14px"
                                                                        required />
                                                                    <x-input-error :messages="$errors->get('decision')"
                                                                        class="mt-2" />
                                                                </div>

                                                                <div
                                                                    class="mt-4 mb-2 text-right d-flex justify-content-end">
                                                                    <button type="submit" id="send_btn"
                                                                        style="padding: 5px 30px; font-size: 13px; font-weight: 600; color: ghostwhite; text-transform: uppercase"
                                                                        class="btn apply-btn">Invalidate</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- </> modal -->

                                    </div>
                                </div>
                                <div style="border-top: none;" class="flex-section gap-5 p-3 card-footer">

                                    <div class="col-lg-7">
                                        @if(isset($dept))

                                            <form action="{{ route('update-dev-info') }}" method="post">@csrf
                                                @method('patch')

                                        @else

                                            <form action="{{ route('update-staff-info') }}" method="post">@csrf
                                                @method('patch')

                                        @endif

                                                <x-input-label style="font-size: 17px; font-weight: 600" for="name"
                                                    :value="__('Employee Info')" />
                                                <div class="info-div mt-3 mb-4">


                                                    <div class="d-flex gap-3">
                                                        <!-- Name -->
                                                        <div class="w-full">
                                                            <x-input-label for="names" :value="__('Names')" />
                                                            <input
                                                                style="padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 4px"
                                                                name="staff_id" class="block mt-1 w-full input-holder"
                                                                value="{{ $member->id }}" hidden />
                                                            <input
                                                                style="padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 4px"
                                                                name="names" class="block mt-1 w-full input-holder"
                                                                value="{{ $member->names }}" />
                                                            <x-input-error :messages="$errors->get('names')"
                                                                class="mt-2 text-left" />
                                                        </div>

                                                        <div class="w-full">
                                                            <x-input-label for="email" :value="__('Email')" />
                                                            <input
                                                                style="padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 4px"
                                                                name="email" class="block mt-1 w-full input-holder"
                                                                value="{{ $member->email }}" />
                                                            <x-input-error :messages="$errors->get('email')"
                                                                class="mt-2 text-left" />
                                                        </div>

                                                    </div>

                                                    <!-- Email Address -->
                                                    <div class="d-flex gap-3 mt-3">
                                                        <!-- Email here -->
                                                        <div class="w-full">
                                                            <x-input-label for="phone_number" :value="__('Phone number')" />
                                                            <input
                                                                style="padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 4px"
                                                                name="phone_number"
                                                                class="block mt-1 w-full input-holder"
                                                                value="{{ $member->phone_number }}" />
                                                        </div>

                                                        <div class="w-full">
                                                            <x-input-label for="email" :value="__('Work phone')" />
                                                            <input
                                                                style="padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 4px"
                                                                name="work_phone" class="block mt-1 w-full input-holder"
                                                                value="{{ $member->work_phone }}" />
                                                            <x-input-error :messages="$errors->get('work_phone')"
                                                                class="mt-2 text-left" />
                                                        </div>
                                                    </div>

                                                    <div class="flex-section gap-3 mt-3">

                                                        <div class="w-full">
                                                            <x-input-label for="department" :value="__('Department')" />
                                                            <select name="department_id" id="department"
                                                                class="w-full mt-1"
                                                                style="padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 4px">
                                                                @foreach ($departments as $department)
                                                                <option value="{{ $department->id }}" 
                                                                        {{ $member->department_id == $department->id || old('department_id') == $department->id ? 'selected' : '' }}>
                                                                        {{ $department->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <!-- Phone -->
                                                        <div class="w-full">
                                                            <x-input-label for="phone_number" :value="__('Role')" />
                                                            <input
                                                                style="padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 4px"
                                                                name="role" class="block mt-1 w-full input-holder"
                                                                value="{{ $member->role }}" />
                                                        </div>
                                                        @if ($member->department->name !== 'Development')
                                                            <div class="">
                                                                <x-input-label for="names" :value="__('Percentage (%)')" />
                                                                <input
                                                                    style="padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 4px"
                                                                    name="percentage" class="block mt-1 w-full input-holder"
                                                                    value="{{ $member->percentage }}" />
                                                                <x-input-error :messages="$errors->get('percentage')"
                                                                    class="mt-2 text-left" />
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if(Session::has('updated'))
                                                                                                        <div class="alert alert-success p-3 mt-3 alert-dismissible mb-0 mt-0 fade show d-flex align-items-center justify-content-between"
                                                                                                            style="font-size: 17px" role="alert">
                                                                                                            <div>
                                                                                                                {{ Session::get('updated') }}
                                                                                                            </div>
                                                                                                            <button type="button" class="close" data-dismiss="alert"
                                                                                                                aria-label="Close">
                                                                                                                <span aria-hidden="true" class="fa fa-times"
                                                                                                                    style="font-size: 18px"></span>
                                                                                                            </button>
                                                                                                        </div>
                                                                                                        @php
                                                                                                            Session::forget('updated');
                                                                                                        @endphp
                                                    @endif

                                                    @if(Session::has('error'))
                                                                                                        <div class="alert alert-danger mt-3 p-3 alert-dismissible mb-0 mt-0 fade show d-flex align-items-center justify-content-between"
                                                                                                            style="font-size: 17px" role="alert">
                                                                                                            <div>
                                                                                                                {{ Session::get('error') }}
                                                                                                            </div>
                                                                                                            <button type="button" class="close" data-dismiss="alert"
                                                                                                                aria-label="Close">
                                                                                                                <span aria-hidden="true" class="fa fa-times"
                                                                                                                    style="font-size: 18px"></span>
                                                                                                            </button>
                                                                                                        </div>
                                                                                                        @php
                                                                                                            Session::forget('error');
                                                                                                        @endphp
                                                    @endif

                                                    <div class="mt-4">
                                                        <x-primary-button class="apply-btn" style="border: none">
                                                            {{ __('Save changes') }}
                                                        </x-primary-button>
                                                    </div>

                                            </form>
                                    </div>

                                </div>

                                <div class="w-full">

                                    <section>
                                        <header>
                                            <h2 style="color: #000"
                                                class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                {{ __('Update Password') }}
                                            </h2>

                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                {{ __('Ensure the account is using a long, random password to stay secure.') }}
                                            </p>
                                        </header>

                                        @if(isset($dept))

                                            <form method="post" action="{{ route('dev.password.update') }}" class="mt-3">
                                                @csrf
                                                @method('put')

                                        @else

                                            <form method="post" action="{{ route('staff.password.update') }}"
                                                class="mt-3">
                                                @csrf
                                                @method('put')

                                        @endif

                                                <div>
                                                    <x-input-label for="current_password" :value="__('Current Password')" />
                                                    <x-text-input name="user_id" value="{{ $member->id }}" type="text"
                                                        style="padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 4px"
                                                        class="mt-1 block w-full" hidden />
                                                    <x-text-input id="current_password" name="current_password"
                                                        type="password"
                                                        style="padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 4px"
                                                        class="mt-1 block w-full" autocomplete="current-password" />
                                                    <x-input-error
                                                        :messages="$errors->updatePassword->get('current_password')"
                                                        class="mt-2 text-left" />
                                                </div>

                                                <div class="mt-3">
                                                    <x-input-label for="password" :value="__('New Password')" />
                                                    <x-text-input id="password" name="password" type="password"
                                                        style="padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 4px"
                                                        class="mt-1 block w-full" autocomplete="new-password" />
                                                    <x-input-error :messages="$errors->updatePassword->get('password')"
                                                        class="mt-2 text-left" />
                                                </div>

                                                <div class="mt-3">
                                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                                    <x-text-input id="password_confirmation"
                                                        name="password_confirmation"
                                                        style="padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 4px"
                                                        type="password" class="mt-1 block w-full"
                                                        autocomplete="new-password" />
                                                    <x-input-error
                                                        :messages="$errors->updatePassword->get('password_confirmation')"
                                                        class="mt-2 text-left" />
                                                </div>

                                                <div class="mt-4 flex items-center gap-4">
                                                    <x-primary-button class="apply-btn" style="border: none">
                                                        {{ __('change password') }}
                                                    </x-primary-button>

                                                    <small style="color: red">{{ Session::get('error') }}</small>
                                                    <small style="color: red">{{ Session::get('status') }}</small>

                                                    @if (session('status') === 'password-updated')
                                                        <p x-data="{ show: true }" x-show="show" x-transition
                                                            x-init="setTimeout(() => show = false, 2000)"
                                                            class="text-sm text-gray-600 dark:text-gray-400">
                                                            {{ __('Saved.') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </form>
                                    </section>


                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>


</x-app-layout>