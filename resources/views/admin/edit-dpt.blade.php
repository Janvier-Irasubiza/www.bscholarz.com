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
                    <div>
                    <h1 style="font-size: 1.4em">{{ $dpt->name }}</h1>
                    <p class="text-muted mt-1" style="font-size: 1.1em">{{ $dpt->status }}</p>
                    </div>
                </div>
                @if ($dpt->status != 'active')
                    <a href="{{ route('dpt.open', ['dpt' => $dpt->id]) }}" class="text-success"
                        style="font-size: 1.2em">Activate</a>
                @endif
                @if ($dpt->status == 'active')
                    <a href="{{ route('dpt.close', ['dpt' => $dpt->id]) }}" class="text-danger"
                        style="font-size: 1.2em">De-activate</a>
                @endif
            </div>

            <div class="rounded-lg p-3">
                <form action="{{ route('dpt.update', ['dpt' => $dpt->id]) }}" method="post">
                    @csrf
                    <div>
                        <label for="name">Department Name</label>
                        <input type="text" name="name" id="name" class="w-full p-2"
                            value="{{ old('name', $dpt->name) }}" placeholder="Enter department name" autofocus required
                            autocorrect autocomplete="name">
                        <x-input-error :messages="$errors->get('name')" class="mb-3 text-left text-danger" />
                    </div>

                    <div class="mt-3">
                        <label for="description">Responsibilities</label>
                        <textarea name="description" rows="2" placeholder="List inlcuded responsabilities"
                            class="chat-input w-full p-2" required autocorrect
                            autocomplete="description">{{ old('description', $dpt->description) }}</textarea>

                        <x-input-error :messages="$errors->get('description')" class="mb-3 text-left text-danger" />
                    </div>

                    <button type="submit" class="cst-primary-btn px-5 py-2 w-full mt-4">Save Changes</button>
                </form>
            </div>

        </div>
    </div>
    </div>
</x-app-layout>