@section('title', 'Success')

<x-apply-layout>

  <div class="client-body padding mt-2 mb-5 d-flex justify-content-center align-items-center">

    <div class="flex-section gap-5 justify-content-center align-items-center mt-5 mb-5 p-3"
      style="padding-bottom: 50px !important;">

      <div class="w-full">

        <div class="d-flex justify-content-center align-items-center p-3 gap-4" style="">
          <i class="fa-solid fa-circle-check action-success-icon"></i>
          <div class="text-left mt-3">
            <h1 style="font-size: 30px" class="mb-2">Payment Successful!</h1>
            <strong>Your request has been successfully received by BScholarz.</strong> <br /> <br />
          </div>
        </div>

        <div class="container text-center mt-3" style="padding: 5px 0px;">
          <p style="font-size: 16px">
          <div>You'll be contacted for further application processes via the phone number and email you provided.</div>
          <div class="mt-3">For a better experience, Go to

            <a href="{{ route('client.client-dashboard', ['plb' => request('plb')]) }}" id="newSetPassword"
              style="text-transform: uppercase; font-weight: 600; font-size: 12px; background: none; border: none"
              class="underline text-sm hover:text-gray-900 dark:hover:text-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
              my dashboard
            </a>

          </div>
          </p>
        </div>

        <div class="mt-4 d-flex justify-content-center" style="">
          <a style="text-transform: uppercase; color: ghostwhite; font-weight: 600; font-size: 12px"
            class="btn-secondary btn" href="{{ route('home') }}" style="border: none">
            explore more
          </a>
        </div>
      </div>

      <!-- Replace the Transaction Info section with a well-designed Contacts section -->
      <div class="w-full border overflow-hidden sm:rounded-lg text-center p-5 mt-5"
        style="border: 1px solid #eee !important;">
        <h1 style="font-size: 30px">Contact Us</h1>
        <div class="contact-details mt-4">
          <p><i class="fa-solid fa-phone"></i> <strong>Phone:</strong> +250 786 981 832</p>
          <p><i class="fa-solid fa-envelope"></i> <strong>Email:</strong> bscholarz.rw@gmail.com</p>
          <p><i class="fa-solid fa-location-dot"></i> <strong>Address:</strong> KN 20 AVE, Kigali City - Rwanda</p>
        </div>
        <div class="social-links mt-4">
          <p>Follow us on:</p>
          @include('components.social-media')
        </div>
      </div>

    </div>

    <div class="w-full" style="position: fixed; bottom: 0px; left: 0px ">
      @include('layouts.full-footer')
    </div>
  </div>

  <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>

  @if($errors->isNotEmpty())
    <script>
    $(window).on('load', function () {
      $('.set-password').toggleClass('show');
      $('.set-password-btn').toggleClass('show');
      $('.home-btn').toggleClass('hide');
    });
    </script>
  @endif

  <script>
    let setNewPassword = document.getElementById('newSetPassword');

    setNewPassword.addEventListener('click', function () {
      $('.set-password').toggleClass('show');
      $('.set-password-btn').toggleClass('show');
      $('.home-btn').toggleClass('hide');
    });
  </script>

</x-apply-layout>