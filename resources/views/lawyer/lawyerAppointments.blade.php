@extends('layouts.main')

@section('title', 'Lawyer Appointments')

@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('css/user-appointments.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">My Appointments</h1>

        @if ($appointments->isEmpty())
            <div class="alert alert-info text-center">
                You have no appointments yet.
            </div>
        @else
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">User</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Gender</th>
                        <th scope="col">DOB</th>
                        <th scope="col">Lawyer</th>
                        <th scope="col">Date & Time</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $index => $appointment)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $appointment->user->name }}</td>
                            <td>{{ $appointment->user->email }}</td>
                            <td>{{ $appointment->user->phoneNumber }}</td>
                            <td>{{ $appointment->user->gender }}</td>
                            <td>{{ $appointment->user->dob }}</td>
                            <td>{{ $appointment->lawyer->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->dateTime)->format('F j, Y g:i A') }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $appointment->status === 'completed' ? 'success' : ($appointment->status === 'pending' ? 'warning' : 'primary') }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td>
                                @if ($appointment->status === 'Pending')
                                    <form
                                        action="{{ route('updateAppointmentStatus', ['userId' => $appointment->user->id, 'lawyerId' => $appointment->lawyer->id, 'newStatus' => 'Confirmed']) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary">Confirm Booking</button>
                                    </form>
                                @elseif ($appointment->status === 'Confirmed')
                                    <form
                                        action="{{ route('updateAppointmentStatus', ['userId' => $appointment->user->id, 'lawyerId' => $appointment->lawyer->id, 'newStatus' => 'Completed']) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success">Complete Booking</button>
                                    </form>
                                @elseif ($appointment->status === 'Completed')
                                    <button class="btn btn-secondary" disabled>Completed Booking</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection