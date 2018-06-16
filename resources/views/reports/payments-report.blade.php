@extends('layouts.app')
 @section("pageTitle",'Payments Report')
 {{--@section("pageSubtitle",'create, edit, delete Claims')--}}
  @section("breadcrumbs")
            <li>Reports</li>
            <li>Payments report</li>
         @endsection
@section('content')
    {{--<div class="col-md-12">--}}
        {{--<div class="box">--}}
            {{----}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<section class="content-header">--}}
        {{--<h1 class="pull-right">--}}
           {{--<a href="{{ url('claims/create') }}" class="btn btn-primary btn-sm" style="margin-top: -10px;margin-bottom: 5px" >Create New</a>--}}
        {{--</h1>--}}
    {{--</section>--}}
    <section class="invoice no-print">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ url('getPaymentsReport') }}" id="policies-form" method="post">
                    {{ csrf_field() }}
                <div class="col-md-3 col-md-offset-2">
                    <label>From</label>
                    <input type="date" required class="form-control" id="date-from" name="from">
                </div>
                <div class="col-md-3">
                    <label>To</label>
                    <input type="date" required class="form-control" id="date-to" name="from">
                </div>
                <div class="col-md-1 ">
                    <button type="submit" class="btn btn-primary " style="margin-top: 25px;">Search</button>
                </div>
                </form>
            </div>
        </div>
    </section>
    <section class="invoice">
        <!-- title row -->

        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">

            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col text-center">

                <address>
                    <strong>Abiria Insurance Agency</strong><br>
                    {{--795 Folsom Ave, Suite 600<br>--}}
                    {{--San Francisco, CA 94107<br>--}}
                    {{--Phone: (555) 539-1037<br>--}}
                    {{--Email: john.doe@example.com--}}
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">

            </div>
            <!-- /.col -->
        </div>

        <div class="row">
            <div class="col-md-12 table-responsive">
                {{--<p class="lead">T.P Vehicles Involved</p>--}}
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Policy Number</th>
                            <th>Payment Mode</th>
                            <th>Reference</th>
                            <th>Amount Paid</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">

                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->


        <!-- this row will not appear when printing -->
        <br>
        <br>
        <div class="row no-print">
            <div class="col-xs-12">

                <a onclick="window.print()" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>
            </div>
        </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
@endsection

@push('js')
    <script>
        $("#policies-form").on('submit',function(e){
            e.preventDefault();
            var data = {
                "date_from": $('#date-from').val(),
                "date_to": $('#date-to').val(),
            };
            $.ajax({
                url: $(this).attr('action'),
                type:'POST',
                dateType: 'json',
                data: data,
                success:function(data){
                    var html = '';
                    if(data.length > 0){
                        for(var i=0; i<data.length; i++){
                            html += '<tr>' +
                                '<td>'+ data[i].policy_number+'</td>' +
                                '<td>'+ data[i].payment_mode+'</td>' +
                                '<td>'+ data[i].reference+'</td>' +
                                '<td>'+ data[i].amount_paid+'</td>'
                        }
                        $('#tbody').html(html)
                    }else{
                        $('#tbody').html('<tr><td colspan="4" class="text-center">No records available</td></tr>');
                    }


                }
            })
        })
    </script>
    @endpush