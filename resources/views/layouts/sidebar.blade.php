<div class="sidebar">
    <!-- Logo -->
    <div class="shrink-0 flex items-center justify-content-center py-4">
        <a href="{{ route('admin.dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </a>
        <h1 class="ml-3">BScholarz</h1>
    </div>

    <div style="border-top: 1px solid rgba(0, 0, 0, 0.096); padding: 20px 0px 20px 40px;">

        <div class="d-flex align-items-center mb-4">
            <h6 style="font-weight: 600">Administration</h6>
        </div>

        <ul class="sb-ul">
            <li class="sb-li" style=" margin: 0px">
                <a href="{{ route('admin.dashboard') }}" class="sd-bar-link">
                    <div class="flex" style="">
                        <div class="d-flex align-items-center mr-1">
                            <i class="fa-solid fa-house" style="font-size: 14px; margin-top: 0px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>Dashboard</h5>
                        </div>
                    </div>
                </a>
            </li>

            <li class="sb-li" style=" margin: 0px">
                <a href="{{ route('admin.requests') }}" class="sd-bar-link">
                    <div class="flex" style="">
                        <div class="d-flex align-items-center mr-1">
                            <i class="fa-solid fa-person-booth"
                                style="font-size: 15px; margin-top: 2px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>Requests</h5>
                        </div>
                    </div>
                </a>
            </li>

            <li class="sb-li" style=" margin: 0px">
                <a href="{{ route('admin.applications') }}" class="sd-bar-link">
                    <div class="flex" style="">
                        <div class="d-flex align-items-center mr-1">
                            <i class="fa-solid fa-layer-group"
                                style="font-size: 15px; margin-top: 2px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>Services</h5>
                        </div>
                    </div>
                </a>
            </li>

            <li class="sb-li" style="margin: 0px">
                <a href="{{ route('admin.ads') }}" class="sd-bar-link">
                    <div class="flex" style="">
                        <div class="d-flex align-items-center mr-1">
                            <i class="fa-solid fa-ad" style="font-size: 15px; margin-top: 2px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>Ads</h5>
                        </div>
                    </div>
                </a>
            </li>

            <li class="sb-li" style=" margin: 0px">
                <a href="{{ route('admin.revenue') }}" class="sd-bar-link">
                    <div class="flex" style="">
                        <div class="d-flex align-items-center mr-1">
                            <i class="fa-solid fa-sack-dollar"
                                style="font-size: 15px; margin-top: 1px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>Revenue</h5>
                        </div>
                    </div>
                </a>
            </li>

            <li class="sb-li" style="margin: 0px">
                <a href="{{ route('admin.departments') }}" class="sd-bar-link">
                    <div class="flex" style="">
                        <div class="d-flex align-items-center mr-1">
                            <i class="fa-solid fa-layer-group"
                                style="font-size: 18px; margin-top: 2px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>Departments</h5>
                        </div>
                    </div>
                </a>
            </li>

            <li class="sb-li" style="margin: 0px">
                <a href="{{ route('admin.org') }}" class="sd-bar-link">
                    <div class="flex" style="">
                        <div class="d-flex align-items-center mr-1">
                            <i class="fa-solid fa-person-digging"
                                style="font-size: 18px; margin-top: 2px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>Employees</h5>
                        </div>
                    </div>
                </a>
            </li>

            <li class="sb-li" style="margin: 0px">
                <a href="{{ route('admin.parteners') }}" class="sd-bar-link">
                    <div class="flex" style="">
                        <div class="d-flex align-items-center mr-1">
                            <i class="fa-solid fa-handshake"
                                style="font-size: 18px; margin-top: 2px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>Partners</h5>
                        </div>
                    </div>
                </a>
            </li>


            <li class="sb-li" style="margin: 0px">
                <a href="{{ route('admin.com') }}" class="sd-bar-link">
                    <div class="flex" style="">
                        <div class="d-flex align-items-center mr-1">
                            <i class="fa-solid fa-users" style="font-size: 15px; margin-top: 2px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>Community</h5>
                        </div>
                    </div>
                </a>
            </li>

            <li class="sb-li" style="margin: 0px">
                <a href="{{ route('recycle') }}" class="sd-bar-link">
                    <div class="flex" style="">
                        <div class="d-flex align-items-center mr-1">
                            <i class="fa-solid fa-trash-can"
                                style="font-size: 15px; margin-top: 2px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>Recycle Bin</h5>
                        </div>
                    </div>
                </a>
            </li>
            

        </ul>

    </div>

    <div class="footer w-full py-2  ">

        <div class="d-flex gap-5 px-5">

            <div>
                <a href="{{ route('faqs') }}">FAQs</a>
            </div>

            <div>
                <a href="{{ route('testimonies') }}"> Testimonials </a>
            </div>

        </div>
    </div>

</div>