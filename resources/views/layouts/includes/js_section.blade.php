<!-- Button back -->
<script>
    $(function () {
        $("#back").click(function () {
            window.history.back();
        });
    });
</script>

<script>

    $(document).ready(function () {
        // Setup - add a text input to each footer cell
        $('.dataTables tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="width: 100%;" placeholder="Pesquisar ' + title + '" />');
        });


        // DataTable
        var table = $('.dataTables').DataTable({
            dom: "<'row'<'col-sm-5'l><'col-sm-2 'B><'col-sm-5' f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-8'i><'col-sm-4'p>>",
            stateSave: true,
            responsive: true,
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i>',
                    className: "btn-success",
                    titleAttr: 'Export to Excel',
                    filename: 'Listagem',
                    exportOptions: {
                        columns: ':not(:last-child)' // Not export last column
                    }
                },
                /*{
                    extend: 'colvis',
                    collectionLayout: 'fixed two-column',
                    text:      '<i class="fas fa-check-square"></i>',
                    className: "btn-primary",
                    titleAttr: 'Column Visible',
                    // columns: ':not(.noVis)',

                },*/
            ],
        });

        // Apply the search
        table.columns().every(function () {
            var that = this;

            $('input', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });

        //search in the top
        {
            var r = $('.dataTables tfoot tr');
            r.find('th').each(function () {
                $(this).css('padding', 8);
            });
            $('.dataTables thead').append(r);
            //$('#search_0').css('text-align', 'center');
        }

        // Restore state
        var state = table.state.loaded();

        if (state) {
            table.columns().eq(0).each(function (colIdx) {
                var colSearch = state.columns[colIdx].search;

                if (colSearch.search) {
                    $('input', table.column(colIdx).footer()).val(colSearch.search);
                }
            });

            table.draw();
        }


    });

</script>

<script>
    $(".select2").select2({
        allowClear: true,
        width: '100%'
    });
</script>
