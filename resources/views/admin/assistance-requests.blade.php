@section('title', 'Assistance requests')

<x-app-layout>
    <div class="py-2 px-3">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2">
                <div class="card">
                    <div class="card-header-tab card-header py-3 d-flex">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-6">
                            <strong>Assistance requests</strong> 
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 bg-white">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Client</th>
                                        <th>Issue</th>
                                        <th>Issue Description</th>
                                        <th>Received on</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assistanceRequests as $request)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="">
                                                        <p class="fw-bold mb-1">{{ $request->names }}</p>
                                                        <p class="text-muted mb-0" style="font-size: 13px">{{ $request->phone_number }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="fw-normal mb-1">{{ $request->issue }}</p>
                                            </td>
                                            <td>{{ $request->issue_desc }}</td>
                                            <td class="text-left">
                                                <p class="text-muted mb-0">{{ $request->posted_on }}</p>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <a href="#" class="btn btn-link btn-sm btn-rounded mr-1 requestInfo" style="border: 2px solid; border-radius: 100px; padding: 2px 10px"
                                                       data-id="{{ $request->id }}"
                                                       data-names="{{ $request->names }}"
                                                       data-email="{{ $request->email }}"
                                                       data-phone="{{ $request->phone_number }}"
                                                       data-issue="{{ $request->issue }}"
                                                       data-desc="{{ $request->issue_desc }}"
                                                       data-toggle="modal"
                                                       data-target="#seekModal">
                                                        <i class="fa-solid fa-reply"></i>
                                                    </a>
                                                    <a href="#">
                                                        <i class="fa-solid fa-trash" style="font-size: 18px; color: #ff6666"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination Links -->
                        {{ $assistanceRequests->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="seekModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="seekModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" style="text-align: left" id="seekModalLabel"></h5>
                        <p class="m-0">
                            <small style="font-size: 14px;" class="text-muted mb-0">From: <span class="modal-names"></span> - <span class="modal-email"></span> - <span class="modal-phone"></span></small>
                        </p>
                    </div>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('request-reply') }}" method="post" class="space-y-2">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="client_id" id="modal-client-id" class="block mt-1 w-full input-holder client-id">
                        <div>
                            <x-input-label for="modal-issue-desc" :value="__('Issue description')" />
                            <div class="block mt-1 w-full input-holder">
                                <span style="font-size: 14px; font-weight: 500; color: #404040" id="modal-issue-desc"></span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="modal-reply" :value="__('Reply')" />
                            <p style="font-size: 14px;" class="text-muted mb-0">Reply to the issue</p>
                            <textarea placeholder="Type reply here..." id="modal-reply" name="reply" class="block w-full border rounded-md px-3 py-2 mt-1" required></textarea>
                            <label for="modal-send-reply" class="d-flex items-center justify-content-start mt-2">
                                <input id="modal-send-reply" type="checkbox" value="send" name="remember" class="shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                <span class="text-sm ml-2">{{ __('Notify client with the reply') }}</span>
                            </label>
                            <x-input-error :messages="$errors->get('reply')" class="mt-2" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="modal-send-btn" class="btn apply-btn">Save reply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- </> Modal -->

    <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.requestInfo', function () {
                var issue = $(this).data('issue');
                var names = $(this).data('names');
                var email = $(this).data('email');
                var phone = $(this).data('phone');
                var desc = $(this).data('desc');
                var clientId = $(this).data('id');

                $('#seekModalLabel').html(issue);
                $('.modal-names').html(names);
                $('.modal-email').html(email);
                $('.modal-phone').html(phone);
                $('#modal-issue-desc').html(desc);
                $('#modal-client-id').val(clientId);
                $('#modal-reply').val('');
                $('#modal-send-reply').prop('checked', false);
                $('#modal-send-btn').text('Save reply');
            });

            $('#modal-send-reply').on('change', function () {
                if (this.checked) {
                    $('#modal-send-btn').text('SAVE AND SEND REPLY');
                } else {
                    $('#modal-send-btn').text('Save reply');
                }
            });
        });
    </script>
</x-app-layout>
