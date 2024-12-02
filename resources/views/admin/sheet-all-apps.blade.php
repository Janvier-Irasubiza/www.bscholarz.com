@section('title', 'Sheet')

<x-app-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 20px 32px 20px" class="mb-4">
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2 mb-4">
                    <div class="app-inner-layout__content">
                    <div class="tab-content">
                    <div>
                    <div class="card">
                    <div class="card-header-tab card-header py-3 d-flex">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-7">
                    <div class="widget-subheading">{{ $member -> names }}  </div>
                    <p class="text-muted mb-0">{{ $member -> email }} </p>
                    <p class="text-muted mb-0">{{ $member -> phone_number }} </p>

                    </div>
                    <div class="btn-actions-pane-right d-flex flex-row-reverse text-capitalize col-lg-5">

                    <div class="widget-chart-content ml-2 px-3">
                    <div class="widget-subheading">Balance <small>(RWF)</small></div>

                    <div class="widget-numbers text-success"><span style="font-weight: 600">{{ number_format($completedApp -> sum('assistant_pending_commission')) }}</span></div>
                
                    <button data-toggle="modal" data-target="#history">View History</button>


                    </div>

                    <div class="icon-wrapper d-flex align-items-center justify-content-center">
                    <div class="icon-wrapper-bg opacity-9 rounded-circle" style="background: #80ffaa; padding: 15px 17px">
                    <i class="fa-solid fa-sack-dollar" style="font-size: 25px"></i></div>
                    </div>

                    </div>                    
                    </div>
                    </div>

                    <div class="p-4">
                    <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Recordings')" />
                    <p class="text-muted mb-0" style="font-size: 13px">Served requests by {{ $member -> names }} </p>
                    </div>


                    <div class="px-4 d-flex justify-content-between align-items-center">
                    <form method="get" action="{{ Auth::user() ? route('admin.sort-recs-all', ['assistant' => '$emplyee']) : route('accountant-sort-recs-all', ['assistant' => '$emplyee']) }}" style="display: contents;">
                            <div class="sort-sect col-lg-8 d-flex gap-2">
                                <div class="btn btn-primary" id="sortButton" onclick="showSortOptions()">
                                    Sort Entries
                                </div>
                                <div class="col-lg-3" id="sortByContainer" style="display: none;">
                                    <select id="sortBy" name="sortBy" class="w-full" required
                                        style="border: 2px solid; border-radius: 7px; font-size: 14px; padding: 5px 5px"
                                        onchange="showRelevantInputs()">
                                        <option value="">Sort By</option>
                                        <option value="date" {{ $sortBy == 'date' ? 'selected' : '' }}>Date</option>
                                        <option value="application" {{ $sortBy == 'application' ? 'selected' : '' }}>
                                            Application</option>
                                    </select>
                                </div>
                                <div id="employeeInput" class="col-lg-4" style="display: none;">
                                    <select id="employee" name="employee" class="w-full"
                                        style="border: 2px solid; border-radius: 7px; font-size: 14px; padding: 5px 5px">
                                        <option value="">Select Employee</option>
                                        @foreach ($employees as $staff)
                                            <option value="{{ $staff->id }}" {{ $employee == $staff->id ? 'selected' : '' }}>
                                                {{ $staff->names }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="applicationInput" class="col-lg-4" style="display: none;">
                                    <select id="application" name="application" class="w-full"
                                        style="border: 2px solid; border-radius: 7px; font-size: 14px; padding: 5px 5px">
                                        <option value="">Select Application</option>
                                        @foreach ($apps as $app)
                                            <option value="{{ $app->id }}">
                                                {{ $app->discipline_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="text" name="assistant" value="{{ $member -> id }}" hidden>

                                <div id="dateInputs" class="col-lg-5 d-flex gap-2" style="display: none !important">
                                    <div>
                                        <x-input-label for="start_date" :value="__('From')"
                                            style="font-size: 10px; margin-top: -7px" />
                                        <input class="block w-full px-1 p-0" type="date" name="start_date"
                                            id="start_date" value="{{ $startDate }}"
                                            style="padding: 6px 10px; border: 2px solid #4d4d4d; border-radius: 6px; margin-top: -4px; color: #808080;" />
                                    </div>
                                    <div>
                                        <x-input-label for="end_date" :value="__('To')"
                                            style="font-size: 10px; margin-top: -7px" />
                                        <input class="block w-full px-1 p-0" type="date" name="end_date" id="end_date"
                                            value="{{ $endDate }}"
                                            style="padding: 6px 10px; border: 2px solid #4d4d4d; border-radius: 6px; margin-top: -4px; color: #808080;" />
                                    </div>
                                </div>
                                <div id="sortBtn" class="sort-btn" style="display: none">
                                    <button type="submit" class="border bg-success px-2 py-1 rounded text-white"
                                        style="margin-top: 2px">Sort</button>
                                </div>
                            </div>
                        </form>

                        <div class="d-flex gap-2">
                        <a href="{{ Auth::user() ? route('admin.sheet', ['assistant' => $member -> id]) : route('employer-sheet', ['assistant' => $member -> id]) }}">
                            <p class="fw-normal mb-1">
                                <span class="badge rounded-pill px-3" style="color: #000">This Month</span>
                            </p>
                        </a>

                        <a href="{{ Auth::user() ? route('admin.sort-recs-all', ['assistant' => $member -> id]) : route('accountant-sort-recs-all', ['assistant' => $member -> id]) }}">
                            <p class="fw-normal mb-1">
                                <span class="badge rounded-pill px-3" style="color: #000; background: #cccccc">All applications</span>
                            </p>
                        </a>

                    </div>

                    </div>

                    </div>

                    <form action="{{ route('admin.pay-assistant') }}" method="post"> @csrf

                    <input type="text" name="assistant" value="{{ $member -> id }}" hidden>

                    <div style="border-top: none" class="d-block p-3 card-footer">

                    <div class="d-flex">                    

                    <div class="w-full d-flex flex-row-reverse gap-2 align-items-center"> 
                        
                      <div id="disburse" style="display: none">
                        <button>
                            <p class="fw-normal mb-1">
                                <span class="badge bg-success px-3 py-2" style="border-radius: 6px">Disburse</span>
                            </p>
                        </button>
                        </div>

                      <div id="disburse_amt" style="display: none">
                      	<div class="m-0 p-0"><span style="font-weight: 600; font-size: 20px;" class="m-0 p-0" id="d_amount"> </span><small style="font-weight: 600;">RWF</small></div>
                       </div>
                      
                    </div>

                    </div>

                    <div class="info-div mt-3 mb-4">
                    
                    <table id="table" class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">

                        <tr>
                       		<th><input type="checkbox" readonly name="select_all" value="1" id="example-select-all"></th>
                            <th>Applicant</th>
                            <th>Application</th>
                            <th>Served On</th>
                            <th class="text-left">Amount paid</th>
                            <th class="text-left">Commission</th>
                            </tr>

                        </thead>
                        <tbody>

                        @foreach ($completedApp as $request) 

                            @if($request -> remittance_status == 'Paid')    

                        <tr style="background: #ca11112f;">

                        @else

                        <tr>

                        @endif

                        
                        <td>
                        @if($request -> remittance_status == 'on hold' && $request -> assistant_pending_commission > 0)
                            <input type="checkbox" name="app[]" data-amount="{{ $request -> assistant_pending_commission }}" value="{{ $request -> application_id }}" id="app">
                            <input type="text" name="assistant" value="{{ $request -> assistant }}" hidden id="">
                            @endif
                        </td>
                            <td>
                                <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="fw-bold mb-1">{{ $request -> names }}</p>
                                    <p class="text-muted mb-0" style="font-size: 13px">{{ $request -> email }}</p>
                                    <p class="text-muted mb-0" style="font-size: 13px">{{ $request -> phone_number }}</p>
                                </div>
                                </div>
                            </td>
                            <td>
                                <p class="fw-normal mb-1">{{ $request -> discipline_name }}</p>
                                <p class="text-muted mb-0" style="font-size: 13px">{{ $request -> discipline_organization }}</p>
                            </td>

                            <td>
                                <p class="fw-normal mb-1">{{ $request -> served_on }}</p>
                            </td>

                            @php

                            $atdg_amt_exp = explode(';', $request -> outstanding_paid_amount);      

                            $sum = 0;

                            foreach ($atdg_amt_exp as $key => $value) {

                                $number = explode('=>', $value);
                                $sum += intval($number[0]);
                                
                            }

                            @endphp

                            <td class="text-left">
                            <p class="fw-normal mb-1">{{ number_format(intval($request -> amount_paid) + $sum) }} RWF</p>
                                <p class="text-muted mb-0" style="font-size: 13px"> Outstanding amount: {{ number_format(floatval($request -> service_fee) - (intval($request -> amount_paid) + $sum)) }}</p>
                            </td>



                            <td class="text-left">
                            <p class="fw-normal mb-1">@if($request -> assistant_pending_commission > 0) {{ number_format($request -> assistant_pending_commission) }} @else {{ number_format($request -> assistant_paid_commission) }} @endif RWF</p>

                            @if($request -> remittance_status == 'Paid')
                            <p class="fw-normal mb-1">
                            <span class="badge bg-success rounded-pill px-3">{{ $request -> remittance_status }}</span>
                            </p>
                            @else
                            <p class="fw-normal mb-1">
                            <span class="badge bg-secondary rounded-pill px-3">{{ $request -> remittance_status }}</span>
                            </p>
                            @endif 

                            </td>

                            </tr>

                            @endforeach

                            <tr>

                            <td colspan="4">
                            <th>Sum <p class="text-muted mb-0" style="font-size: 13px"> To be disbursed </p> </th>
                            </td>

                            <td>
                                <p class="fw-normal mb-1 text-center">{{ number_format($completedApp -> sum('assistant_pending_commission')) }} <small>RWF</small></p>
                            </td>

                            </tr>
                            
                        </tbody>
                    </table>
                    
                    </form>
                    
                    </div>

                    {{ $completedApp -> links() }}
               
                    </div>
                    </div>
                    </div>
                    </div>

    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="history" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">

        <div class="widget-subheading"><p class="mb-0" style="font-size: 25px">{{ $member -> names }} </p> </div>
                    <p class="text-muted mb-0">{{ $member -> email }} </p>
                    <p class="text-muted mb-0">{{ $member -> phone_number }} </p>

        </h5>
        <button type="button" onclick="clodeMoodal()" id="closeModal" class="close btn btn-danger" style="border: 3px solid; background: none" data-dismiss="modal" aria-label="Close">
            <span style="color: #000" aria-hidden="true" class="fa fa-times"></span>
        </button>
      </div>
      <div class="modal-body pb-4">
        
      <label for="email" style="text-align: left" class="text-left w-full">SInce: {{ $member -> created_at }} </label>

      <div class="widget-numbers text-success"><span style="font-weight: 600">{{ number_format($history -> sum('amount_disbursed')) }} <small>(frw)</small></span></div>

      <p>Has entered his/her account.</p>
        
        @if($history)
        <div class="mt-2 card w-full" style="background: none">
                      
            
                      
                    <div class="card-header-tab card-header py-3 d-flex justify-content-between">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                      <strong>Disbursements history</strong> 
                      </div>
                      
                      <div>
                      	<a href="{{ route('staff.disbursements', ['assistant' => $member -> id]) }}" style="font-size: 15px"> View complete history</a>
                    </div>
                    
                    </div>
                    <div style="border-top: none" class="d-block p-3 card-footer">

                    <table style="background: none" class="table align-middle mb-0">

  <tbody>
    @foreach($history as $record)
    
    <tr>
      
      <td>
        <div class="d-flex align-items-center" style="margin: 0px">
          <div class="w-full" style="padding: 0px 5px">
            <p class="fw-bold mb-1">{{ number_format($record -> amount_disbursed) }} <small>RWF</small></p>
            <p class="text-muted mb-0" style="font-size: 15px"> Disbursed on: {{ $record -> date_time }} </p>
          </div>
          
        </div>
      </td>
    </tr>

    @endforeach

  </tbody>
</table>
                
                </div>
                    </div>
        @endif

      </div>
    </div>
  </div>
</div>
<!-- </> modal -->


<script>

let assistantCheck = document.querySelectorAll('#app');
let disburse_amt =  document.querySelector('#disburse_amt');
let amount = document.querySelector('#d_amount');
let amt = 0;

assistantCheck.forEach((element) => {

    element.addEventListener('change', function () {

        if (element.checked) {

          disburse_amt.style.display = 'block';
          document.querySelector('#disburse').style.display = 'block';
          
          amt += parseFloat($(this).attr('data-amount'));
          
          amount.textContent = (amt).toLocaleString(undefined);

        }

        else {

          amt -= parseFloat($(this).attr('data-amount'));
          
          amount.textContent = (amt).toLocaleString(undefined);
           if(amt == 0){
              disburse_amt.style.display = 'none';
            	document.querySelector('#disburse').style.display = 'none';
              }
        
        }

    });
    
});
  
  
// Initialize DataTable with buttons
$(document).ready(function () {

// Keep selected options visible
const sortBy = '{{ $sortBy }}';
const employee = '{{ $employee }}';

if (sortBy) {
    $('#sortByContainer').show();
    $('#sortBy').val(sortBy);
    showRelevantInputs(); // Show the relevant inputs based on sortBy value
}

if (employee) {
    $('#employeeInput').show();
    $('#employee').val(employee);
}

if (application) {
    $('#applicationInput').show();
    $('#application').val(application);
}

// Export to Excel functionality
document.getElementById('exportExcel').addEventListener('click', function () {
    // Create a new workbook and add a worksheet
    const wb = XLSX.utils.book_new();

    // Get the table data and convert it to a worksheet
    const ws = XLSX.utils.table_to_sheet(document.getElementById('example1'));

    // Append the worksheet to the workbook
    XLSX.utils.book_append_sheet(wb, ws, 'Transactions Waiting For Clarification');

    // Write the workbook to a file
    XLSX.writeFile(wb, 'Transactions_Waiting_For_Clarification.xlsx');
});


// Add event listeners to show the sort button when inputs change
$('#sortBy, #employee, #application, #start_date, #end_date').on('change', function () {
    $('#sortBtn').show();
});

$('#sortBy').on('change', function () {
    $('#employee').val('');
    $('#application').val('');
    $('#start_date').val('');
    $('#end_date').val('');
    $('#sortBtn').show();
})
});

// Show the sort options when the button is clicked
function showSortOptions() {
document.getElementById('sortByContainer').style.display = 'block';
document.getElementById('sortBtn').style.display = 'block';
}

// Show relevant inputs based on sorting selection
function showRelevantInputs() {
document.getElementById('dateInputs').style.setProperty('display', 'none', 'important');
document.getElementById('employeeInput').style.display = 'none';
document.getElementById('applicationInput').style.display = 'none';

const sortBy = document.getElementById('sortBy').value;
if (sortBy === 'date') {
    document.getElementById('dateInputs').style.display = 'flex';
} else if (sortBy === 'employee') {
    document.getElementById('employeeInput').style.display = 'block';
} else if (sortBy === 'application') {
    document.getElementById('applicationInput').style.display = 'block';
}
}

// Show success modal if there is a success message
@if (session('success'))
$(document).ready(function () {
    $('#successModal').modal('show');
});
@endif


</script>

</x-app-layout>