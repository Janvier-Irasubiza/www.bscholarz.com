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
                    <strong>Recently Deleted Applications</strong> 
                    </div>
                    
                    </div>
                    <div style="border-top: none" class="d-block p-3 card-footer">

                    <table class="table align-middle mb-0 bg-white" id="example1">
  <thead class="bg-light">
    <tr>
      <th>Applicant Info</th>
      <th>Application Info</th>
      <th>Deleted On</th>
      <th>Deleted By</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($requested_delete as $debtor)
    
    @php
      $deleted_by = DB::table('staff') -> where('id', $debtor -> revied_by) -> first();
    @endphp
    
    <tr>
      <td>
        <div class="d-flex align-items-center" style="margin: 0px">
          <div class="" style="padding: 0px 5px">
            <p class="fw-bold mb-1">{{ $debtor -> names }}</p>
            <p class="text-muted mb-0">{{ $debtor -> email }} <br> {{ $debtor -> phone_number }}</p>
          </div>
        </div>
      </td>
      
      <td>
        <div class="d-flex align-items-center" style="margin: 0px">
          <div class="" style="padding: 0px 5px">
            <p class="fw-bold mb-1">{{ $debtor -> discipline_name }}</p>
            <p class="text-muted mb-0">{{ $debtor -> discipline_organization }} - {{ $debtor -> discipline_country }}</p>
          </div>
        </div>
      </td> 
      
      <td>
        <p class="fw-normal mb-1"><strong>{{ $debtor -> deleted_on }}</strong></p>
      </td>
      
      <td>
        <div class="d-flex align-items-center" style="margin: 0px">
          <div class="" style="padding: 0px 5px">
            <small class="mb-1">{{ $deleted_by -> names }}</small>
          </div>
        </div>
      </td> 
      
      <td class="text-center">
        <div class="w-full">
          <a style="color: black" href="{{ route('recovery', ['customer_info' => $debtor -> id, 'application_info' => $debtor -> application_id]) }}" class="container d-flex align-items-center justify-content-center" style="padding: 5px; border-radius: 5px">
            <div class="continue-app d-flex align-items-center justify-content-center p-1" style="">
                <div class="staff-resume-btn-1">Recover</div>
            </div>
          </a>
        </div>
	  </td>
    </tr>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="top: 100px">
            <div class="modal-header">
                <strong><h1 style="font-size: 14px" class="modal-title fs-5" id="exampleModalLabel">Record Payment</h1></strong>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"><i style="font-size: 24px; color: ghostwhite; margin-left: 0px; margin-top: -10px" class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">

              <div class="d-flex items-center justify-center p-0" style="">

              <form action="{{ route('mark-debtor-as-paid') }}" method="post"> @csrf
                <input type="text" name="app_id" class="test" required hidden>
                <button href="" style="color: black" class="ml-4 complete-payment mark-paid">Complete Payment</button>
              </form>       

              <button id="partialBtn" style="color: black" class="ml-4 complete-payment">
                  {{ __('Partial Payment') }}
              </button>

              <button style="color: black" class="ml-4 complete-payment undo">
                  {{ __('Undo') }}
              </button>

            </div>


            <div id="partialDeptPayment" class="mt-3">
              <form action="{{ route('mark-partial-payment') }}" method="POST" class="mt-3">
              @csrf
                <div class="" style="width: 75%; margin: auto">
                    <x-input-label for="link" :value="__('How much have you received?')" />
                    <input type="text" name="app_id" class="test" required hidden>
                    <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="amountReceived" class="block mt-1 w-full" type="text" name="amountReceived" :value="(amountReceived)" placeholder="Enter amount you have received" autocomplete="amountReceived" required/>
                    <x-input-error :messages="$errors->get('amountReceived')" class="mt-2" />
                </div>

                <div class="modal-footer d-flex align-items-center justify-content-center mt-3"> 
                  <button type="submit" class="btn btn-secondary bg-danger" style="border: none; color: ghostwhite; font-weight: bold; text-transform: uppercase; font-size: 13px; ">Record Payment</button>
                </div>
            </form>

            </div>

            </div>
            
            </div>

        </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="top: 100px">
            <div class="modal-header">
                <strong><h1 style="font-size: 14px" class="modal-title fs-5" id="exampleModalLabel">Record Payment</h1></strong>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"><i style="font-size: 24px; color: ghostwhite; margin-left: 0px; margin-top: -10px" class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body pt-0" style="border-top: 0.01em solid #ddd">

              <div class="d-flex items-center justify-center p-0" style="">

              <form action="{{ route('mark-as-greed') }}" method="POST" class="">
              @csrf
                <div class="" style="">
                    <input type="text" name="app_id" class="debtor" required hidden>
                </div>

                <div class="d-flex align-items-center justify-content-center mt-3 mr-3"> 
                  <button type="submit" class="btn complete-payment" style="border: 2px solid #000; color: #000; font-weight: bold; text-transform: uppercase; font-size: 13px; ">Mark As Greed</button>
                </div>
              </form>

              <form action="{{ route('remind-to-pay') }}" method="POST" class="">
              @csrf
                <div class="" style="">
                    <input type="text" name="app_id" class="debtor" required hidden>
                </div>

                <div class="d-flex align-items-center justify-content-center mt-3 ml-3"> 
                  <button type="submit" class="btn complete-payment" style="border: 2px solid #000; color: #000; font-weight: bold; text-transform: uppercase; font-size: 13px; ">Remind To Pay</button>
                </div>
              </form>

            </div>
            </div>
            
            </div>

        </div>
        </div>

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