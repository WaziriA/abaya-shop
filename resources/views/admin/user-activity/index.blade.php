@extends('admin.layout')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <p class="mb-0">User Activities</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">User Activities</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Activities</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>User Role</th>
                                        <th>Title</th>
                                        <th>Device Type</th>
                                        <th>Browser</th>
                                        <th>Brand</th>
                                        <th>OS</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notifications as $notification)
                                        @php
                                            $data = json_decode($notification->data, true);
                                        @endphp
                                        <tr>
                                            <td>{{ $notification->user_name ?? 'N/A' }}</td>
                                            <td>{{ $notification->user_role ?? 'N/A' }}</td>
                                            <td>{{ $data['title'] ?? 'N/A' }}</td>
                                            <td>{{ $notification->device_type }}</td>
                                            <td>{{ $notification->browser }}</td>
                                            <td>{{ $notification->brand }}</td>
                                            <td>{{ $notification->os }}</td>
                                            <td class="utc-time">{{ $notification->created_at }}</td>
                                            <td>
                                                <a href="{{ route('user.activities.details', ['id' => $notification->user_id, 'month' => $createdAt->format('Y-m')]) }}" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-eye text-white"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>User Name</th>
                                        <th>User Role</th>
                                        <th>Title</th>
                                        <th>Device Type</th>
                                        <th>Browser</th>
                                        <th>Brand</th>
                                        <th>OS</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const utcTimes = document.querySelectorAll('.utc-time');

        utcTimes.forEach((element) => {
            // Convert the 'created_at' timestamp to a Date object
            const utcDate = new Date(element.textContent + 'Z'); // Ensure UTC format by appending 'Z'

            // Set time format options for the local time zone
            const options = { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric', 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit',
                timeZoneName: 'short'
            };

            // Convert to local time
            const localDate = utcDate.toLocaleString(undefined, options);

            // Update the table cell with the local date and time
            element.textContent = localDate;
        });
    });
</script>



@endsection
