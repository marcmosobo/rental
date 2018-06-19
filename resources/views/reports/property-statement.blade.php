@extends('layouts.app')
 @section("pageTitle",'Property Statement Report')
 {{--@section("pageSubtitle",'create, edit, delete Claims')--}}
  @section("breadcrumbs")
            <li>Reports</li>
            <li>Property Statement</li>
         @endsection
@section('content')
    <section class="invoice no-print">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    <label >Search By</label>
                    <div class="form-group">
                        <input type="radio" checked name="filter" class="i-check-line filter" value="pre-defined"><label>Pre Defined</label>
                    </div>
                    <div class="form-group">
                        <input type="radio" name="filter" class="i-check-line filter" value="date-range"><label> Date Range</label>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group" id="pre-defined-div" style="margin-top: 18px;">
                        <label>Select Period</label>
                        <select name="period" class="form-control select2" id="pre-defined-select">
                            <option value="this-month">This Month</option>
                        </select>
                    </div>
                    <div class="form-group" id="date-range-div" style="margin-top: 18px;display: none;">
                        <form action="{{ url('getExpectedRepayments') }}" id="policies-form" method="post">
                            {{ csrf_field() }}
                            <div class="col-md-5">
                                <label>From</label>
                                <input type="date" required class="form-control" id="date-from" name="from">
                            </div>
                            <div class="col-md-5">
                                <label>To</label>
                                <input type="date" required class="form-control" id="date-to" name="from">
                            </div>
                            <div class="col-md-2 ">
                                <button type="submit" class="btn btn-primary " style="margin-top: 25px;">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
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
                    <h3>Marite Enterprises Limited</h3>
                    Lentile House, 2<sup>nd</sup> Floor Rm 213<br>
                    P.O Box 1440 - 10400 Nanyuki<br>
                    {{--<br>--}}
                    Phone number: 0700634000<br>
                    Email: info@mariteenterprises.co.ke
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
                            <th>Unit Number</th>
                            <th>Tenant</th>
                            <th>Status</th>
                            <th>Monthly Rent</th>
                            <th>Arrears B/F</th>
                            <th>Total Due</th>
                            <th>Amount Paid</th>
                            <th>Arrears C/F</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center" colspan="8">Select tenant</td>
                        </tr>
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
        $('.filter').on('ifChecked',function(){
            var value = $(this).val()
            if(value === 'date-range'){
                $('#date-range-div').show();
                $('#pre-defined-div').hide();
            }else{
                $('#date-range-div').hide();
                $('#pre-defined-div').show();
            }
        });

        $("#pre-defined-select").on('change',function(){
            let val = $(this).val();
            let data = {
                'filter':'pre-defined',
                'value':val
            };

            {{--$.ajax({--}}
                {{--url: '{{ url('getExpectedRepayments') }}',--}}
                {{--type:'POST',--}}
                {{--dateType: 'json',--}}
                {{--data: data,--}}
                {{--success:function(data){--}}
                    {{--// loadTable(data);--}}
                {{--}--}}
            {{--})--}}
        });

    </script>
    @endpush