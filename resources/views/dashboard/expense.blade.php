@foreach($currentUser->categories as $category)
<!--START PANEL TABLE-->
<div class="panel panel-bordered panel-default data-table panel-expense-table" data-hash="{{ $category->hash }}" style="z-index:1;">
    <div class="panel-heading">
        <h3 class="panel-title">{{ $category->name }}</h3>
        <div class="panel-actions">
            <div class="dropdown">
                <a class="dropdown-toggle panel-action" data-toggle="dropdown" href="#" aria-expanded="false"><i class="icon wb-settings" aria-hidden="true"></i></a>
                <ul class="dropdown-menu bullet" role="menu">
                    <li role="presentation"><a class="add-category" role="menuitem"><i class="icon wb-plus-circle" aria-hidden="true"></i>Create New Category</a></li>
                    <li role="presentation"><a class="add-item" role="menuitem"><i class="icon wb-plus" aria-hidden="true"></i>Create New Expense</a></li>
                    <li role="presentation"><a class="delete-category" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>Delete Category</a></li>
                </ul>
            </div>
            <!--<a class="panel-action icon wb-plus" aria-expanded="true" aria-hidden="true"></a>-->
            <a class="panel-action icon wb-chevron-up" aria-expanded="true" data-toggle="panel-collapse" aria-hidden="true"></a>
        </div>
    </div>
    <div class="panel-body">
        <table class="editable-table table table-hover edit-table-selector edit-table-selector-expense" style="cursor: pointer;">
            <thead style="opacity:0">
            <tr>
                <th></th>
                @foreach($rowFields as $key => $field)
                    <th>{{ $field }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
                @if($category->expenses)
                    @foreach($category->expenses as $expense)
                        <tr data-hash="{{ $expense->hash }}">
                            <td tabindex="1" class="created-name">{{ $expense->name }}</td>

                            @foreach($rowFields2 as $key => $field)
                                <td tabindex="1" class="income-data" data-key="{{ $key }}">{{ number_format($expense->$key, 2) }}</td>
                            @endforeach

                            <td>{{ number_format($expense->total, 2) }}</td>
                            <td>{{ number_format($expense->avg, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
            <tr>
                <th>Total</th>

                @foreach($category->totalExpenses() as $key => $field)
                    <th>{{ number_format($category->totalExpenses()->$key, 2) }}</th>
                @endforeach
            </tr>
            </tfoot>
        </table>
        <input style="position: absolute; top: 68px; left: 1254px; padding: 8px; text-align: start; font-style: normal; font-variant: normal; font-weight: 300; font-stretch: normal; font-size: 14px; line-height: 22px; font-family: Roboto, sans-serif; width: 301px; height: 40px; display: none; border-width: 1px 0px 0px; border-style: solid none none; border-color: rgb(228, 234, 236) rgb(118, 131, 143) rgb(118, 131, 143);">
    </div>
</div>
<!--END PANEL TABLE-->
@endforeach