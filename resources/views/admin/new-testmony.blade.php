@section('title', 'Edit testmony')

<x-app-layout>

    <x-slot name="header">
        </slot>

        <div style="padding: 0px 60px 32px 60px;">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2">

                <div class="container-fluid">
                    <div class="card-header-tab card-header py-3 d-flex"
                        style="border-bottom: 1px solid rgba(0, 0, 0, 0.192); padding: 0px 90px 0px 90px;  ">
                        <div
                            class="card-header-title font-size-lg text-capitalize font-weight-normal d-flex align-items-center gap-3 col-lg-8">


                            <div>
                                <a href="{{ Auth::user() ? route('testimonies') : route('md.testimonies') }}"
                                    class="d-flex gap-1 align-items-center back-btn"> <span
                                        class="fa-solid fa-angle-left" style="font-size: 23px; color: #595959"></span>
                                    Testmonials</a>
                            </div>

                            <div>
                                New testmonial
                            </div>

                        </div>
                    </div>
                    <div class="px-5">
                        <form method="post"
                            action="{{ Auth::user() ? route('post-testmony') : route('md.post-testmony') }}"
                            class="mt-6 px-5 space-y-6 mt-4 mb-3" enctype="multipart/form-data">
                            @csrf

                            <x-input-label for="m_info" :value="__('Personal Info')" />
                            <div class="info-div mt-2 mb-4">

                                <div class="flex-section gap-5 align-items-center">
                                    <div>
                                        <img class="saying-pp-cst" src="{{ asset('images/profile.png') }}" id="output"
                                            alt="Profile">
                                        <div class="p-image" style="">
                                            <i class="fa fa-camera upload-button"></i>
                                            <input class="profile-file-input" style="" type="file" name="profile_image"
                                                accept="image/*" onchange="loadFile(event)" />
                                        </div>
                                    </div>

                                    <div class="w-full">
                                        <div>
                                            <x-input-label for="names" :value="__('Names')" />
                                            <small class="text-muted mb-0">Testfied by</small>
                                            <x-text-input id="names" name="names" type="text" class="mt-1 block w-full"
                                                :value="old('names')" placeholder="Full name" required />
                                            <x-input-error class="mt-2" :messages="$errors->get('names')" />
                                        </div>

                                        <div class="mt-3">
                                            <x-input-label for="email" :value="__('Phone Number')" />
                                            <small class="text-muted mb-0">Testfier Phone number</small>
                                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                                :value="old('phone')" placeholder="Phone number" required />
                                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                        </div>
                                    </div>
                                </div>

                                <x-input-error class="mt-2 text-left" :messages="$errors->get('profile_image')" />

                            </div>


                            <x-input-label for="m_info" :value="__('Testmony')" />
                            <div class="info-div mt-2 mb-4">
                                <div>
                                    <x-input-label for="department" :value="__('Theme')" />
                                    <small class="text-muted mb-0">Theme of the testmony</small>
                                    <x-text-input id="theme" name="theme" type="text" class="mt-1 block w-full"
                                        :value="old('theme')" placeholder="Theme" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('theme')" />
                                </div>

                                <div class="mt-3">
                                    <x-input-label for="role" :value="__('Subtitle')" />
                                    <small class="text-muted mb-0">Theme subtitle</small>
                                    <x-text-input id="subtitle" name="subtitle" type="text" class="mt-1 block w-full"
                                        required placeholder="Subtitle" :value="old('subtitle')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('subtitle')" />
                                </div>

                                <div class="mt-3">
                                    <x-input-label for="role" :value="__('Content')" />
                                    <small class="text-muted mb-0">Testmony full content</small>
                                    <textarea id="content" rows="5" name="content"
                                        style="height: max-content; border: 2px solid #000; border-radius: 6px; padding: 6px; font-size: 14px"
                                        type="text" class="mt-1 block w-full" required
                                        placeholder="Motivation Content">{{ old('content') }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('content')" />
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button class="apply-btn" style="border: none">
                                    {{ __('Post testmony') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>

        <script>

            var loadFile = function (event) {
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function () {
                    URL.revokeObjectURL(output.src) // free memory
                }
            };

        </script>

</x-app-layout>