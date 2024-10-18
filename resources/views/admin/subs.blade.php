@section('title', 'Subscriptions')

<x-app-layout>

<x-slot name="header">
</slot>

    <div style="padding: 0px 20px 32px 20px">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-4">
            <h1 class="f-20 f-600">Subscriptions</h1>
            
            @include('components.subs-nav')

            <div class="bg-gray p-3 subs-radius">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="f-18 f-500">Basic Subscriptions</h1>
                    <a href="" class="btn btn-primary">Download</a>
                </div>
                <table id="example1" class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">
                        <tr>
                        <th>Client</th>
                        <th>Joined on</th>
                        <th>Plan duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="ms-3">
                                    <p class="mb-1 f-18">Names</p>
                                    <p class="text-muted mb-0 f-16">Email</p>
                                    <p class="text-muted mb-0 f-16">Phone</p>
                                </div>
                            </td>
                            <td>
                                <p class="fw-normal mb-1 f-18">Country</p>
                            </td>
                            <td>
                                <p class="fw-normal mb-1 f-18">Months</p>
                                <p class="text-muted mb-0 f-16">Valid until</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>