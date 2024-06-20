@section('title', 'Organization')

<x-app-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 20px 32px 20px">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2">

    <div class="card">

    <div class="card-header-tab card-header py-3 d-flex" style="border-bottom: 1px solid rgba(0, 0, 0, 0.192)">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                    BBG - Organization</br>
                    <small class="text-muted mb-0">Bwenge Business Group - Staff</small>
                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right d-flex justify-content-end gap-3 align-items-center  col-lg-4">

                    <a href="{{ route('admin.hire') }}" style="color: ghostwhite" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn apply-btn">
                <span class="mr-2 opacity-7">
                <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                </span>
                <span class="mr-1">add employee</span>
                </a>

                    </div>
                    </div>

                    <!--<div class="col-lg-12 d-flex justify-content-center mt-3 gap-2">
                       <a href="{{ route('admin.org') }}">
                            <p class="fw-normal mb-1">
                                <span class="badge rounded-pill px-3 py-2" style="color: #000; background: #cccccc">Applications</span>
                            </p>
                        </a>

                       <a href="{{ route('admin.rba') }}">
                            <p class="fw-normal mb-1">
                                <span class="badge rounded-pill px-3 py-2" style="color: #000">Development</span>
                            </p>
                        </a> 

                    </div> -->

<div class="card-body">
<table id="" class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>Names</th>
      <th>Department</th>
      <th class="text-center">Active Status</th>
      <th class="text-center">Working status</th>
      <th class="text-center">Recordings</th>
      <th class="text-center">Review</th>
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

      <td class="text-center">
        @if($member -> working_status == 'Working')
        <span class="badge bg-success rounded-pill px-3">{{ $member -> working_status }}</span>
        
        &nbsp;
        <a data-id="{{ $member -> id }}" data-names="{{ $member ->  names }}" data-email="{{ $member ->  email }}" data-phone="{{ $member -> phone_number }}" style="border-radius: 6px; padding: 1px 10px; font-size: 12px; text-decoration: none; color: ghostwhite" class="btn btn-danger btn-sm btn-rounded mr-1 assistantInfo" data-toggle="modal" data-target="#seek" >Invalidate</a>

        @else
        <span class="badge bg-danger rounded-pill px-3">{{ $member -> working_status }}</span> &nbsp;
        <a href="{{ route('admin.validate-emp', ['assistant' => $member -> id]) }}" style="border-radius: 6px; padding: 1px 10px; font-size: 12px; text-decoration: none; color: ghostwhite" class="btn btn-success btn-sm btn-rounded mr-1 assistantInfo">Validate</a>

        @endif


          <!-- Modal -->
          <div class="modal fade" id="seek" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog w-mdal modal-dialog-centered d-flex align-items-center" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title" style="text-align: left" id="staticBackdropLabel"></h5>
                                <small style="font-size: 14px;" class="text-muted mb-0"> <span class="email"></span> - <span class="phone-number"> </span></small>
                            </div>                            

                            <button type="button" class="close btn btn-danger" style="border: 3px solid;" data-dismiss="modal" aria-label="Close">
                                <span style="color: #000" aria-hidden="true" class="fa fa-times"></span>
                            </button>

                        </div>
                        
                        <form action="{{ route('admin.invalidate-emp') }}" method="post" class="space-y-2" >   @csrf                     

                        <div class="modal-body">
                        
                          <input style="padding: 6px 10px; text-align: left; border: 1px solid #00000050; color: #808080; border-radius: 4px" name="assistant" id="assistant" class="block mt-1 w-full input-holder assistant" hidden/>

                      <div class="mt-4 w-full">
                            <x-input-label for="issue" style="text-align: left" class="text-left w-full" :value="__('Reason')" />
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Reson of invalidation</p>
                            <input placeholder="Type reason here..." id="reply_input" name="reason" class="block w-full" style="border: 2px solid #000; border-radius: 6px; padding: 6px; font-size: 14px" required />
                          <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                        </div>

                        <div class="mt-4 w-full">
                            <x-input-label for="issue" style="text-align: left" class="text-left w-full" :value="__('Decision')" />
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Decision of invalidation</p>
                            <input placeholder="Type decision here..." id="reply_input" name="decision" class="block w-full" style="border: 2px solid #000; border-radius: 6px; padding: 6px; font-size: 14px" required />
                          <x-input-error :messages="$errors->get('decision')" class="mt-2" />
                        </div>

                        <div class="mt-4 mb-2 text-right d-flex justify-content-end">
                            <button type="submit" id="send_btn" style="padding: 5px 30px; font-size: 13px; font-weight: 600; color: ghostwhite; text-transform: uppercase" class="btn apply-btn">Invalidate</button>
                        </div>
                        </div>
                        </form>
                        </div>
                    </div>
                    </div>
                    <!-- </> modal -->


      </td>

      <td class="text-center">
      <a href="{{ route('admin.sheet', ['assistant' => $member -> id]) }}" style="border-radius: 6px; padding: 1px 10px; text-decoration: none; color: ghostwhite" class="btn btn-link btn-sm btn-rounded mr-1 apply-btn">
      Open sheet
            </a>
      </td>

      <td class="text-center">
      <a href="{{ route('admin.member', ['member' => $member -> id]) }}" style="border: 2px solid; border-radius: 100px; padding: 2px 10px" class="btn btn-link btn-sm btn-rounded mr-1">
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

<script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>


<script>


  $(document).ready(function () {
      $(document).on('click', '.assistantInfo', function () {
        $('.modal-title').html($(this).attr('data-names'));
        $('.email').html($(this).attr('data-email'));
        $('.phone-number').html($(this).attr('data-phone'));
        $('.assistant').val($(this).attr('data-id'));
        });
    });

</script>

</x-app-layout>
