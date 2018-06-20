@extends('layouts.app')
 @section("pageTitle",'Property Statement Report')
 {{--@section("pageSubtitle",'create, edit, delete Claims')--}}
  @section("breadcrumbs")
            <li>Reports</li>
            <li>Property Statement</li>
         @endsection

@section('css')
    <style>
        .no-top{
            margin-top: 0;
            margin-bottom: 0;
            font-size: 20px;
        }
    </style>
    @endsection
@section('content')
    <section class="invoice no-print">
        <div class="row">
            <div class="col-md-12">

                <div class="col-md-12 col-md-offset-1">
                    <div class="form-group" id="date-range-div" >
                        <form action="{{ url('getPropertyStatement') }}" id="plot-form" method="post">
                            {{ csrf_field() }}
                            <div class="col-md-3">
                                <label>property</label>
                                <select class="form-control select2" name="property_id" id="property_id" required>
                                    <option value="">Select property</option>
                                    @if(count($properties))
                                        @foreach($properties as $property)
                                            <option value="{{ $property->id }}">{{ $property->name }}</option>
                                            @endforeach
                                        @endif

                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>From</label>
                                <input type="date" required class="form-control" id="date-from" name="date_from">
                            </div>
                            <div class="col-md-3">
                                <label>To</label>
                                <input type="date" required class="form-control" id="date-to" name="date_to">
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
    @if(isset($pStatements))
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
                <h4 class="">Property statement for: {{ $from }} - {{ $to }}</h4>
                <p class="">Property: {{ $prop }}</p>
                <p class="">Landlord/lady: {{ $landlord }}</p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Unit Number</th>
                            <th>Tenant</th>
                            <th>Status</th>
                            <th style="text-align: right;">Monthly Rent</th>
                            <th style="text-align: right;">Arrears B/F</th>
                            <th style="text-align: right;">Total Due</th>
                            <th style="text-align: right;">Amount Paid</th>
                            <th style="text-align: right;">Arrears C/F</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($pStatements))
                        @foreach($pStatements as $statement)
                            <tr>
                                <td>{{ $statement['unit_number'] }}</td>
                                <td>{{ $statement['tenant'] }}</td>
                                <td>{{ $statement['status'] }}</td>
                                <td style="text-align: right;">{{ number_format($statement['monthly_rent'],2) }}</td>
                                <td style="text-align: right;">{{ number_format($statement['arrears_bf'],2) }}</td>
                                <td style="text-align: right;">{{ number_format($statement['total_due'],2) }}</td>
                                <td style="text-align: right;">{{ number_format($statement['amt_paid'],2) }}</td>
                                <td style="text-align: right;">{{ number_format($statement['arrears_cf'],2) }}</td>
                            </tr>
                            @endforeach
                        <tr>
                            <th><h3 class="no-top">{{ count($pStatements) }} </h3></th>
                            <th><h3 class="no-top"></h3></th>
                            <th><h3 class="no-top"></h3></th>
                            <th><h3 class="no-top">Totals</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($pStatements->sum('arrears_bf'),2) }}</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($pStatements->sum('total_due'),2) }}</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($pStatements->sum('amt_paid'),2) }}</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($pStatements->sum('arrears_cf'),2) }}</h3></th>
                        </tr>
                        @else
                        <tr>
                            <td class="text-center" colspan="8">No records found</td>
                        </tr>
                        @endif
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
    @endif
    <!-- /.content -->
    <div class="clearfix"></div>
@endsection

@push('js')
    <script>
        {{--$("#plot-form").on('submit',function(e){--}}
            {{--e.preventDefault();--}}
            {{--var data = {--}}
                {{--'property_id':$('#property_id').val(),--}}
                {{--"date-from": $('#date-from').val(),--}}
                {{--'date-to': $('#date-to').val()--}}
            {{--};--}}
            {{--// console.log(data);--}}

            {{--$.ajax({--}}
                {{--'url': '{{ url('getPropertyStatement') }}',--}}
                {{--'type': 'POST',--}}
                {{--'dataType': 'json',--}}
                {{--'data':data,--}}
                {{--success: function(data){--}}

                {{--}--}}
            {{--});--}}
        {{--})--}}
        $('a#propertyStatement').parent('li').addClass('active').parent('ul').parent().addClass('active');

    </script>
    @endpush