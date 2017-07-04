@extends('admin.layouts.default')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Users</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <colgroup>
                                <col width="70"/>
                                <col width="200"/>
                                <col width=""/>
                                <col width="120"/>
                                <col width="120"/>
                                <col width="100"/>
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Income</th>
                                    <th>Expenses</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="text-right">{{ $loop->index+1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                        <td class="text-right">{{ $user->totalIncomes()->total }}</td>
                                        <td class="text-right">{{ $user->totalExpenses()->total }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-primary btn-xs" title="View Report" href="{{ route('admin.user.report', $user->id) }}"><i class="fa fa-edit fa-fw"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('plugin-styles')
    <link href="{{ asset('vendor/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables-responsive/css/dataTables.responsive.css') }}" rel="stylesheet">
@endsection

@section('plugin-scripts')
    <script src="{{ asset('vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true,
                autoWidth: false,
                order: [[ 0, 'asc' ]],
                columnDefs: [{
                    "targets": [ 5 ],
                    "orderable": false
                }]
            });
        });
    </script>
@endsection