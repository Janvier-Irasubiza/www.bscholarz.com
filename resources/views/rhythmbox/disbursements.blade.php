@section('title', 'On going applications')

<x-rhythm-box>

<x-slot name="header">
</slot>

<div class="mt-5 mb-4" style="padding: 0px 20px 32px 20px">
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2">
                    <div class="app-inner-layout__content">
                    <div class="tab-content d-flex justify-content-center">
                    <div class="flex-section gap-3 col-lg-10">
                      
                      <div class="px-4 pt-3 small-8 medium-2 large-2 columns img-section col-lg-2 pt-2 col-lg-5" style="border: 1px solid #d9d9d9; border-radius: 8px">
            
                      <div>
                      <div class="widget-chart-content col-lg-9 ml-1">
                      <div class="widget-subheading">Balance</div>
                      <div class="widget-numbers text-success"><span>{{ number_format(Auth::guard('rhythmbox') -> user() -> pending_amount) }} <small>RWF</small> </span></div>
                      <div class="widget-description text-focus">

					  <p class="mb-0" style="font-weight: 600">Outstanding amount: {{ number_format($history->sum('outstanding_amount')) }} <smaLL>RWF</smaLL></p>
                        
                      </div>
                      </div>
                      </div>
                      </div>        
  
                    <div class="card w-full">
                      
            
                      
                    <div class="card-header-tab card-header py-3 d-flex">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-6">
                    <strong>Disbursements history</strong> 
                    </div>
                    
                    </div>
                    <div style="border-top: none" class="d-block p-3 card-footer">

                    <table class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>Amount paid</th>
    </tr>
  </thead>
  <tbody>
    @foreach($history as $record)
    
    <tr>
      
      <td>
        <div class="d-flex align-items-center" style="margin: 0px">
          <div class="w-full" style="padding: 0px 5px">
            <p class="fw-bold mb-1">{{ number_format($record -> paid_amount) }} <small>RWF</small></p>
            <p class="text-muted mb-0" style="font-size: 15px"> Disbursed on: {{ $record -> paid_at }} </p>
          </div>
          
          <div class="text-right w-full" style="padding: 0px 5px">
            <p class="text-muted mb-0" style="font-size: 15px"> Outstanding amount: {{ number_format($record -> outstanding_amount) }} <small>RWF</small> </p>
          </div>
        </div>
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

</x-rhythm-box>