<nav x-data="{ open: false }" class="border-b w-8" style="background-color: #DEE8F7;">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="d-flex align-items-left">

                <!-- Navigation Links -->
                <div class="d-flex align-items-center">

                    <!-- Adimin -->
                    @if(Auth::guard('staff')->user()->type == 'admin')
                        <h6 style="font-weight: 600">Administration</h6>
                    <!-- this is for the accounting department -->
                    @else
                        <h6 style="font-weight: 600">{{ Auth::guard('staff')->user()->department->name }}</h6>
                    @endif

                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 gap-5 align-items-center">

                @if(auth('staff')->user()->type == 'admin')
                    <a href="{{ route('web.content') }}" class="underline" style="font-size: 1.1em">Website Content</a>
                @endif

                <a href="{{ route('chats.index') }}" class="">
                    <i class="fa-brands fa-rocketchat" style="font-size: 25px;"></i>
                    @if ($nots > 0)
                        <span class="badge badge-light nots">{{ $nots }}</span>
                    @endif
                </a>

            
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button style="border: 2px solid #1b1b1bc4" class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div style="color: #1b1b1b">
                        @if(Auth::user())

                        {{ Auth::user() -> name }}

                        @else

                        {{ Auth::guard('staff') -> user()->names }}

                        @endif
                        </div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                    @if(Auth::user())

                        <x-dropdown-link style="color: #1b1b1b;" class="drop-btn" :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link style="color: #1b1b1b" class="drop-btn" :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>

                        @elseif(Auth::guard('staff')->check() && Auth::guard('staff')->user()->department == 'Marketing')

                        <x-dropdown-link style="color: #1b1b1b;" class="drop-btn" :href="route('md.profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <a style="color: #1b1b1b;" class="drop-btn block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-500 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out" href="{{ route('staff.logout') }}">
                                Log Out
                            </a>

                        @elseif(Auth::guard('staff'))

                        <x-dropdown-link style="color: #1b1b1b;" class="drop-btn" :href="route('staff.profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <a style="color: #1b1b1b;" class="drop-btn block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-500 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out" href="{{ route('staff.logout') }}">
                                Log Out
                            </a>

                        @else

                        <a style="color: #1b1b1b;" class="drop-btn block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-500 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out" href="{{ route('staff.logout') }}">
                                Log Out
                            </a>

                        @endif


                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                @if(Auth::user())

                    {{ Auth::user() -> name }}

                @else

                    {{ Auth::guard('staff') -> user()->names }}

                @endif
            </div>
                <div class="font-medium text-sm text-gray-500">
                    @if(Auth::user())

                        {{ Auth::user() -> name }}  

                    @else

                        {{ Auth::guard('staff') -> user()->email }}

                    @endif
                </div>
            </div>

            <div class="mt-3 space-y-1">


            @if(Auth::user())

                {{ Auth::user() -> name }}

                    <x-responsive-nav-link style="border: 1px solid" :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                @endif

                @if(Auth::user())

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                            this.closest('form').submit();">
                                {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>

                @else

                    <a style="color: #cc0000; font-weight: 600" class="drop-btn block w-full px-3 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-500 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out" href="{{ route('staff.logout') }}">
                        Log Out
                    </a>

                @endif

                
            </div>
        </div>
    </div>
</nav>
