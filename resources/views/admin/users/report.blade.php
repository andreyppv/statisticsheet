@extends('admin.layouts.front')

@section('content')

    <?php
        $rowFields = report_fields();
        $rowFields2 = report_fields(false);
        $totalIncomes = $selectedUser->totalIncomes();
    ?>


    <!--start summary table -->
    @include('admin.users.report.summary')
    <!--end summary table -->

    <!--start data table -->
    <div class="fixed-area-bottom">
        <section class="data-tables">
            <div class="container">
                <div class="row">
                    <div id="data-table-list" class="col-lg-12">

                        <!--start income table -->
                        @include('admin.users.report.income')
                        <!--end income table -->

                        <!--start expense tables -->
                        @include('admin.users.report.expense')
                        <!--end expense tables -->

                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--end data table -->

@endsection