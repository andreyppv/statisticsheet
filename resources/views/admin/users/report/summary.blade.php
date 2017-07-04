<?php
//$totalIncomes = $selectedUser->totalIncomes();
$totalExpenses = $selectedUser->totalExpenses();
?>

<div class="fixed-area">
    <section class="boxes">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <!--START PANEL TABLE-->
                    <div class="panel panel-bordered summary-data-table" id="panel-summary-table">
                        <div class="panel-heading padding-horizontal-15">
                            <h3 class="panel-title summary-title">SUMMARY</h3>
                            <table class="editable-table table margin-bottom-0 ">
                                <thead>
                                    <tr>
                                        <th></th>

                                        @foreach($rowFields as $key => $field)
                                            <th>{{ $field }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="panel-body">
                            <table class="editable-table table table-hover " id="summary-data" style="cursor: pointer;">
                                <thead style="opacity:0">
                                    <tr>
                                        <th>Summary</th>

                                        @foreach($rowFields as $key => $field)
                                            <th>{{ $field }}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Total Income</td>
                                        @foreach($rowFields as $key => $field)
                                            <td>{{ number_format($totalIncomes->$key, 2) }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>Total Expenses</td>
                                        @foreach($rowFields as $key => $field)
                                            <td>{{ number_format($totalExpenses->$key, 2) }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>NET (Income - Expenses)</td>
                                        @foreach($rowFields as $key => $field)
                                            <td>{{ number_format($totalIncomes->$key - $totalExpenses->$key, 2) }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>Projected End Balance</td>
                                        @foreach($rowFields as $key => $field)
                                            <td>{{ number_format(0, 2) }}</td>
                                        @endforeach
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--END PANEL TABLE-->

                </div>
            </div>
        </div>

        <div class="clearfix">
            <hr>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <!--START PANEL TABLE-->
                    <div class="panel panel-bordered  reference-panel" id="data-table">
                        <div class="panel-body">
                            <table class="editable-table table table-hover  reference-table">
                                <thead>
                                    <tr>
                                        <th></th>

                                        @foreach($rowFields as $key => $field)
                                            <th>{{ $field }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!--END PANEL TABLE-->

                </div>
            </div>
        </div>
    </section>
</div>