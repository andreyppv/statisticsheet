@extends('layouts.default')

@section('content')

    <?php
        $rowFields = report_fields();
        $rowFields2 = report_fields(false);
        $totalIncomes = $currentUser->totalIncomes();
    ?>


    <!--start summary table -->
    @include('dashboard.summary')
    <!--end summary table -->

    <!--start data table -->
    <div class="fixed-area-bottom">
        <section class="data-tables">
            <div class="container">
                <div class="row">
                    <div id="data-table-list" class="col-lg-12">

                        <!--start income table -->
                        @include('dashboard.income')
                        <!--end income table -->

                        <!--start expense tables -->
                        @include('dashboard.expense')
                        <!--end expense tables -->

                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--end data table -->

@endsection

@section('additional')
    @include('dashboard.delete_confirm_modal')
    @include('dashboard.expense_clone_model')
@endsection

@section('scripts')
    <script src="{{ asset('vendor/plugins/mindmup-editabletable.js') }}"></script>
    <script src="{{ asset('vendor/plugins/numeric-input-example.js') }}"></script>

    <script>
        window.addCategoryUrl = '{{ route('service.category.add') }}';
        window.updateCategoryUrl = '{{ route('service.category.update') }}';
        window.removeCategoryUrl = '{{ route('service.category.remove') }}';

        window.addItemUrl = '{{ route('service.item.add') }}';
        window.updateItemUrl = '{{ route('service.item.update') }}';
        window.removeItemUrl = '{{ route('service.item.remove') }}';
        window.updateItemMonthUrl = '{{ route('service.item.month.update') }}';
    </script>
    <script src="{{ asset('js/pages/dashboard/index.js') }}"></script>
@endsection