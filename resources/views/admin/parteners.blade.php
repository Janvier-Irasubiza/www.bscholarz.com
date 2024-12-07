@section('title', 'Parteners')

<x-app-layout>

  <x-slot name="header"> </x-slot>

    <div style="padding: 0px 20px 32px 20px">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2">

        <div class="card">

          <div class="card-header-tab card-header py-3 d-flex" style="border-bottom: 1px solid rgba(0, 0, 0, 0.192)">
            <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">

              <div class="d-flex gap-3 align-items-center">
                <div>
                  <a href="{{ route('admin.org') }}" class="d-flex gap-1 align-items-center back-btn"
                    style="font-size: 14px"> <span class="fa-solid fa-angle-left"
                      style="font-size: 16px; color: #595959"></span> Staff</a>
                </div>

                <div>

                  BBG - Organization</br>
                  <small class="text-muted mb-0">Bwenge Business Group - Parteners</small>

                </div>

              </div>

            </div>
            <!-- <div class="btn-actions-pane-right text-capitalize text-right d-flex justify-content-end gap-3 align-items-center  col-lg-4">

                    <a href="{{ route('admin.hire') }}" style="color: ghostwhite"
                        class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn apply-btn">
                        <span class="mr-2 opacity-7">
                            <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                        </span>
                        <span class="mr-1">add employee</span>
                    </a>

                </div> -->
          </div>

          <div class="card-body">


            <div class="">

              <div class="container px-0">
                <div class="flex-section gap-3">

                  @foreach($parteners as $partener)

                  <div class="w-full">
                  <div class="info-div">

                    <div class="d-flex justify-content-start">
                    <div class="d-flex gap-5 align-items-center">
                      <div>
                      <img class="saying-pp-cst"
                        src="{{ asset('profile_pictures') }}/{{ $partener->profile_picture }}" id="output"
                        alt="Profile">
                      </div>

                      <div class="w-full">
                      <h5 class="modal-title" id="staticBackdropLabel">

                        <div class="widget-subheading">
                        <p class="mb-0" style="font-size: 25px"> {{ $partener->names }} </p>
                        </div>
                        <p class="text-muted mb-0"> {{ $partener->email }} </p>
                        <p class="text-muted mb-0"> {{ $partener->phone_number }} </p>

                      </h5>
                      </div>
                    </div>


                    </div>

                    <div class="card-footer mt-3 py-3 pb-0 flex-section justify-content-between align-items-center"
                    style="border-top: 1px solid #00000023">

                    <div>
                      <div class="">
                      <div class="widget-subheading">A partner since: </div> {{ $partener->created_at }}
                      </div>

                      <!-- <div class="d-flex mt-3 gap-2">

          @if($partener -> partenership_status == 'Valid')
          <span class="badge bg-success rounded-pill px-3 py-2">{{ $partener -> partenership_status }}</span> &nbsp;
          <a data-id="{{ $partener ->  id }}" data-names="{{ $partener ->   names }}" data-email="{{ $partener ->   email }}" data-phone="{{ $partener ->  phone_number }}" style="border-radius: 6px; padding: 4px 15px; font-size: 12px; text-decoration: none; color: ghostwhite" class="btn btn-danger btn-sm btn-rounded mr-1 assistantInfo" data-toggle="modal" data-target="#invalidate" >Invalidate</a>

          @else
          <span class="badge bg-danger rounded-pill px-3 py-2">{{ $partener -> partenership_status }}</span> &nbsp;
          <a href="{{ route('admin.validate-partner', ['partner' => $partener -> id]) }}" style="border-radius: 6px; padding: 4px 15px; font-size: 12px; text-decoration: none; color: ghostwhite" class="btn btn-success btn-sm btn-rounded mr-1 assistantInfo">Validate</a>

          @endif
          </div> -->
                    </div>

                    <div class="btn-actions-pane-right d-flex flex-row-reverse align-items-center text-capitalize">

                      <div class="widget-chart-content ml-2 px-3">
                      <div class="widget-subheading">Balance <small>(RWF)</small></div>

                      <div class="widget-numbers text-success"><span style="font-weight: 600; font-size: 30px">
                        {{ number_format(round($partener->pending_amount)) }} </span></div>

                      <button class="assistantInfo" id="disburse" data-id="{{ $partener->id }}"
                        data-names="{{ $partener->names }}" data-email="{{ $partener->email }}"
                        data-phone="{{ $partener->phone_number }}"
                        data-amount="{{ $partener->pending_amount }}" data-toggle="modal"
                        data-target="#invalidate">
                        <p class="fw-normal mb-1">
                        <span class="badge bg-success px-3 py-2" style="border-radius: 6px;">Disburse</span>
                        </p>
                      </button>

                      </div>

                    </div>

                    </div>
                  </div>


                  </div>



          @endforeach


                </div>
              </div>



            </div>

          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="invalidate" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog w-mdal modal-dialog-centered d-flex align-items-center" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <div>
                <h5 class="phone-number contact" style="text-align: left; font-size: 25px; font-weight: 600"
                  id="staticBackdropLabel"></h5>
                <small style="font-size: 17px;" class="mb-0"><span class="modal-title names"> </span> <br> <span
                    style="font-size: 14px" class="text-muted email"></span></small>
              </div>

              <button type="button" class="close btn btn-danger" style="border: 3px solid;" data-dismiss="modal"
                aria-label="Close">
                <span style="color: #000" aria-hidden="true" class="fa fa-times"></span>
              </button>

            </div>

            <div class="modal-body">

              <div class="d-flex mt-2 gap-5">

                <div class="">
                  <form action="{{ route('admin.disburse-full-to-partner') }}" method="post" class="space-y-2"> @csrf
                    <x-input-label for="issue" style="text-align: left" class="text-left w-full" :value="__('Pay in full')" />
                    <input
                      style="padding: 6px 10px; text-align: left; border: 1px solid #00000050; color: #808080; border-radius: 4px"
                      name="partner" id="assistant" class="block mt-1 w-full input-holder assistant" hidden />
                    <input
                      style="padding: 6px 10px; text-align: left; border: 1px solid #00000050; color: #808080; border-radius: 4px"
                      name="full_amount" id="full_amount" class="block mt-1 w-full input-holder assistant" hidden />
                    <div class="widget-numbers text-success mt-0 mb-0"><span style="font-weight: 600; font-size: 30px"
                        class="amount"></span></div>
                    <button type="submit" id="send_btn"
                      style="padding: 5px 30px; font-weight: 600; color: ghostwhite; text-transform: uppercase; font-weight: bold; font-size: 10px; "
                      class="btn apply-btn mt-2">Disburse</button>
                  </form>
                </div>

                <div class="w-full">
                  <form action="{{ route('admin.disburse-partial-to-partner') }}" method="post" class="space-y-2"> @csrf
                    <x-input-label for="issue" style="text-align: left" class="text-left w-full" :value="__('Pay in installments')" />
                    <input
                      style="padding: 6px 10px; text-align: left; border: 1px solid #00000050; color: #808080; border-radius: 4px"
                      name="partner" id="assistant" class="block mt-1 w-full input-holder assistant" hidden />
                    <input placeholder="Enter amount to disburse here..." id="reply_input" name="partial_amount"
                      class="block mt-1 w-full"
                      style="border: 2px solid #000; border-radius: 6px; padding: 6px; font-size: 14px" required />
                    <div class="mt-3 mb-2 text-right d-flex justify-content-end">
                      <button type="submit" id="send_btn"
                        style="padding: 5px 30px; font-size: 10px; font-weight: 600; color: ghostwhite; text-transform: uppercase; font-weight: bold"
                        class="btn apply-btn">Disburse</button>
                    </div>
                  </form>
                </div>


              </div>
              <x-input-error :messages="$errors->get('reason')" class="mt-2 text-left" />

            </div>
          </div>
        </div>
      </div>
      <!-- </> modal -->

      <div class="flex-section gap-3">

        @foreach($parteners as $key => $partner)
      <div class="w-full card mt-3">



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
          <p class="fw-bold mb-1">{{ number_format($record->paid_amount) }} <small>RWF</small></p>
          <p class="text-muted mb-0" style="font-size: 15px"> Disbursed on: {{ $record->paid_at }} </p>
          </div>

          <div class="text-right w-full" style="padding: 0px 5px">
          <p class="text-muted mb-0" style="font-size: 15px"> Outstanding amount:
          {{ number_format($record->outstanding_amount) }} <small>RWF</small> </p>
          </div>
        </div>
        </td>
        </tr>

      @endforeach

          </tbody>
        </table>

        </div>
      </div>
    @endforeach
      </div>

      <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>

      <script>

        $(document).ready(function () {
          $(document).on('click', '.assistantInfo', function () {
            $('.names').html($(this).attr('data-names'));
            $('.email').html($(this).attr('data-email'));
            $('.contact').html($(this).attr('data-phone'));
            $('.assistant').val($(this).attr('data-id'));
            $('.amount').html($(this).attr('data-amount'));
            $('#full_amount').val($(this).attr('data-amount'));
          });
        });

      </script>

</x-app-layout>