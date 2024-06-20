<nav x-data="{ open: false }" class="cst-navigation-bar border-b w-full">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between h-16">
            <div class="d-flex align-items-left">

                <!-- Navigation Links -->
                <div class="d-flex align-items-center gap-1">
                    <a class="nav-buttons" href="{{ route('rhythmbox.dashboard') }}">Dashboard</a>
                    <a class="nav-buttons" href="{{ route('rhythmbox.records') }}">Organization</a>
                    <a class="nav-buttons" href="{{ route('rhythmbox.admin') }}">System Overview</a>
                    <a class="nav-buttons" href="{{ route('rhythmbox.recycle') }}">Recycle Bin</a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">

                    


                        <button style="border: 2px solid #1b1b1bc4" class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div style="color: #1b1b1b">

                            {{ Auth::guard('rhythmbox') -> user() -> names }}
                            
                        </div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link style="color: #1b1b1b;" class="drop-btn" :href="route('rhythm.profile')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                      
                      <x-dropdown-link style="color: #1b1b1b;" class="drop-btn" :href="route('rhythm.disbursements')">
                            {{ __('Disbursements') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                            <a style="color: #1b1b1b;" class="drop-btn block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-500 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out" href="{{ route('rhythmbox.logout') }}">
                                Log Out
                            </a>
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
            
            <a class="nav-buttons" href="{{ route('rhythmbox.dashboard') }}">Dashboard</a>
            <a class="nav-buttons" href="{{ route('rhythmbox.records') }}">Organization</a>
            <a class="nav-buttons" href="{{ route('rhythmbox.recycle') }}">Recycle Bin</a>
          

        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">

                            {{ Auth::guard('rhythmbox') -> user() -> names }}

                
            </div>
                <div class="font-medium text-sm text-gray-500">

                        {{ Auth::guard('rhythmbox') -> user() -> email }}
                
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link style="border: 1px solid" :href="route('rhythm.profile')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->

                    <x-responsive-nav-link :href="route('rhythmbox.logout')" >
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
            </div>
        </div>
    </div>
</nav>
