@section('title', 'Website content')

<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="chat-container flex bg-white">
        <div class="dashboard-container col-lg-12 px-5">
            <div class="d-flex gap-5 align-items-center mb-3">
                <div class="text-left">
                    <h1 style="font-size: 2em">BScholarz</h1>
                    <p class="muted-text">Website Content</p>
                </div>
            </div>

            @if(Session::has('success'))
                <div class="alert alert-success p-3 alert-dismissible mb-0 mt-0 fade show d-flex align-items-center justify-content-between" style="font-size: 17px" role="alert">
                    <div>
                        {{ Session::get('success') }}
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="fa fa-times" style="font-size: 18px"></span>
                    </button>
                </div>
                @php
                    Session::forget('success');
                @endphp
            @endif

            @if(Session::has('error'))
                <div class="alert alert-danger p-3 alert-dismissible mb-0 mt-0 fade show d-flex align-items-center justify-content-between" style="font-size: 17px" role="alert">
                    <div>
                        {{ Session::get('error') }}
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="fa fa-times" style="font-size: 18px"></span>
                    </button>
                </div>
                @php
                    Session::forget('error');
                @endphp
            @endif

            <div class="cards-container">
                <div class="rounded-lg mt-5 mb-3">
                    @if($content)
                        <form action="{{ route('web.content.upadte') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="">
                                <label for="name" class="w-full">Description</label>
                                <input type="text" name="id" value="{{ $content->id }}" hidden>
                                <textarea rows="10" id="description" name="description" class="textarea mt-1 block w-full" required autocomplete="description">{{ old('description', $content->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mb-3 text-left text-danger" />
                            </div>
                            <div class="mt-4">
                                <label for="email" class="w-full">Objectives</label>
                                <textarea rows="10" id="objectives" name="objectives" class="textarea mt-1 block w-full" required autocomplete="objectives">{{ old('objectives', $content->objectives) }}</textarea>
                                <x-input-error :messages="$errors->get('objectives')" class="mb-3 text-left text-danger" />
                            </div>
                            <div class="mt-4">
                                <label for="phone" class="w-full">Services</label>
                                <textarea rows="10" id="services" name="services" class="textarea mt-1 block w-full" required autocomplete="services">{{ old('services', $content->services) }}</textarea>
                                <x-input-error :messages="$errors->get('services')" class="mb-3 text-left text-danger" />
                            </div>
                            <div class="mt-4">
                                <label for="vision" class="w-full">Vision</label>
                                <textarea rows="10" id="vision" name="vision" class="textarea mt-1 block w-full" required autocomplete="vision">{{ old('vision', $content->vision) }}</textarea>
                                <x-input-error :messages="$errors->get('vision')" class="mb-3 text-left text-danger" />
                            </div>
                            <div class="mt-4">
                                <label for="mission" class="w-full">Mission</label>
                                <textarea rows="10" id="mission" name="mission" class="textarea mt-1 block w-full" required autocomplete="mission">{{ old('mission', $content->mission) }}</textarea>
                                <x-input-error :messages="$errors->get('mission')" class="mb-3 text-left text-danger" />
                            </div>
                            <div class="mt-4">
                                <label for="goals" class="w-full">Goals</label>
                                <textarea rows="10" id="goals" name="goals" class="textarea mt-1 block w-full" required autocomplete="goals">{{ old('goals', $content->goals) }}</textarea>
                                <x-input-error :messages="$errors->get('goals')" class="mb-3 text-left text-danger" />
                            </div>
                            <div class="mt-4">
                                <label for="values" class="w-full">Values</label>
                                <textarea rows="10" id="values" name="values" class="textarea mt-1 block w-full" required autocomplete="values">{{ old('values', $content->values) }}</textarea>
                                <x-input-error :messages="$errors->get('values')" class="mb-3 text-left text-danger" />
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="cst-primary-btn px-5 py-2 mt-4">Save Changes</button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning p-3 alert-dismissible mb-0 mt-0 fade show" style="font-size: 17px" role="alert">
                            <strong>No content found!</strong> Please create content to fill in the website details.
                        </div>
                        <form action="{{ route('web.content.upadte') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="">
                                <label for="name" class="w-full">Description</label>
                                <textarea rows="10" id="description" name="description" class="textarea mt-1 block w-full" required autocomplete="description">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mb-3 text-left text-danger" />
                            </div>
                            <div class="mt-4">
                                <label for="email" class="w-full">Objectives</label>
                                <textarea rows="10" id="objectives" name="objectives" class="textarea mt-1 block w-full" required autocomplete="objectives">{{ old('objectives') }}</textarea>
                                <x-input-error :messages="$errors->get('objectives')" class="mb-3 text-left text-danger" />
                            </div>
                            <div class="mt-4">
                                <label for="phone" class="w-full">Services</label>
                                <textarea rows="10" id="services" name="services" class="textarea mt-1 block w-full" required autocomplete="services">{{ old('services') }}</textarea>
                                <x-input-error :messages="$errors->get('services')" class="mb-3 text-left text-danger" />
                            </div>
                            <div class="mt-4">
                                <label for="vision" class="w-full">Vision</label>
                                <textarea rows="10" id="vision" name="vision" class="textarea mt-1 block w-full" required autocomplete="vision">{{ old('vision') }}</textarea>
                                <x-input-error :messages="$errors->get('vision')" class="mb-3 text-left text-danger" />
                            </div>
                            <div class="mt-4">
                                <label for="mission" class="w-full">Mission</label>
                                <textarea rows="10" id="mission" name="mission" class="textarea mt-1 block w-full" required autocomplete="mission">{{ old('mission') }}</textarea>
                                <x-input-error :messages="$errors->get('mission')" class="mb-3 text-left text-danger" />
                            </div>
                            <div class="mt-4">
                                <label for="goals" class="w-full">Goals</label>
                                <textarea rows="10" id="goals" name="goals" class="textarea mt-1 block w-full" required autocomplete="goals">{{ old('goals') }}</textarea>
                                <x-input-error :messages="$errors->get('goals')" class="mb-3 text-left text-danger" />
                            </div>
                            <div class="mt-4">
                                <label for="values" class="w-full">Values</label>
                                <textarea rows="10" id="values" name="values" class="textarea mt-1 block w-full" required autocomplete="values">{{ old('values') }}</textarea>
                                <x-input-error :messages="$errors->get('values')" class="mb-3 text-left text-danger" />
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="cst-primary-btn px-5 py-2 mt-4">Save Changes</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
