<div class="sidebar">

    <!-- Logo -->
    <div class="shrink-0 flex items-center justify-content-center py-4" style="">
        <a href="{{ route('staff-dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </a>

        <h1 class="ml-0" style="">BScholarz</h1>

    </div>

    <div style="border-top: 1px solid rgba(0, 0, 0, 0.096); padding: 20px 0px 20px 40px;">

        <div class="d-flex align-items-center mb-4">
            <h6><strong>BScholarz Staff</strong></h6>
        </div>

        <ul>
            <li class="sb-li" style="border-bottom: 1px solid rgba(0, 0, 0, 0.096); margin: 0px">
                <a href="{{ route('staff-dashboard') }}" class="sd-bar-link">
                    <div class="flex" style="">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-house" style="font-size: 14px; margin-top: 1px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>Dashboard</h5>
                        </div>
                    </div>
                </a>
            </li>

            <li class="sb-li" style="border-bottom: 1px solid rgba(0, 0, 0, 0.096); margin: 0px">
                <a href="{{ route('sort-recs-this-week') }}" class="sd-bar-link">
                    <div class="flex" style="">
                        <div class="d-flex align-items-center">
                            <i class="fa-regular fa-pen-to-square"
                                style="font-size: 16px; font-weight: 600; margin-top: 1px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>My Work Sheet</h5>
                        </div>
                    </div>
                </a>
            </li>

            <li class="sb-li" style="border-bottom: 1px solid rgba(0, 0, 0, 0.096); margin: 0px">
                <a href="{{ route('my.appointments') }}" class="sd-bar-link">
                    <div class="flex" style="">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-people-arrows"
                                style="font-size: 16px; font-weight: 600; margin-top: 1px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>My Appointments</h5>
                        </div>
                    </div>
                </a>
            </li>

            <li class="sb-li" style="border-bottom: 1px solid rgba(0, 0, 0, 0.096); margin: 0px">
                <a href="{{ route('my.comments') }}" class="sd-bar-link">
                    <div class="flex" style="">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-comment"
                                style="font-size: 16px; font-weight: 600; margin-top: 1px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content flex align-items-center gap-2" style="text-align: left">
                            <h5>Recommended Comments</h5>
                            @if ($recommendedComments && $recommendedComments > 0)
                                <i class="fa-solid fa-circle mt-1" style="font-size: 0.4em; color: #ec6c55bd"></i>
                            @endif
                        </div>
                    </div>
                </a>
            </li>
        </ul>

    </div>

    <div class="footer w-full">


        <div style="padding: 0px 43px">
            <a href="{{ route('assistance-requests') }}">Assistance requests</a>
        </div>


        <div class="d-flex justify-content-center w-full" style="">
            <div style="border-top: 1px solid rgba(0, 0, 0, 0.096); padding: 20px 30px" class="row container-fluid">
                <div class="col-lg-6" style="font-size: 13px">
                    &copy; 2023 <strong>BScholarz</strong>
                </div>

                <div style="" class="col-lg-6">
                    <p style="margin-bottom: 0px; text-align: right; font-size: 13px"><i class="fa-solid fa-code"></i>
                        &nbsp;<strong>RB-A</strong></p>
                </div>

            </div>
        </div>
    </div>

</div>
