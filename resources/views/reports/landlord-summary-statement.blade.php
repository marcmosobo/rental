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
                        <form action="{{ url('getLandlordPlotStatement') }}" id="plot-form" method="post">
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
    @if(isset($reports))
    <section class="invoice">
        <!-- title row -->

        <!-- info row -->
        @include('layouts.partials.report-header')

        <div class="row">
            <div class="col-md-12 table-responsive">
                <h4 class="">Property statement for: {{ \Carbon\Carbon::parse($from)->toFormattedDateString() }} - {{ \Carbon\Carbon::parse($to)->toFormattedDateString() }}</h4>
                <p class="">Property: {{ $prop }}</p>
                {{--<p class="">Landlord/lady: {{ $landlord->full_name }}</p>--}}
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Unit Number</th>
                            <th>Tenant</th>
                            <th>Phone Number</th>
                            <th>Status</th>
                            <th style="text-align: right;">Monthly Rent</th>
                            <th style="text-align: right;">Arrears B/F</th>
                            <th style="text-align: right;">Current Bal</th>
                            <th style="text-align: right;">Total Due</th>
                            <th style="text-align: right;">Amount Paid</th>
                            <th style="text-align: right;">Arrears C/F</th>
                            <th style="text-align: right;">Over Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($reports))
                        @foreach($reports as $statement)
                            <tr>
                                <td>{{ $statement['house_number'] }}</td>
                                <td>{{ $statement['tenant'] }}</td>
                                <td>{{ $statement['phone_number'] }}</td>
                                <td>{{ $statement['status'] }}</td>
                                <td style="text-align: right;">{{ number_format($statement['monthly_rent'],2) }}</td>
                                <td style="text-align: right;">{{ number_format($statement['bbf'],2) }}</td>
                                <td style="text-align: right;">{{ number_format($statement['current'],2) }}</td>
                                <td style="text-align: right;">{{ number_format($statement['total'],2) }}</td>
                                <td style="text-align: right;">{{ number_format($statement['paid'],2) }}</td>
                                <td style="text-align: right;">{{ number_format($statement['bcf'],2) }}</td>
                                <td style="text-align: right;">{{ number_format($statement['over_payment'],2) }}</td>
                            </tr>
                            @endforeach
                        <tr>
                            <th><h3 class="no-top">{{ count($reports) }} </h3></th>
                            <th><h3 class="no-top"></h3></th>
                            <th><h3 class="no-top"></h3></th>
                            <th><h3 class="no-top">Totals</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($reports->sum('monthly_rent'),2) }}</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($reports->sum('bbf'),2) }}</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($reports->sum('current'),2) }}</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($reports->sum('total'),2) }}</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($reports->sum('paid'),2) }}</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($reports->sum('bcf'),2) }}</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($reports->sum('over_payment'),2) }}</h3></th>
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
        <div class="row">
            <div class="col-md-6"><hr></div>
            <div class="col-md-12" >
                <p class="lead">Summary</p>
                <div class="table-responsive">
                    @if(isset($expenditures))
                        <table class="table" style="width: 50%" >
                            <tr>
                                <th style="width:50%">Gross Rent Collected</th><td>{{ number_format($reports->sum('paid',2)) }}</td>
                            </tr>
                            <tr>
                                <th style="width:50%">Commission Percentage</th><td>{{ $commission }} %</td>
                            </tr>
                            <tr>
                                <th style="width:50%">Commission Charged</th><td>{{ number_format($reports->sum('paid')* $commission/100,2) }}</td>
                            </tr>
                            {{--<tr>--}}
                            {{--<th style="width:50%">Less Commission Charged</th><td>{{ number_format($reports->sum('rentPaid')* (1-($commission/100)),2) }}</td>--}}
                            {{--</tr>--}}
                            @if(count($expenditures))
                                <tr style="">
                                    <td rowspan="" style="width:50%;border-bottom: 1px solid #4d4b4b">Expenditures</td>
                                    <th rowspan="" style="width:50%;border-bottom: 1px solid #4d4b4b"></th>
                                </tr>
                                @foreach($expenditures as $expenditure)
                                    <tr>
                                        <th style="width:50%">{{ $expenditure->expenditure->name }}{{ (!is_null($expenditure->remarks))? ' - '. $expenditure->remarks: '' }} </th><td>{{ number_format($expenditure->amount,2)}}</td>
                                    </tr>
                                @endforeach
                                <tr style="">
                                    <th style="width:50%;border-top: 1px solid #4d4b4b">Total Expenditures</th><td style="border-top: 1px solid #4d4b4b">{{ number_format($expenditures->sum('amount'),2)}}</td>
                                </tr>
                            @endif
                            {{--<tr>--}}
                            {{--<th style="width:50%">Less Expenditures</th><td>{{ number_format((($reports->sum('rentPaid')* (1-($commission/100)))  - $expenditures->sum('amount')),2) }}</td>--}}
                            {{--</tr>--}}

                            <tfoot>
                            <tr>
                                <th><h3>Total Payable</h3></th>
                                <th><h3>{{ number_format((($reports->sum('rentPaid')* (1-($commission/100)))  - $expenditures->sum('amount')),2) }}</h3></th>
                            </tr>
                            </tfoot>
                        </table>
                    @endif
                </div>
                {{----}}
                {{--<button class="btn btn-primary no-print" data-toggle="modal" href="#create-modal">Record settlement</button>--}}
            </div>
        </div>


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
    {{--@if(isset($pStatemants))--}}
    {{--<div class="modal fade" id="create-modal" role="dialog">--}}
        {{--{!! Form::open(['route' => 'landlordSettlements.store']) !!}--}}
        {{--<div class="modal-dialog">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                        {{--<span aria-hidden="true">&times;</span>--}}
                    {{--</button>--}}
                    {{--<h4 class="modal-title">Record Landlord Settlement</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--<div class="row">--}}
                        {{--<!-- Landlord Id Field -->--}}
                        {{--<div class="form-group col-sm-12">--}}
                            {{--{!! Form::label('landlord_id', 'Landlord:') !!}--}}
                            {{--<select name="landlord_id" class="form-control select2" required>--}}
                                {{--<option value="{{ $landlord->id }}">{{ $landlord->full_name }}</option>--}}
                            {{--</select>--}}
                        {{--</div>--}}

                        {{--<!-- Date Field -->--}}
                        {{--<div class="form-group col-sm-12">--}}
                            {{--{!! Form::label('date', 'Date:') !!}--}}
                            {{--{!! Form::date('date', null, ['class' => 'form-control','required']) !!}--}}
                        {{--</div>--}}

                        {{--<!-- Amount Collected Field -->--}}
                        {{--<div class="form-group col-sm-12">--}}
                            {{--{!! Form::label('amount_collected', 'Amount Collected:') !!}--}}
                            {{--{!! Form::number('amount_collected', $pStatements->sum('amt_paid'), ['class' => 'form-control']) !!}--}}
                        {{--</div>--}}

                        {{--<!-- Commission Percentage Field -->--}}
                        {{--<div class="form-group col-sm-12">--}}
                            {{--{!! Form::label('commission_percentage', 'Commission Percentage:') !!}--}}
                            {{--{!! Form::number('commission_percentage', $commission, ['class' => 'form-control']) !!}--}}
                        {{--</div>--}}

                        {{--<!-- Commission Amount Field -->--}}
                        {{--<div class="form-group col-sm-12">--}}
                            {{--{!! Form::label('commission_amount', 'Commission Amount:') !!}--}}
                            {{--{!! Form::number('commission_amount', $pStatements->sum('amt_paid')* $commission/100, ['class' => 'form-control']) !!}--}}
                        {{--</div>--}}

                        {{--<!-- Overdraft Field -->--}}
                        {{--<div class="form-group col-sm-12">--}}
                            {{--{!! Form::label('overdraft', 'Overdraft:') !!}--}}
                            {{--{!! Form::number('overdraft', 0, ['class' => 'form-control']) !!}--}}
                        {{--</div>--}}


                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>--}}
                    {{--<button type="submit" class="btn btn-primary">Save</button>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!-- /.modal-content -->--}}
        {{--</div>--}}
        {{--<!-- /.modal-dialog -->--}}
        {{--{!! Form::close() !!}--}}
    {{--</div>--}}
    {{--@endif--}}
@endsection

@push('js')
    <script>
        $('a#landlord-plot-report').parent('li').addClass('active').parent('ul').parent().addClass('active');

    </script>
    @endpush