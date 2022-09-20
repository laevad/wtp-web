<x-animation.ball-spin></x-animation.ball-spin>
<div class="row">
    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
        <div class="card">
            <div class="card-header"><h5>Booking Report</h5></div>
            <div class="card-body table-responsive">
                <table class="table table-hover table-condensed table-responsive-md" id="reportBookingTable">
                    <thead>
                    <th>Driver</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Date Created</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
        <div class="card">
            <div class="card-header">Report</div>
            <div class="card-body">
                <div class="form-group">
                    <x-custom.select2 id="driver_id" label="Driver" selectLabel="Select Driver" :datas="$drivers" isAll="true"></x-custom.select2>
                </div>
                <div class="form-group">
                    <x-custom.select2 id="cash_type_id" label="Type" selectLabel="Select Type" :datas="$cashType" isAll="true"></x-custom.select2>
                </div>
                <div class="form-group">
                    <label for="daterange_textbox">Date Range</label>
                    <input type="text" id="daterange_textbox" class="form-control" readonly />
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $('#daterange_textbox').daterangepicker({
            ranges:{
                'Today' : [moment(), moment()],
                'Yesterday' : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                'Last 30 Days' : [moment().subtract(29, 'days'), moment()],
                'This Month' : [moment().startOf('month'), moment().endOf('month')],
                'Last Month' : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            format : 'YYYY-MM-DD',
        }, function(start, end){
            var driver_id = $("#driver_id").val();
            var cash_type_id = $("#driver_id").val();
            $('#reportBookingTable').DataTable().destroy();
            fetch(start.format('YYYY-MM-DD HH:mm'), end.format('YYYY-MM-DD HH:mm'), driver_id, cash_type_id);
        });


        function fetch(start_date, end_date, driver_id,cash_type_id ) {
            $.ajax({
                url: "{{ route('admin.ei.report') }}",
                type: 'get',
                data: {
                    start_date: start_date,
                    end_date: end_date,
                    driver_id: driver_id,
                    cash_type_id, cash_type_id,
                },
                dataType: "json",
                success: function(data) {
                    let i = 1;
                    $('#reportBookingTable').DataTable({
                        "data": data.ie,
                        // buttons
                        "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        "buttons": [
                            { extend: 'print',
                                title: function() {
                                    let start = $('#daterange_textbox').data('daterangepicker').startDate;
                                    let end = $('#daterange_textbox').data('daterangepicker').endDate;
                                    return 'WT&P Management System [Report: '+start.format('YYYY-MM-DD')+' - ' + end.format('YYYY-MM-DD')+']';
                                },
                            },
                            { extend: 'csv',
                                title: function() {
                                    let start = $('#daterange_textbox').data('daterangepicker').startDate;
                                    let end = $('#daterange_textbox').data('daterangepicker').endDate;
                                    return 'WT&P Management System [Report: '+start.format('YYYY-MM-DD')+' - ' + end.format('YYYY-MM-DD')+']';
                                },
                            },
                            { extend: 'excel',
                                title: function() {
                                    let start = $('#daterange_textbox').data('daterangepicker').startDate;
                                    let end = $('#daterange_textbox').data('daterangepicker').endDate;
                                    return 'WT&P Management System [Report: '+start.format('YYYY-MM-DD')+' - ' + end.format('YYYY-MM-DD')+']';
                                },
                            },
                            { extend: 'pdf',
                                title: function() {
                                    let start = $('#daterange_textbox').data('daterangepicker').startDate;
                                    let end = $('#daterange_textbox').data('daterangepicker').endDate;
                                    return 'WT&P Management System [Report: '+start.format('YYYY-MM-DD')+' - ' + end.format('YYYY-MM-DD')+']';
                                },
                            },

                        ],
                        destroy: true,
                        retrieve:true,
                        processing:true,
                        "autoWidth": true,
                        info:true,
                        searching:true,
                        "pageLength": 5,
                        "responsive": true,
                        lengthMenu: [
                            [3,5,10, 25, 50, -1],
                            [3,5, 10, 25, 50, 'All'],
                        ],
                        "columns": [
                            {
                                "data": "name",
                                "render": function(data, type, row, meta) {
                                    return row.name;
                                }
                            },
                            {
                                "data": "date",
                                "render": function(data, type, row, meta) {
                                    return row.date;
                                }
                            },
                            {
                                "data": "note",
                                "render": function(data, type, row, meta) {
                                    return row.note;
                                }
                            },
                            {
                                "data": "amount",
                                "render": function(data, type, row, meta) {
                                    return row.amount;
                                }
                            },
                            {
                                "data": "type",
                                "render": function(data, type, row, meta) {
                                    return row.type;
                                }
                            },
                            {
                                "data": "created_at",
                                "render": function(data, type, row, meta) {
                                    return moment(data).format("MM-DD-YYYY hh:mm A");
                                }
                            },
                        ]
                    });
                }
            });
        }



        $(document.body).on("change","#cash_type_id",function(){
            let start = $('#daterange_textbox').data('daterangepicker').startDate;
            let end = $('#daterange_textbox').data('daterangepicker').endDate;
            let driver_id = $('#driver_id').val();
            $('#reportBookingTable').DataTable().destroy();
            fetch(start.format('YYYY-MM-DD HH:mm'), end.format('YYYY-MM-DD HH:mm'), driver_id, this.value);
        });

        $(document.body).on("change","#driver_id",function(){
            let start = $('#daterange_textbox').data('daterangepicker').startDate;
            let end = $('#daterange_textbox').data('daterangepicker').endDate;
            let type = $('#cash_type_id').val();
            $('#reportBookingTable').DataTable().destroy();
            fetch(start.format('YYYY-MM-DD HH:mm'), end.format('YYYY-MM-DD HH:mm'), this.value, type);
        });


        $( window ).on( "load", function (){
            let start = $('#daterange_textbox').data('daterangepicker').startDate;
            let end = $('#daterange_textbox').data('daterangepicker').endDate;
            let driver_id = $('#driver_id').val();
            let type = $('#cash_type_id').val();
            fetch(start.format('YYYY-MM-DD HH:mm'), end.format('YYYY-MM-DD HH:mm'), driver_id, type);
        });


    </script>
@endpush
