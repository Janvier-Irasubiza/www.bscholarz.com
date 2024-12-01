<nav x-data="{ open: false }" class="border-bottom w-full" style="position: relative;">
    <!-- Primary Navigation Menu -->
    <div class="d-nav d-flex align-items-center">
        <div class="flex justify-between nav-content w-full">
            <div class="d-flex align-items-left">

                <!-- Navigation Links -->
                <div class="d-flex align-items-center">
                    <a style="font-size: 1.6em; color: unset !important;" href="{{ route('client.client-dashboard') }}">Dashboard</a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button style="" class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div class="d-flex align-items-center gap-2" style="color: #1b1b1b">

                           <span style="font-size: 1.3em"> {{ Auth::guard('client') -> user()->names }} </span>
                            
                            <div class="user-profile p-0 m-0" style="height: 40px; width: 40px; padding: 0px">

                            @if(!is_null(Auth::guard('client') -> user() -> profile_picture))
                                <img id="uploadPreview" class="profile-pic-cstm m-0 p-0" src="{{ asset('profile_pictures') }}/{{ Auth::guard('client') -> user() -> profile_picture }}">
                            @else

                            <img src="{{ asset('images/profile.png') }}" alt="User-Account">

                            @endif

                        </div>
                        </div>

                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link style="color: #1b1b1b;" class="drop-btn" :href="route('client-profile')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <a style="color: #1b1b1b;" class="drop-btn block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-500 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out" href="{{ route('client.logout') }}">
                                Log Out
                            </a>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <div class="user-profile" style="height: 30px; width: 30px">

                        @if(!is_null(Auth::guard('client') -> user() -> profile_picture))
                        <img id="uploadPreview" class="profile-pic" src="{{ asset('profile_pictures') }}/{{ Auth::guard('client') -> user() -> profile_picture }}">
                        @else

                        <img src="{{ asset('images/profile.png') }}" alt="User-Account">

                        @endif

                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <!-- Responsive Settings Options -->
        <div class="pb-1 mt-2" style="border-top: 1px solid rgba(0, 0, 0, 0.151);">
            <div class="px-2">
                        
                <div class="d-flex justify-content-center align-items-center mb-4 py-3" style="border-bottom: 1px solid rgba(0, 0, 0, 0.151)">
    
    <div class="personal-info col-lg-12" style="background: none">
    
    <div class="d-flex justify-between" style="">
        <div class="small-8 medium-2 large-2 columns img-section col-lg-2 pt-2">
            <div class="circle">
            @if(!is_null(Auth::guard('client') -> user() -> profile_picture))
            <img id="uploadPreview" class="profile-pic" src="{{ asset('profile_pictures') }}/{{ Auth::guard('client') -> user() -> profile_picture }}">
            @else
            <img id="uploadPreview" class="profile-pic" src="{{ asset('profile_pictures') }}/profileee.png">
            @endif
            </div>
        </div>


        <div class="col-lg-10 cstm-info-hold-details">
        <div>
        <div style=""><strong><h1 class="user-names" style="display: flex; justify-content: right">{{ Auth::guard('client') -> user() -> names }}</h1></strong></div>
            <div style="font-size: 19px; display: flex; justify-content: right"><h5>{{ Auth::guard('client') -> user() -> email }}</h5></div>
        </div>
        </div>

    </div>
    <div class="mb-1" style="font-size: 18px; display: flex; justify-content: right"><h5 style="margin-top: -5px"><a href="{{ route('client-profile') }}" style="text-decoration: underline">Edit profile</a></h5></div>

    </div>

                
                </div>

            <div style="border: 2px solid #cc0000; border-radius: 4px; margin-top: -10px">
                <!-- Authentication -->
                <a style="color: #cc0000; font-weight: 600" class="drop-btn block w-full px-3 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-500 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out" href="{{ route('client.logout') }}">
                                Log Out
                            </a>
            </div>
        </div>
    </div>
</nav>
