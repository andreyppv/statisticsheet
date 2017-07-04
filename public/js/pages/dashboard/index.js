$(document).ready(function() {

    // update view
    changeView()
    $(window).resize(function() {
        changeView()
    });

    // menu functions of expense category tables
    editTable();

    // --hide panel
    $(document).on("click", '#data-table-list [data-toggle="panel-collapse"]', function() {
        var $this = $(this);
        $panelparent = $this.closest('.panel');
        $panel = $this.closest('.panel').children('.panel-body');
        if (!$panelparent.hasClass('is-collapsedown')) {
            $panelparent.addClass('is-collapsedown');
            $panel.slideUp()
            if ($this.hasClass('wb-chevron-up')) {
                $this.removeClass('wb-chevron-up').addClass('wb-chevron-down');
            }
        } else {
            $panelparent.removeClass('is-collapsedown');
            $panel.slideDown()
            if ($this.hasClass('wb-chevron-down')) {
                $this.removeClass('wb-chevron-down').addClass('wb-chevron-up');
            }
        }
    });

    // -- add category
    $(document).on('click', '#data-table-list .panel-expense-table .panel-actions .add-category', function() {
        var table = $('#expenseCloneTable').clone();
        table.removeAttr('id').data('hash', stringGen(32));
        $('#data-table-list').append(table);

        editTable();

        ajaxRequest(
            window.addCategoryUrl,
            {'hash': table.data('hash')},
            function() {
                setTimeout(function() {
                    var offsetAnimation = $('#data-table-list .panel-expense-table:last-child').offset().top;

                    var body = $("html, body");
                    body.stop().animate({
                        scrollTop: offsetAnimation
                    }, '500', 'swing', function() {
                    });

                }, 500);
            }
        );
    });

    // -- add item
    $(document).on('click', '#data-table-list .panel-expense-table .panel-actions .add-item', function() {
        var panel = $(this).parents('.panel-expense-table');
        var table = $(this).parents('.panel-expense-table').find('table.editable-table');

        var row = $('#expenseRowTamplte').clone();
        row.removeAttr('id');
        row.data('hash', stringGen(32));
        $('tbody', table).append(row);

        editTable();

        ajaxRequest(
            window.addItemUrl,
            {
                'category_hash': panel.data('hash'),
                'hash': row.data('hash'),
                'type': 'expense'
            }
        );
    });

    // -- delete category
    var $selectedPanel = null;
    $(document).on('click', '#data-table-list .panel-expense-table .panel-actions .delete-category', function(e) {
        if($('#data-table-list .panel-expense-table').length <= 1) {
            alert('You have to keep at least one category.');
        } else {
            $("#input-delete-group").val('');
            $selectedPanel = $(this).parents('.data-table.panel-expense-table');

            $('#change-background-image').modal('show');
        }
    });

    $("#input-delete-group").keyup(function() {
        var btnDelete = $('#delete-group-button'),
            inputValue = $(this).val();

        if (inputValue === 'DELETE' || inputValue === 'Delete') {
            btnDelete.removeAttr("disabled")
        } else {
            btnDelete.attr('disabled', true);
        }
    });

    $('#delete-group-button').click(function() {
       if($selectedPanel != null) {
           $('#change-background-image').modal('hide');

           setTimeout(function() {
               $selectedPanel.slideUp(function() {
                   ajaxRequest(
                       window.removeCategoryUrl,
                       {'hash': $selectedPanel.data('hash')},
                       function() {
                           $selectedPanel.remove();

                           UpdateExpenses();
                           UpdateNET();
                       }
                   );
               });
           }, 500);
       }
    });

    // -- edit category name and item name
    var replaceWith = $('<input class="temp" type="text" />'),
        connectWith = $('input[name="hiddenField"]');
    $(document).on("click", "#data-table-list .edit-table-selector tbody td.created-name", function() {
        var elem = $(this);
        elem.hide();
        elem.after(replaceWith);
        replaceWith.focus();

        $('input.temp').val(elem.html()).select();

        replaceWith.blur(function() {
            if ($(this).val() != "") {
                connectWith.val($(this).val()).change();
                elem.text($(this).val());

                ajaxRequest(
                    window.updateItemUrl,
                    {
                        'hash': elem.parent().data('hash'),
                        'name': elem.text()
                    }
                );
            }

            $(this).remove();
            elem.show();
        }).keyup(function(ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if(keycode == 13) {
                if ($(this).val() != "") {
                    connectWith.val($(this).val()).change();
                    elem.text($(this).val());

                    ajaxRequest(
                        window.updateItemUrl,
                        {
                            'hash': elem.parent().data('hash'),
                            'name': elem.text()
                        }
                    );
                }

                $(this).remove();
                elem.show();
            }
        });
    });

    $(document).on("click", "#data-table-list .panel-expense-table h3.panel-title", function() {
        var elem = $(this);
        elem.hide();
        elem.after(replaceWith);
        replaceWith.focus();

        $('input.temp').val(elem.html()).select();

        replaceWith.blur(function() {

            if ($(this).val() != "") {
                connectWith.val($(this).val()).change();
                elem.text($(this).val());

                var panel = elem.parents('.panel.data-table');
                ajaxRequest(
                    window.updateCategoryUrl,
                    {
                        'hash': panel.data('hash'),
                        'name': elem.text()
                    }
                );
            }

            $(this).remove();
            elem.show();
        }).keyup(function(ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if(keycode == 13) {
                if ($(this).val() != "") {
                    connectWith.val($(this).val()).change();
                    elem.text($(this).val());

                    var panel = elem.parents('.panel.data-table');
                    ajaxRequest(
                        window.updateCategoryUrl,
                        {
                            'hash': panel.data('hash'),
                            'name': elem.text()
                        }
                    );
                }

                $(this).remove();
                elem.show();
            }
        });
    });

    // update table values
    // --global val for data price
    $(document).on('change', '#data-table-list .edit-table-selector-expense td', function(evt) {
        var cell = $(this, this);
        indexColumn = cell.index();

        var $resulttablesfooter = cell.closest('table').find('tfoot tr th');
        var $resulttablestable = cell.closest('table');
        totalExpenses = 0;
        totalExpensescol = 0;
        totalExpensescolAverage = 0;

        // GRAB TOTAL EXPENSES BY COL
        $('#data-table-list .edit-table-selector-expense tbody tr').each(function() {
            var rowfila = $(this);
            //Devuelve el Total por Columna
            totalExpenses += parseFloat(rowfila.children().eq(indexColumn).text());

        });

        // TOTAL / AVERAGE EXPENSES
        var $cellvar = $(this).parent();
        var indexRow = $cellvar.index();
        var totalIncometd = 0;
        $cellvar.find('td.income-data').each(function() {
            var cell2 = $(this);
            //console.log(' Row # ', indexRow);
            totalIncometd += parseFloat(cell2.text());
            $cellvar.children().eq(13).text(roundToTwo(totalIncometd));
            $cellvar.children().eq(14).text(roundToTwo(totalIncometd / 12));
        });

        // TOTAL EXPENSES BY TABLE
        $resulttablestable.find('tbody tr').each(function() {
            var rowfila = $(this);
            totalExpensescol += parseFloat(rowfila.children().eq(13).text());
            totalExpensescolAverage += parseFloat(rowfila.children().eq(14).text());
        });

        // TOTAL EXPENSES PER TABLE -  TOTAL PRINT IN TFOOT
        $resulttablesfooter.eq(13).text(roundToTwo(totalExpensescol));
        $resulttablesfooter.eq(14).text(roundToTwo(totalExpensescol / 12));

        // TOTAL EXPENSES BY TABLE ALL
        totalExpensesByTable = 0;
        $('.data-tables .edit-table-selector').find('tfoot tr').each(function() {

            var resulttablealla = $(this).children().eq(14).text();
            totalExpensesByTable += parseFloat($(this).children().eq(13).text());

        });

        UpdateExpenses(indexColumn);
        UpdateNET(indexColumn);
        GetTotalExpenses(indexColumn);

        // save to db
        ajaxRequest(
            window.updateItemMonthUrl,
            {
                'hash': $cellvar.data('hash'),
                'key': cell.data('key'),
                'value': cell.text(),
                'type': 'expense'
            }
        );
    });

    var totalIncome = 0;
    var totalIncomecol = 0;
    var totalIncomecolAverage = 0;
    var totalExpenses = 0;
    var totalExpensescol = 0;
    var totalExpensescolAverage = 0;
    var rowfilaX;
    var totalExpensesByTable = 0;

    $('#data-table-list .edit-table-selector-income td').on('change', function(evt) {
        var $elementdata = $(this).parents('.edit-table-selector-income');

        // TOTAL / AVERAGE PER TABLE INCOME
        var $cellvar = $(this).parent();
        var indexRow = $cellvar.index();

        var totalIncometd = 0;
        $cellvar.find('td.income-data').each(function() {
            var cell2 = $(this);
            totalIncometd += parseFloat(cell2.text());
            $cellvar.children().eq(13).text(roundToTwo(totalIncometd));
            $cellvar.children().eq(14).text(roundToTwo(totalIncometd / 12));

        });

        //TOTAL AVERAGE INCOME BY COL
        var cell = $(this);
        indexColumn = cell.index();

        totalIncome = 0;
        totalIncomecol = 0;
        totalIncomecolAverage = 0;
        $elementdata.find('tbody tr').each(function() {
            rowfilaX = $(this);
            //console.log(rowfila.children())
            totalIncome += parseFloat(rowfilaX.children().eq(indexColumn).text());

            // GRAB DATA TOTAL AND AVERAGE
            totalIncomecol += parseFloat(rowfilaX.children().eq(13).text());
            totalIncomecolAverage += parseFloat(rowfilaX.children().eq(14).text());

        });

        // PRINT DATA TOTAL AND AVERAGE IN FOOTER
        footer = $elementdata.find('tfoot tr');
        footer.children().eq(13).text(roundToTwo(totalIncomecol));
        footer.children().eq(14).text(roundToTwo(totalIncomecol / 12));

        UpdateIncome(indexColumn);
        UpdateNET(indexColumn);
        GetTotalExpenses(indexColumn);

        // save to db
        ajaxRequest(
            window.updateItemMonthUrl,
            {
                'hash': $cellvar.data('hash'),
                'key': cell.data('key'),
                'value': cell.text(),
                'type': 'income'
            }
        );
    });

    function UpdateIncome(indexColumn) {
        $('#summary-data').find('tbody tr:nth-child(1)').children().eq(indexColumn).text(roundToTwo(totalIncome));
        // UPDATE TOTAL AND AVERAGE ONLY ICOME
        $('#summary-data').find('tbody tr:nth-child(1)').children().eq(13).text(roundToTwo(totalIncomecol));
        $('#summary-data').find('tbody tr:nth-child(1)').children().eq(14).text(roundToTwo(totalIncomecol / 12));

    };

    function UpdateExpenses(indexColumn) {
        if(indexColumn) {
            $('#summary-data').find('tbody tr:nth-child(2)').children().eq(indexColumn).text(roundToTwo(totalExpenses));

            // UPDATE TOTAL AND AVERAGE ONLY EXPENSES

            // TOTAL EXPENSES NO EXISTE CUANDO SE PONE PRIMERO VALORES DE INCOME ODRDEN DE FUNCION ?
            $('#summary-data').find('tbody tr:nth-child(2)').children().eq(13).text(roundToTwo(totalExpensesByTable));
            $('#summary-data').find('tbody tr:nth-child(2)').children().eq(14).text((roundToTwo(totalExpensesByTable / 12)));
        } else {
            $('#summary-data').find('tbody tr:nth-child(2) td').each(function() {
                var cell = $(this, this);
                indexColumn = cell.index();

                var totalExpensescol1 = 0;
                $('#data-table-list .edit-table-selector-expense tbody tr').each(function() {
                    if(indexColumn < 14 && indexColumn > 0) {
                        totalExpensescol1 += parseFloat($(this).children().eq(indexColumn).text());
                    }
                });

                cell.text(roundToTwo(totalExpensescol1));
            });

            var totalExpenses1 = $('#summary-data').find('tbody tr:nth-child(2)').children().eq(13).text();
            $('#summary-data').find('tbody tr:nth-child(2)').children().eq(14).text((roundToTwo(totalExpenses1 / 12)));
        }
    };

    function UpdateNET(indexColumn) {
        if(indexColumn) {
            tIncome = roundToTwo($('#summary-data').find('tbody tr:nth-child(1)').children().eq(indexColumn).text());
            tExpenses = roundToTwo($('#summary-data').find('tbody tr:nth-child(2)').children().eq(indexColumn).text());
            $('#summary-data').find('tbody tr:nth-child(3)').children().eq(indexColumn).text(roundToTwo(tIncome - tExpenses));

            //if((totalIncomecol - totalExpensesByTable) != 0){
            tIncome1 = roundToTwo($('#summary-data').find('tbody tr:nth-child(1)').children().eq(13).text());
            tExpenses1 = roundToTwo($('#summary-data').find('tbody tr:nth-child(2)').children().eq(13).text());

            $('#summary-data').find('tbody tr:nth-child(3)').children().eq(13).text(roundToTwo(tIncome1 - tExpenses1));
            $('#summary-data').find('tbody tr:nth-child(3)').children().eq(14).text(roundToTwo((tIncome1 - tExpenses1) / 12));
            //}
        } else {
            $('#summary-data').find('tbody tr:nth-child(3) td').each(function() {
                var cell = $(this, this);
                indexColumn = cell.index();

                if(indexColumn < 14 && indexColumn > 0) {
                    tIncome = roundToTwo($('#summary-data').find('tbody tr:nth-child(1)').children().eq(indexColumn).text());
                    tExpenses = roundToTwo($('#summary-data').find('tbody tr:nth-child(2)').children().eq(indexColumn).text());
                    $('#summary-data').find('tbody tr:nth-child(3)').children().eq(indexColumn).text(roundToTwo(tIncome - tExpenses));
                } else {
                    tIncome1 = roundToTwo($('#summary-data').find('tbody tr:nth-child(1)').children().eq(13).text());
                    tExpenses1 = roundToTwo($('#summary-data').find('tbody tr:nth-child(2)').children().eq(13).text());

                    //$('#summary-data').find('tbody tr:nth-child(3)').children().eq(13).text(roundToTwo(totalIncomecol - totalExpensesByTable));
                    $('#summary-data').find('tbody tr:nth-child(3)').children().eq(14).text(roundToTwo((tIncome1 - tExpenses1) / 12));
                }
            });
        }

    };

    function GetTotalExpenses(indexColumn) {
        //$('#summary-data').find('tbody tr:nth-child(4)').children().eq(indexColumn).text(roundToTwo(1500));
    };
});

