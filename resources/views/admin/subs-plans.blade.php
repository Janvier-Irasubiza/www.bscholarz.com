@section('title', 'Subscriptions')

<x-app-layout>

<x-slot name="header">
</slot>

    <div style="padding: 0px 20px 32px 20px">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="f-20 f-600">Subscriptions</h1>
                    <p class="text-muted mt-2">Palns</p>
                </div>
                <a style="" href="{{ route('md.subs') }}" class="scd-btn">View Subscribers</a>
            </div>
            
            <div class="mt-4">
                @include('components.subs-plans-nav')
            </div>

            <div class="bg-gray p-3 subs-radius">
                <div class="mb-4 mt-2">
                    <h1 class="f-18 f-500"><strong>{{ $category }}</strong> Subscription Plan</h1>
                    <p class="text-muted mt-2">Subscribers: {{ $subscribers }}</p>
                </div>
                <h1 class="f-18 f-500">Services</h1>

                <div class="d-flex gap-3 mt-2">
                    <div class="col-lg-7 border rounded px-3 py-2">
                    <p class="text-muted mt-1 f-15">All services not offered under <strong>{{ $category }}</strong> plan</p>
                    <div class="services mt-2" id="servicesContainer">
                            <!-- all services -->
                        </div>

                        <p class="text-muted mt-3 f-15">Add new service</p>
                        
                        <form id="createServiceForm" action="/subs/services/store" method="POST" class="w-full">
                            <div class="service d-flex gap-4 align-items-center mb-2">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="text" class="inputs" name="name" placeholder="Enter service name" required>
                                <div class="d-flex gap-2 align-items-center" id="actionBtns">
                                    <button type="submit" class="cst-primary-btn btn-sm w-full">Create service</button>
                                </div>
                            </div>
                        </form>
                        <div id="responseMessage" class="border"></div> 
                    </div>
                    <div class="w-full border rounded px-3 py-2">
                        <p class="text-muted mt-1 f-15">Services offered under <strong>{{ $category }}</strong> plan</p>
                        <div class="mt-2" id="availbaleServices">
                            <!-- services available under this plan -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- JavaScript (AJAX) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            loadServices(); // Call the function to load services when the page is loaded
            loadPlanServices(); // Call the function to load plan services 
        });

        function loadServices() {
            fetch('{{ route('subs-services-plan.get', ['plan' => $plan->id]) }}') // Fetch services via AJAX
                .then(response => response.json()) // Parse JSON response
                .then(data => {
                    const servicesContainer = document.getElementById('servicesContainer');
                    servicesContainer.innerHTML = ''; // Clear previous content

                    // Loop through available services (those not part of the plan) and create HTML for each one
                    data.available_services.forEach(service => {
                        const serviceDiv = document.createElement('div');
                        serviceDiv.className = 'service d-flex gap-4 align-items-center mb-2';
                        serviceDiv.innerHTML = `
                            <input type="text" class="inputs" placeholder="Service Name" value="${service.name}" id="serviceName-${service.id}">
                            <div class="d-flex gap-2 align-items-center" id="actionBtns">
                                <a href="#" class="btn btn-primary btn-sm" onclick="updateService(${service.id})">Update</a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="deleteService(${service.id})">Delete</a>
                            </div>
                            <a href="#" class="btn btn-success btn-sm" onclick="addServiceToPlan(${service.id})">Add service</a>
                        `;
                        servicesContainer.appendChild(serviceDiv);
                    });
                })
                .catch(error => console.error('Error loading services:', error));
        }

        function loadPlanServices() {
            fetch('{{ route('subs-services-plan.get', ['plan' => $plan->id]) }}') // Fetch services via AJAX
                .then(response => response.json()) // Parse JSON response
                .then(data => {
                    const servicesContainer = document.getElementById('availbaleServices');
                    servicesContainer.innerHTML = ''; // Clear previous content

                    // Loop through assigned services (those already part of the plan) and create HTML for each one
                    data.assigned_services.forEach(service => {
                        const serviceDiv = document.createElement('div');
                        serviceDiv.className = 'service d-flex gap-4 align-items-center mb-2';
                        serviceDiv.innerHTML = `
                            <input type="text" class="form-control" disabled value="${service.name}">
                            <a href="#" class="btn btn-danger btn-sm" onclick="removeServiceFromPlan(${service.id})"><i class="fa-solid fa-x"></i></a>
                        `;
                        servicesContainer.appendChild(serviceDiv);
                    });
                })
                .catch(error => console.error('Error loading plan services:', error));
        }

        function addServiceToPlan(serviceId) {
            const planId = '{{ $plan->id }}'; // Get the plan ID from the Blade template

            // Send AJAX request to add service to the plan
            fetch('{{ route('subs-service.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token for security
                },
                body: JSON.stringify({
                    service_id: serviceId,
                    plan_id: planId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Service added successfully') {
                    loadServices();
                    loadPlanServices();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error adding service to plan:', error));
        }

        function removeServiceFromPlan(serviceId) {
            const planId = '{{ $plan->id }}'; // Get the plan ID from the Blade template

            // Send AJAX request to remove service from the plan
            fetch('{{ route('subs-service.remove') }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token for security
                },
                body: JSON.stringify({
                    service_id: serviceId,
                    plan_id: planId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Service removed successfully') {
                    loadServices();
                    loadPlanServices();
                } else {
                    alert(data.message); // Handle error response
                }
            })
            .catch(error => console.error('Error removing service from plan:', error));
        }


        function updateService(serviceId) {
            const serviceName = document.querySelector(`#serviceName-${serviceId}`).value; // Get the correct input field

            fetch('{{ route('subs-service.update') }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    service_id: serviceId,
                    name: serviceName
                })
            })
            .then(response => response.json())
            .then(data => {
                loadServices();
            })
            .catch(error => console.error('Error updating service:', error));
        }


        function deleteService(serviceId) {
            if (confirm('Are you sure you want to delete this service?')) {
                fetch('{{ route('subs-service.delete') }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        service_id: serviceId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    loadServices();
                })
                .catch(error => console.error('Error deleting service:', error));
            }
        }

        document.getElementById('createServiceForm').addEventListener('submit', function(event) {
            event.preventDefault();  // Prevent form from submitting the traditional way

            // Get the form data
            let serviceName = document.querySelector('input[name="name"]').value;

            // Fetch the CSRF token from the meta tag
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Send AJAX request using fetch
            fetch('/md/subs/services/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Pass the CSRF token in the headers
                },
                body: JSON.stringify({
                    name: serviceName,
                })
            })
            .then(response => {
                if (response.status === 401) {
                    // Handle unauthorized access
                    document.getElementById('responseMessage').innerHTML = '<div class="alert alert-danger">You must be logged in to create a service</div>';
                    throw new Error('Unauthorized');
                }
                return response.json();
            })
            .then(data => {
                // Handle success response
                if (data.message) {
                    loadServices();
                    document.querySelector('input[name="name"]').value = '';
                    document.getElementById('responseMessage').innerHTML = '<div class="alert alert-success alert-sm">' + data.message + '</div>';
                }
            })
            .catch((error) => {
                // Handle other errors
                console.error('Error:', error);
                if (error.message !== 'Unauthorized') {
                    document.getElementById('responseMessage').innerHTML = '<div class="alert alert-danger">Error creating service</div>';
                }
            });
        });

    </script>


</x-app-layout>