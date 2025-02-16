@section('title', 'On going applications')

<x-app-layout>

    <x-slot name="header">
    </x-slot>

    <div style="padding: 0px 20px 32px 20px">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2">
            <div class="app-inner-layout__content">
                <div class="tab-content">
                    <div>
                        <div class="card">
                            <div class="card-header-tab card-header py-3 d-flex">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-6">
                                    Applications
                                </div>
                                <div class="btn-actions-pane-right text-capitalize text-right col-lg-6">
                                    @if(Auth::user())
                                        <a href="{{ route('admin.requests') }}"
                                            class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn"
                                            style="font-weight: 600; border: 1.3px solid;">
                                            View Clients requests
                                        </a>
                                    @endif
                                    <a href="{{ Auth::user() ? route('admin.new-application') : route('md.new-application') }}"
                                        class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-primary">
                                        <span class="mr-2 opacity-7">
                                            <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                                        </span>
                                        <span class="mr-1">New application</span>
                                    </a>
                                </div>
                            </div>
                            <div style="border-top: none" class="d-block p-3 card-footer">
                                <form action="" method="get">
                                    {{-- <div class="d-flex gap-2">
                                        <input type="text" name="app" id="" placeholder="Search by application name"
                                            value="{{ request('app') }}">
                                        <button
                                            class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-primary px-4">Search</button>
                                    </div> --}}
                                </form>
                                <table id="example1" class="table align-middle mb-0 bg-white mt-4" width="100%" cellspacing="0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Application</th>
                                            <th>Category</th>
                                            <th>Country</th>
                                            <th class="text-center">Review</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($applications as $discipline)
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div>
                                                                                            <p class="fw-bold mb-1">{{ $discipline->discipline_name }}</p>
                                                                                            <p class="text-muted mb-0" style="font-size: 13px">
                                                                                                {{ $discipline->organization }}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <p class="fw-normal mb-1">{{ $discipline->category }}</p>
                                                                                </td>
                                                                                <td>
                                                                                    <p class="fw-normal mb-1">{{ $discipline->country }}</p>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <a href="{{ Auth::user()
                                            ? route('admin.app-info', ['identifier' => $discipline->identifier])
                                            : route('md.app-info', ['identifier' => $discipline->identifier]) }}"
                                                                                        class="btn btn-link btn-sm btn-rounded mr-1"
                                                                                        style="border: 2px solid; border-radius: 10px; padding: 2px 10px;">
                                                                                        Review
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- <!-- Pagination Links -->
                                <div class="mt-3 custom-pagination">
                                    {{ $applications->links() }}
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const removeFileBtn = document.getElementById("removeFile");

            function PreviewFile() {
                document.getElementById("uploadPreview").value = document.getElementById("uploadFile").value.match(/[\/\\]([\w\d\s\.\-\(/)]+)$/)[1];
            };

            function removeFileShow() {
                removeFileBtn.style.display = "block";
            };

            function removeFileFun() {
                document.getElementById("uploadFile").value = null;
                document.getElementById("uploadPreview").value = "Select Document";
                removeFileBtn.style.display = "none";
            }

            function exc() {
                PreviewFile();
                removeFileShow();
            }
        </script>

    </div>

</x-app-layout>
