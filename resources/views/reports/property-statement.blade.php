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
    </script>
    @endpush