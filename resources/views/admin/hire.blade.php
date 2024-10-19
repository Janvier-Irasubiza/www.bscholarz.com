@section('title', 'Application info')

<x-app-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 200px 32px 200px;">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2">

    <div class="container-fluid">
    <div class="card-header-tab card-header py-3 d-flex" style="border-bottom: 1px solid rgba(0, 0, 0, 0.192)">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                    Hire an Employee
                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">

                    <a style="font-weight: 500; border: 1.3px solid;" href="{{ route('admin.org') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                    View employees
                    </a>

                    </div>
                    </div>
                    <div class="px-5">
    <form method="post" action="{{ route('admin.hire-emp') }}" class="mt-6 px-5 space-y-6 mt-4 mb-3">
        @csrf

        <div>
            <x-input-label for="names" :value="__('Names')" />
            <small class="text-muted mb-0">Provide fullname</small>
            <x-text-input id="names" name="names" type="text" class="mt-1 block w-full" placeholder="Full name" :value="old('names')" required autocomplete="names" autofocus/>
            <x-input-error class="mt-2" :messages="$errors->get('names')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('email')" />
            <small class="text-muted mb-0">Email <small>(</small>authentication email<small>)</small></small>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" placeholder="Email"  :value="old('email')" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="phone_number" :value="__('Phone number')" />
            <small class="text-muted mb-0">Employee contact</small>
            <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" placeholder="Phone number" :value="old('phone_number')" required autocomplete="phone_number" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

      <div>
            <x-input-label for="phone_number" :value="__('Work Phone number')" />
            <small class="text-muted mb-0">Employee work contact</small>
            <x-text-input id="phone_number" name="work_phone" type="text" class="mt-1 block w-full" placeholder="Work Phone number" :value="old('work_phone')" required autocomplete="work_phone" />
            <x-input-error class="mt-2" :messages="$errors->get('work_phone')" />
        </div>

        <div>
            <x-input-label for="department" :value="__('Department')" />
            <small class="text-muted mb-0">Working department</small>
            <select name="department" id="department" class="mt-1 block w-full" onchange="togglePercentageField()">
                <option value="">-------------</option>
                <option value="Accountability" {{ old('accountability') == 'Accountability' ? 'selected' : '' }}>Accountability</option>
                <option value="Applications" {{ old('department') == 'Applications' ? 'selected' : '' }}>Applications</option>
                <option value="Marketing" {{ old('department') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('department')" />
        </div>

        <div>
            <x-input-label for="role" :value="__('Role')" />
            <small class="text-muted mb-0">Role</small>
            <x-text-input id="role" name="role" type="text" class="mt-1 block w-full" placeholder="Role" required autocomplete="role" :value="old('role')" />
            <x-input-error class="mt-2" :messages="$errors->get('role')" />
        </div>

        <!-- Percentage field -->
        <div id="percentageField" style="display:none;">
            <x-input-label for="percentage" :value="__('Percentage')" />
            <small class="text-muted mb-0">Percentage <small>(</small> % <small>)</small></small>
            <x-text-input id="percentage" name="percentage" type="text" class="mt-1 block w-full" placeholder="Percentage here..." :value="old('percentage')" autocomplete="percentage" />
            <x-input-error class="mt-2" :messages="$errors->get('percentage')" />
        </div>

        <script>
            function togglePercentageField() {
                const department = document.getElementById('department').value;
                const percentageField = document.getElementById('percentageField');
                const percentageInput = document.getElementById('percentage');

                if (department === 'Applications') {
                    percentageField.style.display = 'block';
                    percentageInput.setAttribute('required', 'required'); // Add required attribute
                } else {
                    percentageField.style.display = 'none';
                    percentageInput.removeAttribute('required'); // Remove required attribute
                }
            }

            // Run this function on page load to check if the department is already set
            window.onload = function() {
                togglePercentageField();
            };
        </script>



        <div>
            <x-input-label for="role" :value="__('Password')" />
            <small class="text-muted mb-0">Create password for the employee</small>
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" placeholder="********" required autocomplete="password" />
        </div>

        <div>
            <x-input-label for="role" :value="__('Confirm Password')" />
            <small class="text-muted mb-0">Confirm password</small>
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" placeholder="Re-type password" required autocomplete="password_confirmation" />

            <x-input-error class="mt-2" :messages="$errors->get('password')" />

            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />


        </div>

        <div class="flex items-center gap-4">
        <x-primary-button class="apply-btn" style="border: none">
                {{ __('hire employee') }}
            </x-primary-button>
        </div>
    </form>
    </div>
    </div>


    </div>
</div>

</x-app-layout>
