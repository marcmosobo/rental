@extends('layouts.app')
 @section("pageTitle",'Tenants arrears report')
 {{--@section("pageSubtitle",'create, edit, delete Claims')--}}
  @section("breadcrumbs")
            <li>Reports</li>
            <li>tenant arrears</li>
         @endsection

@section('css')
    <style>
        .no-top{
            margin-top: 0;
            margin-bottom: 0;
            font-size: 20px;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 0;
        }
    </style>
    @endsection
@section('content')
    <section class="invoice no-print">
        <div class="row">
            <div class="col-md-12">

                <div class="col-md-12 col-md-offset-1">
                    <div class="form-group" id="date-range-div" >
                        <form action="{{ url('getTenantArrears') }}" id="plot-form" method="post">
                            {{ csrf_field() }}
                            <div class="col-md-3">
                                <label>property</label>
                                <select class="form-control select2" name="property_id" id="property_id" required>
                                    <option value="All">All Properties</option>
                                    @if(count($properties))
                                        @foreach($properties as $property)
                                            <option value="{{ $property->id }}">{{ $property->name }}</option>
                                            @endforeach
                                        @endif

                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>From</label>
                                <input type="date" required value="{{ \Carbon\Carbon::today()->startOfMonth()->toDateString() }}" class="form-control" id="date-from" name="date_from">
                            </div>
                            <div class="col-md-3">
                                <label>To</label>
                                <input type="date" required value="{{ \Carbon\Carbon::today()->endOfMonth()->toDateString() }}" class="form-control" id="date-to" name="date_to">
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
    @if(isset($arrears))
    <section class="invoice">
        <!-- title row -->

        <!-- info row -->
        @include('layouts.partials.report-header')

        <div class="row">
            <div class="col-md-12 table-responsive">
                <h4 class="">Tenants arrears as of {{ \Carbon\Carbon::parse($from)->toFormattedDateString() }} - {{ \Carbon\Carbon::parse($to)->toFormattedDateString() }}</h4>
                {{--<p class="">Property: {{ $prop }}</p>--}}
                {{--<p class="">Landlord/lady: {{ $landlord->full_name }}</p>--}}
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Property</th>
                            <th>House Number</th>
                            <th>Tenant</th>
                            <th>Phone Number</th>
                            <th style="text-align: right;">BBF</th>
                            <th style="text-align: right;">Current Balance</th>
                            <th style="text-align: right;">Total</th>
                            <th style="text-align: right;">Amount Paid</th>
                            <th style="text-align: right;">Arrears C/F</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($arrears))
                        @foreach($arrears as $bal)
                            <tr>
                                <td>{{ $bal['property_name'] }}</td>
                                <td>{{ $bal['house_number'] }}</td>
                                <td>{{ $bal['tenant'] }}</td>
                                <td>{{ $bal['phone_number'] }}</td>
                                <td style="text-align: right;">{{ number_format($bal['bbf'],2) }}</td>
                                <td style="text-align: right;">{{ number_format($bal['current'],2) }}</td>
                                <td style="text-align: right;">{{ number_format($bal['total'],2) }}</td>
                                <td style="text-align: right;">{{ number_format($bal['paid'],2) }}</td>
                                <td style="text-align: right;">{{ number_format($bal['bcf'],2) }}</td>
                            </tr>
                            @endforeach
                        <tr>
                            <th><h3 class="no-top">{{ count($arrears) }} </h3></th>
                            <th><h3 class="no-top"></h3></th>
                            <th><h3 class="no-top"></h3></th>
                            <th><h3 class="no-top"></h3></th>
                            <th><h3 class="no-top">Totals</h3></th>
{{--                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($arrears->sum('bbf'),2) }}</h3></th>--}}
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($arrears->sum('current'),2) }}</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($arrears->sum('total'),2) }}</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($arrears->sum('paid'),2) }}</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($arrears->sum('bcf'),2) }}</h3></th>
                        </tr>
                        @else
                        <tr>
                            <td class="text-center" colspan="9">No records found</td>
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

                <a onclick="window.print()" target="_blank" class="btn btn-success pull-right"><i class="fa fa-print"></i> Print</a>
            </div>
        </div>
    </section>
    @endif
    <!-- /.content -->
    <div class="clearfix"></div>

@endsection

@push('js')
    <script>
        $('a#tenantArrears').parent('li').addClass('active').parent('ul').parent().addClass('active');

    </script>
    @endpush