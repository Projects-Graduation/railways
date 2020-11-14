<link rel="stylesheet" type="text/css" href="<?= plugin('datatables/datatables.min.css') ?>">
<script type="text/javascript" src="<?= plugin('datatables/js/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?= plugin('datatables/js/dataTables.buttons.min.js') ?>"></script>
<script type="text/javascript" src="<?= plugin('datatables/js/jszip.min.js') ?>"></script>
<script type="text/javascript" src="<?= plugin('datatables/js/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?= plugin('datatables/js/vfs_fonts.js') ?>"></script>
<script type="text/javascript" src="<?= plugin('datatables/js/buttons.html5.min.js') ?>"></script>
<script src="<?= plugin('datatables/buttons.print.js') ?>"></script>
<style type="text/css">
    .data-table-container {
        padding: 10px;
    }

    .dt-buttons .btn {
        margin-left: 3px;
    }

    .dataTables_filter{
        float: right !important;
        margin-bottom: 15px;
    }

    .dt-buttons{
        float: left !important;
        margin-bottom: 15px;
    }
</style>
<style media="all">
    .total{
        text-decoration: underline;
    }
</style>
<script>
    $(document).ready(function(){
        $.extend( true, $.fn.dataTable.defaults, {
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'oLanguage'    : {
                "sEmptyTable":     "ليست هناك بيانات متاحة في الجدول",
                "sLoadingRecords": "جارٍ التحميل...",
                "sProcessing":   "جارٍ التحميل...",
                "sLengthMenu":   "أظهر _MENU_ مدخلات",
                "sZeroRecords":  "لم يعثر على أية سجلات",
                "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
                "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "sInfoPostFix":  "",
                "sSearch":       "ابحث:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "الأول",
                    "sPrevious": "السابق",
                    "sNext":     "التالي",
                    "sLast":     "الأخير"
                },
                "oAria": {
                    "sSortAscending":  ": تفعيل لترتيب العمود تصاعدياً",
                    "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
                }
            },
            'dom': 'Bfrtip',
            "autoWidth": true,
            "columnDefs": [{
                "visible": true,
                "targets": -1
            }],
            // buttons: [
            //     {
            //         extend: 'print',
            //         text: '@lang("accounting::global.print") <i class="fa fa-print"></i>', 
            //         className: 'btn btn-default',
            //         exportOptions: {
            //             columns: 'th:not(:last-child)',
            //             stripHtml: false
            //         }, 
            //         footer: true
            //     },
            //     {
            //         extend: 'excel',
            //         text: '@lang("accounting::global.excel") <i class="fa fa-file-excel"></i>', 
            //         className: 'btn btn-success',
            //         exportOptions: {
            //             columns: 'th:not(:last-child)',
            //             stripHtml: false
            //         }, 
            //         footer: true
            //     },
                
            // ]
        } );
    $('table.datatable').dataTable({
        paging: false,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                autoPrint: true,
                text: '<i class="fa fa-print"></i><span>طباعة</span>',
                footer: true,
                exportOptions: {
                    columns: 'th:not(:last-child)',
                    stripHtml: false
                },
                customize: function ( doc ) {
                    $(doc.document.body).find('h1').css({
                        'text-align': 'center', 'font-size': '15pt',
                        'font-weight': 'bold', 'margin-bottom': '30px',

                    });
                },
            },
            {
                extend: 'excel',
                text: '<i class="fa fa-file-excel-o"></i><span>اكسل</span>',
                classes: 'btn btn-success',
                exportOptions: {
                    columns: 'th:not(:last-child)',
                    stripHtml: false
                },
            },
        ]
    });
    $('table.datatable-paged').dataTable({
        paging: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                autoPrint: true,
                text: '<i class="fa fa-print"></i><span>طباعة</span>',
                footer: true,
                customize: function ( doc ) {
                    $(doc.document.body).find('h1').css({
                        'text-align': 'center', 'font-size': '15pt',
                        'font-weight': 'bold', 'margin-bottom': '30px',

                    });
                },
            },
            {
                extend: 'excel',
                text: '<i class="fa fa-file-excel-o"></i><span>اكسل</span>',
                classes: 'btn btn-success'
            },
        ]
    });
    
    /* custom button event print */
    $(document).on('click', '#btn-print', function(){
        $(".buttons-print")[0].click(); //trigger the click event
    });

    });
</script>