function changeView() {
    $windowW = $(window).width();
    $navbar = $('navbar .navbar')
    if ($windowW < 768) {
        $navbar.removeClass('navbar-fixed-top')
    }
}

function editTable() {
    $(".edit-table-selector-expense").each(function(i) {
        $(this).attr('id', "editableTable" + (i + 1));
        $(this).editableTable().numericInputExample();
    });

    $(".edit-table-selector-income").editableTable().numericInputExample();

    //SET Z INDEX OF PANEL ACTION WHEN CREATED
    var zindex = 1000;
    $('.panel-actions').each(function() {
        $(this).css("z-index", --zindex);
    });

    var zindex = 100;
    $('.panel-expense-table').each(function() {
        $(this).css("z-index", --zindex);
    });
}

function roundToTwo(num) {
    //return +(Math.round(num + "e+2")  + "e-2");
    num = parseFloat(Math.round(num + "e+2") + "e-2");
    return num.toFixed(2);
}

function format2(n) {
    return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}

function stringGen(len)
{
    var text = "";
    var charset = "abcdefghijklmnopqrstuvwxyz0123456789";
    for( var i=0; i < len; i++ )
        text += charset.charAt(Math.floor(Math.random() * charset.length));
    return text;
}

function ajaxRequest(url, data, afterCallback, beforeCallback) {
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN' : $('#csrf-token').attr('content') },
        url: url,
        data: data,
        beforeSubmit: function(){
            if(beforeCallback)
            {
                beforeCallback();
            }
        },
        success: function(res){
            if(afterCallback) {
                afterCallback(res);
            }
        }
    });
}