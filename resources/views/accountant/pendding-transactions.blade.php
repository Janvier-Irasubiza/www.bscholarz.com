@section('title', 'Transactions')

<x-accountant-layout>
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
                            Pending Transactions
                            </div>
                            <div class="btn-actions-pane-right text-capitalize text-right col-lg-6">

                            </div>
                            </div>
                            <div style="border-top: none" class="d-block p-3 card-footer">

                            <table id="example1" class="table align-middle mb-0 bg-white">
          <thead class="bg-light">
            <tr>
              <th>Transaction For</th>
              <th>Transaction By</th>
              <th>Date</th>
              <th>Agent In Charge</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>

            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="">
                    <p class="fw-normal mb-1">Mastercard Foundation Scholarship Application</p>
                  </div>
                </div>
              </td>
              <td>
                <p class="fw-normal mb-1">John Doe</p>
                <p class="text-muted mb-0" style="font-size: 13px">johndoe@gmail.com | +2507876435323</p>
              </td>

              <td>
                <p class="fw-normal mb-1">21-12-1999</p>
              </td>

              <td>

                <p class="fw-normal mb-1">
                    <p class="fw-normal mb-1">Mrs. GASANA Jane</p>
                    <p class="text-muted mb-0" style="font-size: 13px">johndoe@gmail.com | +2507876435323</p>
                </p>

              </td>

              <td class="text-center">
                <a style="font-weight: 600; border: 1.3px solid;" href="{{ route('transaction-review') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                    Review
                    </a>
              </td>
            </tr>

            <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="">
                      <p class="fw-normal mb-1">Mastercard Foundation Scholarship Application</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="fw-normal mb-1">John Doe</p>
                  <p class="text-muted mb-0" style="font-size: 13px">johndoe@gmail.com | +2507876435323</p>
                </td>

                <td>
                  <p class="fw-normal mb-1">21-12-1999</p>
                </td>

                <td>

                  <p class="fw-normal mb-1">
                      <p class="fw-normal mb-1">Mrs. GASANA Jane</p>
                      <p class="text-muted mb-0" style="font-size: 13px">johndoe@gmail.com | +2507876435323</p>
                  </p>

                </td>

                <td class="text-center">
                  <a style="font-weight: 600; border: 1.3px solid;" href="{{ route('transaction-review') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                      Review
                      </a>
                </td>
              </tr>

              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="">
                      <p class="fw-normal mb-1">Mastercard Foundation Scholarship Application</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="fw-normal mb-1">John Doe</p>
                  <p class="text-muted mb-0" style="font-size: 13px">johndoe@gmail.com | +2507876435323</p>
                </td>

                <td>
                  <p class="fw-normal mb-1">21-12-1999</p>
                </td>

                <td>

                  <p class="fw-normal mb-1">
                      <p class="fw-normal mb-1">Mrs. GASANA Jane</p>
                      <p class="text-muted mb-0" style="font-size: 13px">johndoe@gmail.com | +2507876435323</p>
                  </p>

                </td>

                <td class="text-center">
                  <a style="font-weight: 600; border: 1.3px solid;" href="{{ route('transaction-review') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                      Review
                      </a>
                </td>
              </tr>

              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="">
                      <p class="fw-normal mb-1">Mastercard Foundation Scholarship Application</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="fw-normal mb-1">John Doe</p>
                  <p class="text-muted mb-0" style="font-size: 13px">johndoe@gmail.com | +2507876435323</p>
                </td>

                <td>
                  <p class="fw-normal mb-1">21-12-1999</p>
                </td>

                <td>

                  <p class="fw-normal mb-1">
                      <p class="fw-normal mb-1">Mrs. GASANA Jane</p>
                      <p class="text-muted mb-0" style="font-size: 13px">johndoe@gmail.com | +2507876435323</p>
                  </p>

                </td>

                <td class="text-center">
                  <a style="font-weight: 600; border: 1.3px solid;" href="{{ route('transaction-review') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                      Review
                      </a>
                </td>
              </tr>

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

</x-accountant-layout>
