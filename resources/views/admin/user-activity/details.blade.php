@extends('admin.layout')
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <p class="mb-0">User Activities for {{ $user->name }} (Month: {{ $month }})</p>
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
                        <h4 class="card-title">All Activities for {{ $user->name }}</h4>
                    </div>

                    <div class="card-body">
                        @if($activities->isEmpty())
                            <p>No activities found for this user in this month.</p>
                        @else
                            @php
                                $previousDate = null;
                            @endphp
                    
                            @foreach($activities as $activity)
                                @php
                                    $activityDate = \Carbon\Carbon::parse($activity->created_at)->format('Y-m-d');
                                    $notificationData = json_decode($activity->data);
                                    $changes = $notificationData->details->changes ?? []; // Extract changes if available
                                @endphp
                    
                                {{-- Display a date separator if the date has changed --}}
                                @if($previousDate !== $activityDate)
                                    @if($previousDate !== null)
                                        <hr>
                                    @endif
                                    <h5>{{ \Carbon\Carbon::parse($activityDate)->format('F j, Y') }}</h5>
                                    @php
                                        $previousDate = $activityDate;
                                    @endphp
                                @endif
                    
                                <div>
                                    <strong>User Name:</strong> {{ $activity->user_name ?? 'N/A' }} <br>
                                    <strong>Device Type:</strong> {{ $activity->device_type }} <br>
                                    <strong>Browser:</strong> {{ $activity->browser }} <br>
                                    <strong>Device Operating System:</strong> {{ $activity->os }}
                                    <br>
                                    <small class="text-muted utc-time">{{ \Carbon\Carbon::parse($activity->created_at)->toDateTimeString() }}</small>
                                    <p>
                                        <strong>Title:</strong> {{ $notificationData->title ?? 'No title' }} <br>
                                        <strong>Message:</strong> {{ $notificationData->message ?? 'No message' }}
                                    </p>
                                    
                                    {{-- Display field changes --}}
                                    @if(!empty($changes))
                                        <strong>Changes:</strong>
                                        <ul>
                                            @foreach($changes as $change)
                                                <li>
                                                    <strong>{{ ucfirst($change->field) }}:</strong> 
                                                    <em>Before:</em> {{ $change->before ?? 'N/A' }}, 
                                                    <em>After:</em> {{ $change->after ?? 'N/A' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>No changes recorded.</p>
                                    @endif
                                </div>
                                <br>
                            @endforeach
                            <hr>
                        @endif
                    
                        <hr>
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
