@section('title', 'Community')

<x-app-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 20px 32px 20px">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2">

    <div class="card">

    <div class="card-header-tab card-header py-3 d-flex" style="border-bottom: 1px solid rgba(0, 0, 0, 0.192)">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                    BBG Organization</br>
                    <small class="text-muted mb-0">Community</small>
                    </div>
                    </div>
<div class="card-body">
<table id="example1" class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>Names</th>
      <th>Address</th>
      <th>Joined on</th>
      <th class="text-center">Applications</th>
      <th class="text-center">Review</th>
    </tr>
  </thead>
  <tbody>
  
  @foreach($clients as $member)

    <tr>
      <td>
        <div class="d-flex align-items-center">
          <img
              src="{{ asset('clients') }}/{{ $member -> profile_picture }}"
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
        <p class="fw-normal mb-1">{{ $member -> country }}</p>
        <p class="text-muted mb-0" style="font-size: 13px">{{ $member -> province }}</p>
        <p class="text-muted mb-0" style="font-size: 13px">{{ $member -> city }}</p>
      </td>
      <td>
        <p class="fw-normal mb-1">{{ $member -> created_at }}</p>
      </td>

      <td class="text-center">
        <p class="fw-normal mb-1">{{ count(DB::table('applications') -> where('applicant', $member -> id) -> get()) }}</p>
      </td>

      <td class="text-center">
      <a href="{{ route('admin.client-info', ['client' => $member -> id]) }}" style="border: 2px solid; border-radius: 100px; padding: 2px 10px" class="btn btn-link btn-sm btn-rounded mr-1">
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

</x-app-layout>
