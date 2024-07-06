<div class="flex-section justify-content-center col-lg-12">
                <div style="border-top: 1px solid #a8a3a3; padding: 20px 0px" class="mt-3 d-flex justify-content-between container">
                    <div class="" style="font-size: 13px">
                        &copy; 2023 <strong>BScholarz</strong> 
                    </div>  

                    <div class="">
                        <button id="contactButton" style="margin-bottom: 0px; text-align: right; font-size: 13px"><i class="fa-solid fa-code"></i> &nbsp;<strong>RB-A</strong></button> 
                    </div> 
                </div>
            </div>

            <div id="popup" class="popup p-4 border col-md-6 bg-gray-200">
                <div class="d-flex justify-content-between">
                    <h3 class="text-gray-600">RhythmBox Associations</h3>
                    <button id="closePopup" class="b-none bg-none">Close</button>
                </div>
                <div class="mt-4 flex-section gap-3">
                   <div class="col-md-4 border-r mb-8">
                   <h4 class="text-gray-600 text-center">Contact</h4>
                   <div class="mt-6">        

                        <p class="text-center">
                            <i class="fa-solid fa-phone f-25"></i>
                        </p>
                        <p class="text-gray-600 text-center mt-2">
                            <a href="tel:+250781336634">+250 781 336 634</a>
                        </p>
                        </div>
                        <div class="mt-6">
                        <p class="text-center">
                            <i class="fa-solid fa-phone f-25"></i>
                        </p>
                        <p class="text-gray-600 text-center mt-2">
                            <a href="tel:+250780478405">+250 780 478 405</a>
                        </p>
                    </div>

                    <div class="mt-6">
                        <p class="text-center">
                            <i class="fa-solid fa-envelope f-25"></i>
                        </p>
                        <p class="text-gray-600 text-center mt-2">arhythmbox@gmail.com</p>
                    </div>

                   </div>
                   <div class="w-full">
                   <h4 class="text-gray-600">Send us a message</h4>
                    <form action="{{ route('send.email') }}" method="POST" class="mt-3" id="contactForm"> @csrf
                        <div>
                            <x-input-label for="name" class="f-14" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="How can we address you?" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-3">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" placeholder="Email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- phone number -->
                        <div class="mt-3">
                            <x-input-label for="phone" :value="__('Message')" />
                            <textarea id="request" class="block mt-1 w-full border-gray rounded p-2" name="request" required placeholder="Message">{{ old('requests') }}</textarea>
                            <x-input-error :messages="$errors->get('request')" class="mt-2" />
                        </div>

                        <div id="messageDiv" class="mt-3"></div>

                        <div class="mt-6 d-flex align-items-center justify-content-between">

                            <button class="lara-btn">
                                {{ __('Send message') }}
                            </button>
                        </div>
                    </form>
                   </div>
                </div>
            </div>