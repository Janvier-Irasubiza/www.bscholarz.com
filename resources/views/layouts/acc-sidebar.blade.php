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
                        <h6 style="font-weight: 600">Accountability</h6>
                    </div>

            <ul class="sb-ul">
                <li class="sb-li" style=" margin: 0px">
                    <a href="{{ route('dashboard') }}" class="sd-bar-link" >
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
                    <a href="{{ route('pending-transactions') }}" class="sd-bar-link" >
                    <div class="flex" style="">
                        <div class="d-flex align-items-center mr-1">
                            <i class="fa-solid fa-money-bill-wave" style="font-size: 15px; margin-top: 2px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>Pending Transactions</h5>
                        </div>
                    </div>
                </a>
                </li>

                <li class="sb-li" style=" margin: 0px">
                    <a href="{{ route('complete-transactions') }}" class="sd-bar-link" >
                    <div class="flex" style="">
                        <div class="d-flex align-items-center mr-1">
                            <i class="fa-solid fa-comments-dollar" style="font-size: 15px; margin-top: 2px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>Complete Transactions</h5>
                        </div>
                    </div>
                </a>
                </li>

                <li class="sb-li" style=" margin: 0px">
                    <a href="{{ route('accountant-deptors') }}" class="sd-bar-link" >
                    <div class="flex" style="">
                        <div class="d-flex align-items-center mr-1">
                            <i class="fa-solid fa-comments-dollar" style="font-size: 15px; margin-top: 2px; color: #000000a8"></i>
                        </div>

                        <div class="trend-content" style="text-align: left">
                            <h5>Pending Payments</h5>
                        </div>
                    </div>
                </a>
                </li>

            </ul>

        </div>

        <div class="footer w-full">

                <div class="d-flex justify-content-center w-full" style="">

                    <div style="border-top: 1px solid rgba(0, 0, 0, 0.096); padding: 20px 20px" class="row container-fluid">
                        <div class="col-lg-6" style="font-size: 13px">
                            &copy; 2023 <strong>BScholarz</strong>
                        </div>

                        <div style="" class="col-lg-6">
                            <p style="margin-bottom: 0px; text-align: right; font-size: 13px"><i class="fa-solid fa-code"></i> &nbsp;<strong>RB-A</strong></p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
