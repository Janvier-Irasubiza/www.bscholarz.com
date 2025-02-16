@section('title', 'Partners')

<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="chat-container flex bg-white">
        <div class="dashboard-container col-lg-12 px-5">
            <div class="d-flex justify-content-between align-items-center">
                <header class="dashboard-header text-left">
                    <h1>Partners</h1>
                    <p>All Bscholarz Partners</p>
                </header>
                <a href="{{ route('admin.partners.new') }}" class="continue-btn px-4 py-2 text-white">New Partner</a>
            </div>

            @if(Session::has('success'))
                        <div class="alert alert-success p-3 alert-dismissible mb-0 mt-0 fade show d-flex align-items-center justify-content-between"
                            style="font-size: 17px" role="alert">
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
                        <div class="alert alert-danger p-3 alert-dismissible mb-0 mt-0 fade show d-flex align-items-center justify-content-between"
                            style="font-size: 17px" role="alert">
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

            <div class="cards-container mt-5">
                <div class="border rounded-lg p-4 mb-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($partners as $partner)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="" style="width: 60px; height: 30px">
                                                <img src="{{ asset('profile_pictures/' . $partner->poster) }}" alt="">
                                                &nbsp;
                                            </div>
                                            <p>{{ $partner->name }}</p>
                                        </div>
                                    </td>
                                    <td>{{ $partner->email }}</td>
                                    <td>{{ $partner->phone }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $partner->status == 'active' ? 'bg-success' : 'bg-danger' }} rounded-pill px-3">
                                            {{ $partner->status }}
                                        </span>

                                        @if ($partner->status == 'active')
                                            <a href="{{ route('admin.partners.deactivate', ['partner' => $partner->id]) }}"
                                                class="text-danger">Deactivate</a>
                                        @else
                                            <a href="{{ route('admin.partners.activate', ['partner' => $partner->id]) }}"
                                                class="text-success">
                                                Activate
                                            </a>
                                        @endif

                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($partner->description, 20) }}</td>
                                    <td>
                                        <a href="{{ route('admin.partners.edit', ['partner' => $partner->uuid]) }}">Edit</a>
                                        &nbsp;
                                        <a href="{{ route('admin.partners.delete', ['partner' => $partner->id]) }}"
                                            class="text-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- <div class="pagination">
                        {{ $partners->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
