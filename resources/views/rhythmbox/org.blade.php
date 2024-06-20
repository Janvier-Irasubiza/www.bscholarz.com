@section('title', 'Organization')
<x-rhythm-box>

<x-slot name="header">
</slot>


<div class="py-2" style="padding: 0px 80px 0px 98px">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-5">

    <div class="card">

    <div class="card-header-tab card-header py-3 d-flex" style="border-bottom: 1px solid rgba(0, 0, 0, 0.192)">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                    BBG Organization</br>
                    <small class="text-muted mb-0">Bwenge Business Group - Staff</small>
                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right d-flex justify-content-end gap-3 align-items-center  col-lg-4">
                    
                    <a href="{{ route('rba') }}">
                            <p class="fw-normal mb-1">
                                <span class="badge  mt-1 px-3 py-2" style="color: #000; background: #cccccc">Rhythm Box</span>
                            </p>
                        </a>

                    </div>
                    </div>
<div class="card-body">
<table id="" class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>Names</th>
      <th>Department</th>
      <th class="text-center">Status</th>
      <th class="text-right" style="padding-right: 21px">Recordings</th>
    </tr>
  </thead>
  <tbody>
  
  @foreach($staff as $member)

    <tr>
      <td>
        <div class="d-flex align-items-center">
          <img
              src="{{ asset('staff') }}/{{ $member -> profile_picture }}"
              alt=""
              style="width: 45px; height: 45px"
              class="rounded-circle"
              />
          <div class="ms-3">
            <p class="fw-bold mb-1">{{ $member -> names }}</p>
            <p class="text-muted mb-0" style="font-size: 13px">{{ $member -> email }}</p>
            <p class="text-muted mb-0" style="font-size: 13px">{{ $member -> phone_number }}</p>
          </div>
        </div>
      </td>
      <td>
        <p class="fw-normal mb-1">{{ $member -> department }}</p>
        <p class="text-muted mb-0" style="font-size: 13px">{{ $member -> role }}</p>
      </td>

      <td class="text-center">
        @if($member -> status == 'Online')
        <span class="badge bg-success rounded-pill px-3">{{ $member -> status }}</span>
        @else
        <span class="badge bg-warning rounded-pill px-3">{{ $member -> status }}</span>
        @endif
      </td>

      <td class="text-right">
      <a href="{{ route('rhythmbox.sheet', ['assistant' => $member -> id]) }}" style="border-radius: 6px; padding: 1px 10px; text-decoration: none; color: ghostwhite" class="btn btn-link btn-sm btn-rounded mr-1 apply-btn">
      Open sheet
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




</x-rhythm-box>
