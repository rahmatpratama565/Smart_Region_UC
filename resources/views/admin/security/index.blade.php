@extends('layouts.admin')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0 text-primary">

            <i class="fa fa-shield-halved"></i>
            Security Login Logs

        </h5>

    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>No</th>
                        <th>Username</th>
                        <th>IP Address</th>
                        <th>Status</th>
                        <th>Attempt</th>
                        <th>Blocked</th>
                        <th>Waktu</th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($logs as $log)

                    <tr>

                        <td class="fw-bold">
                            {{ $loop->iteration }}
                        </td>


                        <td>
                            <i class="fa fa-user text-secondary"></i>
                            {{ $log->username }}
                        </td>


                        <td>

                            <span class="badge bg-light text-dark border">

                                <i class="fa fa-network-wired"></i>
                                {{ $log->ip_address }}

                            </span>

                        </td>


                        <td>

                            @if($log->status == 'failed')

                            <span class="badge bg-danger">

                                <i class="fa fa-times-circle"></i>
                                Failed

                            </span>

                            @else

                            <span class="badge bg-success">

                                <i class="fa fa-check-circle"></i>
                                Success

                            </span>

                            @endif

                        </td>


                        <td>

                            <span class="badge bg-warning text-dark">

                                {{ $log->attempt_count }}

                            </span>

                        </td>


                        <td>

                            @if($log->blocked)

                            <span class="badge bg-dark">

                                <i class="fa fa-lock"></i>
                                Blocked

                            </span>

                            @else

                            <span class="text-muted">-</span>

                            @endif

                        </td>


                        <td>

                            <i class="fa fa-clock text-muted"></i>

                            {{ $log->created_at }}

                        </td>


                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection