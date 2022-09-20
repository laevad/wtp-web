<div class="row">
    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
        <div class="card">
            <div class="card-header"><h5>Booking Report</h5></div>
            <div class="card-body table-responsive">
                <table class="table table-hover table-condensed table-responsive-md" id="reportBookingTable">
                    <thead>
                    <th>Customer</th>
                    <th>Vehicle</th>
                    <th>Driver</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Distance</th>
                    <th>Trip Status</th>
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
                    <x-custom.select2 id="vehicle_id" label="Vehicle" selectLabel="Select Vehicle" :datas="$vehicles" isAll="true"></x-custom.select2>
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
        /*fetch dAtA*/
        function fetch(start_date, end_date, vehicle_id) {
            $.ajax({
                url: "{{ route('admin.report.report.bookings') }}",
                type: 'get',
                data: {
                    start_date: start_date,
                    end_date: end_date,
                    vehicle_id, vehicle_id,
                },
                dataType: "json",
                success: function(data) {
                    var i = 1;
                    $('#reportBookingTable').DataTable({
                        "data": data.bookings,
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
                        "pageLength": 3,
                        "responsive": true,
                        lengthMenu: [
                            [3,5,10, 25, 50, -1],
                            [3,5, 10, 25, 50, 'All'],
                        ],
                        "columns": [
                            {
                                "data": "client",
                                "render": function(data, type, row, meta) {
                                    return row.client;
                                }
                            },
                            {
                                "data": "vehicle",
                                "render": function(data, type, row, meta) {
                                    return row.vehicle;
                                }
                            },
                            {
                                "data": "driver",
                                "render": function(data, type, row, meta) {
                                    return row.driver;
                                }
                            },
                            {
                                "data": "t_trip_start",
                                "render": function(data, type, row, meta) {
                                    return row.t_trip_start;
                                }
                            },
                            {
                                "data": "t_trip_end",
                                "render": function(data, type, row, meta) {
                                    return row.t_trip_end;
                                }
                            },
                            {
                                "data": "trip_start_date",
                                "render": function(data, type, row, meta) {
                                    return row.trip_start_date;
                                }
                            },
                            {
                                "data": "trip_end_date",
                                "render": function(data, type, row, meta) {
                                    return row.trip_end_date;
                                }
                            },
                            {
                                "data": "t_total_distance",
                                "render": function(data, type, row, meta) {
                                    return row.t_total_distance;
                                }
                            },
                            {
                                "data": "status",
                                "render": function(data, type, row, meta) {
                                    return row.status;
                                }
                            },
                            {
                                "data": "created_at",
                                "render": function(data, type, row, meta) {
                                    return moment(data).format("MM/DD/YYYY hh:mm A");
                                }
                            },
                        ]
                    });
                }
            });
        }






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
            $('#reportBookingTable').DataTable().destroy();
            var vehicle_id = $("#vehicle_id").val();
            fetch(start.format('YYYY-MM-DD HH:mm'), end.format('YYYY-MM-DD HH:mm'), vehicle_id);

        });

        $(document.body).on("change","#vehicle_id",function(){
            let start = $('#daterange_textbox').data('daterangepicker').startDate;
            let end = $('#daterange_textbox').data('daterangepicker').endDate;
            $('#reportBookingTable').DataTable().destroy();
            fetch(start.format('YYYY-MM-DD HH:mm'), end.format('YYYY-MM-DD HH:mm'), this.value);
        });
        $( window ).on( "load", function (){
            let start = $('#daterange_textbox').data('daterangepicker').startDate;
            let end = $('#daterange_textbox').data('daterangepicker').endDate;
            var vehicle_id = $("#vehicle_id").val();
            fetch( start.format('YYYY-MM-DD HH:mm'), end.format('YYYY-MM-DD HH:mm'), vehicle_id)
        } );


    </script>
@endpush
