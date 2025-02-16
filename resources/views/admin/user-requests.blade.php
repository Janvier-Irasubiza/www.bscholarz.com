@section('title', 'User Requests')
@section('page', 'User Requests')

<x-app-layout>

  <x-slot name="header">
    </slot>

    <div style="padding: 0px 20px 32px 20px">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2">
        <div class="app-inner-layout__content">
          <div class="tab-content">
            <div>
              <div class="card">
                <div class="card-header-tab card-header py-3 d-flex">
                  <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-6">
                    <h1 style="font-size: 1.6em">User requests
                  </div>
                  <div class="btn-actions-pane-right text-capitalize text-right col-lg-6">

                    <a style="font-weight: 600; border: 1.3px solid;" href="{{ route('admin.applications') }}"
                      class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                      View applications
                    </a>

                  </div>
                </div>
                <div style="border-top: none" class="d-block p-3 card-footer">

                  <!-- <div class="d-flex gap-3">
                    <a href="{{ route("admin.requests", ['type' => 'all']) }}">
                      <p class="fw-normal mb-1">
                        <span class="badge rounded-pill px-3 py-2" style="color: #000; font-size: 14px">All Requests</span>
                      </p>
                    </a>

                    <a href="{{ route("admin.requests", ['type' => 'appointments']) }}">
                      <p class="fw-normal mb-1">
                        <span class="badge rounded-pill px-3 py-2"
                          style="color: #000; background: #cccccc; font-size: 14px">Appointments</span>
                      </p>
                    </a>
                  </div> -->

                  <table id="example1" class="table align-middle mb-0 bg-white mt-4" width="100%" cellspacing="0">
                    <thead class="bg-light">
                      <tr>
                        <th>Customer</th>
                        <th>Requested Application</th>
                        <th>Requested on</th>
                        <th class="text-center">Application Status</th>
                        <th class="text-center">Review</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($requests as $request)
              <tr>
              <td>
                <div class="d-flex align-items-center">
                <div class="">
                  <p class="fw-bold mb-1">{{ $request->names }}</p>
                  <p class="text-muted mb-0" style="font-size: 13px">{{ $request->email }}</p>
                  <p class="text-muted mb-0" style="font-size: 13px">{{ $request->phone_number }}</p>
                </div>
                </div>
              </td>
              <td>
                <p class="fw-normal mb-1">{{ $request->discipline_name }}</p>
                <p class="text-muted mb-0" style="font-size: 13px">{{ $request->discipline_organization }}
                </p>
              </td>

              <td>
                <p class="fw-normal mb-1">{{ $request->requested_on }}</p>
              </td>

              <td class="text-center">

                @if($request->application_status == 'Complete')
          <p class="fw-normal mb-1">
          <span class="badge bg-success rounded-pill px-3">{{ $request->application_status }}</span>
          </p>

        @elseif($request->application_status == 'In progress')

      <p class="fw-normal mb-1">
      <span class="badge bg-warning rounded-pill px-3">{{ $request->application_status }}</span>
      </p>

    @elseif($request->application_status == 'Postponed')

    <p class="fw-normal mb-1">
    <span class="badge bg-danger rounded-pill px-3">{{ $request->application_status }}</span>
    </p>

  @else
  <p class="fw-normal mb-1">
  <span class="badge bg-secondary rounded-pill px-3">{{ $request->application_status }}</span>
  </p>
@endif

              </td>

              <td class="text-center">
                <a href="{{ route('admin.request-review', ['app_id' => $request->application_id]) }}"
                style="border: 2px solid; border-radius: 100px; padding: 2px 10px"
                class="btn btn-link btn-sm btn-rounded mr-1">
                <i class="fa-solid fa-info"></i>
                </a>
              </td>
              </tr>

            @endforeach
                    </tbody>
                  </table>
                  {{-- {{ $requests->links() }} --}}
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
          removeFileShow()
        }
      </script>


    </div>
    </div>

</x-app-layout>
