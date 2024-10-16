@section('title', 'Dashboard')

<x-accountant-layout>
    <x-slot name="header">
    </x-slot>

    <div style="padding: 0px 20px 32px 20px">


    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
        <div class="app-inner-layout__content">
        <div class="tab-content">
        <div>
        <div class="card">
        <div class="card-header-tab card-header py-3 d-flex">
        <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
        <strong>Outstanding Clients</strong>
        </div>
        <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">


        </div>
        </div>
        <div style="border-top: none" class="d-block p-3 card-footer">

<table class="table align-middle mb-0 bg-white" id="example1">
<thead class="bg-light">
<tr>
<th>Applicant Info</th>
<th>Application Info</th>
<th>Amount & Date</th>
<th class="text-center">Actions</th>
</tr>
</thead>
<tbody>


<tr>
<td>
<div class="d-flex align-items-center" style="margin: 0px">
<div class="" style="padding: 0px 5px">
<p class="fw-bold mb-1">Name</p>
<p class="text-muted mb-0">email <br> phone</p>
</div>
</div>
</td>
<td>
<div class="d-flex align-items-center" style="margin: 0px">
<div class="" style="padding: 0px 5px">
<p class="fw-bold mb-1">discipline_name </p>
<p class="text-muted mb-0">discipline_organization - discipline_country </p>
</div>
</div>
</td>
<td>

<p class="fw-normal mb-1"><strong>outstanding_amount</strong> <br> served_on </p>
</td>
<td class="text-center">
<div class="d-flex align-items-center justify-content-center">

    <div class="action-btn mr-1">
        <button type="button" class="btn btn-link btn-sm btn-rounded action-btn debtorId" style="text-decoration: none; background-color: #0D6EFD; color: white; border-radius: 20px;">
            Poke <i class="fa-solid fa-hand-point-right" style="transform: rotate(-45deg)"></i>
        </button>
    </div>


<div class="action-btn ml-1">
<button type="button" class="btn btn-link btn-sm btn-rounded clientId" value="application_id" style="text-decoration: none; background-color: #80ffaa; color: black; border-radius: 20px;">
    Paid <i class="fa-regular fa-square-check" style=""></i>
</button>
</div>
</div>
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

    </div>

</x-accountant-layout>
