@section('title', 'On going applications')

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
                    Applications 
                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-6">

                    <a style="font-weight: 600; border: 1.3px solid;" href="{{ route('admin.requests') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                    View Clients requests
                    </a>

                    <a href="{{ route('admin.new-application') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-primary">
                <span class="mr-2 opacity-7">
                <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                </span>
                <span class="mr-1">New application</span>
                </a>

                    </div>
                    </div>
                    <div style="border-top: none" class="d-block p-3 card-footer">

                    <table id="example1" class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>Application</th>
      <th>Category</th>
      <th>Country</th>
      <th class="text-center">Price</th>
      <th class="text-center">Review</th>
    </tr>
  </thead>
  <tbody>

  @foreach($applications as $discipline)
    <tr>
      <td>
        <div class="d-flex align-items-center">
          <div class="">
            <p class="fw-bold mb-1">{{ $discipline -> discipline_name }}</p>
            <p class="text-muted mb-0" style="font-size: 13px">{{ $discipline -> organization }}</p>
          </div>
        </div>
      </td>
      <td>
        <p class="fw-normal mb-1">{{ $discipline -> category }}</p>
      </td>

      <td>
        <p class="fw-normal mb-1">{{ $discipline -> country }}</p>
      </td>

      <td class="text-center">
        <p class="fw-normal mb-1">{{ $discipline -> service_fee }}</p>
      </td>

      <td class="text-center">
      <a href="{{ route('admin.app-info', ['identifier' => $discipline -> identifier]) }}" style="border: 2px solid; border-radius: 100px; padding: 2px 10px" class="btn btn-link btn-sm btn-rounded mr-1">
      <i class="fa-solid fa-info"></i>
            </a>
      </td>
    </tr>

    @endforeach
  </tbody>
</table>
                
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

            function removeFileFun () {
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