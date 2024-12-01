@section('title', 'Support')

<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="chat-container flex bg-white">
        <div class="dashboard-container col-lg-10 px-5">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex gap-5 align-items-center">
                    <a href="{{ route('admin.departments') }}">
                        <i class="fa-solid fa-arrow-left"></i> Back
                    </a>
                    <h1 style="font-size: 1.6em">New Department</h1>
                </div>

            </div>

            <div class="rounded-lg p-3 mt-3">
                <form action="{{ route('dpt.create') }}" method="post">
                    @csrf
                    <div>
                        <label for="name">Department Name</label>
                        <input type="text" name="name" id="name" class="w-full p-2" value="{{ old('name') }}"
                            placeholder="Enter department name" autofocus required autocorrect autocomplete="name">
                        <x-input-error :messages="$errors->get('name')" class="mb-3 text-left text-danger" />
                    </div>

                    <div class="mt-3">
                        <label for="description">Responsibilities</label>
                        <textarea name="description" rows="2" placeholder="List inlcuded responsabilities"
                            class="chat-input w-full p-2" required autocorrect
                            autocomplete="description">{{ old('description') }}</textarea>

                        <x-input-error :messages="$errors->get('description')" class="mb-3 text-left text-danger" />
                    </div>

                    <button type="submit" class="cst-primary-btn px-5 py-2 w-full mt-4">Create Department</button>
                </form>
            </div>

        </div>
    </div>
    </div>
</x-app-layout>