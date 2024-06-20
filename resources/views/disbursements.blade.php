@section('title', 'Application info')

@if(Auth::guard('staff')->check())
<x-staff-layout>
  
<x-slot name="header">
</slot>

<div style="padding: 0px 100px 32px 100px;">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2">

    <div class="p-3">
   <div class="card">
                    <div class="card-header-tab card-header py-3 d-flex align-items-center">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-7">
                    <div class="widget-subheading">{{ $member -> names }}  </div>
                    <p class="text-muted mb-0">{{ $member -> email }} </p>
                    <p class="text-muted mb-0">{{ $member -> phone_number }} </p>

                    </div>
                    <div class="btn-actions-pane-right d-flex flex-row-reverse text-capitalize col-lg-5">

                    <div class="widget-chart-content ml-2 px-3">
                    <div class="widget-subheading">Balance <small>(RWF)</small></div>

                    <div class="widget-numbers text-success"><span style="font-weight: 600">{{ number_format($balance -> sum('assistant_pending_commission')) }}</span></div>
                    
                    </div>

                    <div class="icon-wrapper d-flex align-items-center justify-content-center">
                    <div class="icon-wrapper-bg opacity-9 rounded-circle" style="background: #80ffaa; padding: 15px 17px">
                    <i class="fa-solid fa-sack-dollar" style="font-size: 25px"></i></div>
                    </div>

                    </div>    
                     
                    </div>
                    </div>

                    <div class="mt-3">
                      
                                          <table style="background: none" class="table align-middle mb-0">

 <tr>
      <th>Amount paid</th>
    </tr>
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


    <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>



    </div>
</div>

</x-staff-layout>
@else
<x-app-layout>
<x-slot name="header">
</slot>

<div style="padding: 0px 100px 32px 100px;">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2">

    <div class="p-3">
   <div class="card">
                    <div class="card-header-tab card-header py-3 d-flex align-items-center">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-7">
                    <div class="widget-subheading">{{ $member -> names }}  </div>
                    <p class="text-muted mb-0">{{ $member -> email }} </p>
                    <p class="text-muted mb-0">{{ $member -> phone_number }} </p>

                    </div>
                    <div class="btn-actions-pane-right d-flex flex-row-reverse text-capitalize col-lg-5">

                    <div class="widget-chart-content ml-2 px-3">
                    <div class="widget-subheading">Balance <small>(RWF)</small></div>

                    <div class="widget-numbers text-success"><span style="font-weight: 600">{{ number_format($balance -> sum('assistant_pending_commission')) }}</span></div>
                    
                    </div>

                    <div class="icon-wrapper d-flex align-items-center justify-content-center">
                    <div class="icon-wrapper-bg opacity-9 rounded-circle" style="background: #80ffaa; padding: 15px 17px">
                    <i class="fa-solid fa-sack-dollar" style="font-size: 25px"></i></div>
                    </div>

                    </div>    
                     
                    </div>
                    </div>

                    <div class="mt-3">
                      
                                          <table style="background: none" class="table align-middle mb-0">

 <tr>
      <th>Amount paid</th>
    </tr>
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


    <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>



    </div>
</div>

</x-app-layout>
@endif
