<?php
$incomes = $selectedUser->incomes()
    ->where('year', $selectedUser->getDataYear())
    ->orderBy('priority')
    ->orderBy('created_at')
    ->get();
//$totalIncomes = $currentUser->totalIncomes();
?>

<div class="panel panel-bordered panel-success panel-income-table data-table">
    <div class="panel-heading">
        <h3 class="panel-title">INCOME</h3>
        <div class="panel-actions">
            <a class="panel-action icon wb-chevron-up" aria-expanded="true" data-toggle="panel-collapse" aria-hidden="true"></a>
        </div>
    </div>
    <div class="panel-body">
        <table class="editable-table table table-hover edit-table-selector-income" style="cursor: pointer;">
            <thead style="opacity:0">
                <tr>
                    <th>INCOME</th>

                    @foreach($rowFields as $key => $field)
                        <th>{{ $field }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>

                @foreach($incomes as $incomeRow)
                <tr data-hash="{{ $incomeRow->hash }}">
                    <td tabindex="1">{{ $incomeRow->name }}</td>

                    @foreach($rowFields2 as $key => $field)
                        <td tabindex="1" class="income-data" data-key="{{ $key }}">{{ number_format($incomeRow->$key, 2) }}</td>
                    @endforeach

                    <td>{{ number_format($incomeRow->total, 2) }}</td>
                    <td>{{ number_format($incomeRow->avg, 2) }}</td>
                </tr>
                @endforeach


            </tbody>
            <tfoot>
            <tr>
                <th>Total</th>

                @foreach($rowFields as $key => $field)
                    <th>{{ number_format($totalIncomes->$key, 2) }}</th>
                @endforeach
            </tr>
            </tfoot>
        </table>
        <input style="position: absolute; top: 68px; left: 1254px; padding: 8px; text-align: start; font-style: normal; font-variant: normal; font-weight: 300; font-stretch: normal; font-size: 14px; line-height: 22px; font-family: Roboto, sans-serif; width: 301px; height: 40px; display: none; border-width: 1px 0px 0px; border-style: solid none none; border-color: rgb(228, 234, 236) rgb(118, 131, 143) rgb(118, 131, 143);">
    </div>
</div>