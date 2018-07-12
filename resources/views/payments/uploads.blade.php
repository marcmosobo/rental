@extends('layouts.app')
 @section("pageTitle",'Cross Check payments')
 {{--@section("pageSubtitle",'create, edit, delete Landlords')--}}
  @section("breadcrumbs")
         <li>Home</li> <li>Crosscheck payments</li>
         @endsection
@section('content')
    <section class="invoice no-print">
        @include('flash::message')
        @include('adminlte-templates::common.errors')
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-8 col-md-offset-1">
                    <div class="form-group" id="date-range-div" >
                        <form action="{{url('crossCheckPayments')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-md-2 col-md-offset-2">
                                <div class="form-group">
                                    {{--<label>Type file</label>--}}
                                    <label>Select file</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="file" name="import_file" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <input type="submit" class="btn btn-success btn-sm" value="Cross Check">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if(isset($payments))
        <section class="invoice">

            <div class="row">
                <div class="col-md-12 table-responsive">
                    {{--<h4 class="">Property statement for: {{ \Carbon\Carbon::parse($from)->toFormattedDateString() }} - {{ \Carbon\Carbon::parse($to)->toFormattedDateString() }}</h4>--}}
                    {{--<p class="">Property: {{ $prop }}</p>--}}
                    {{--<p class="">Landlord/lady: {{ $landlord->full_name }}</p>--}}
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: right;"><p class="lead">Total : {{ number_format($payments->sum('Paid In'),2) }} Ksh</p></td>
                        </tr>
                        <tr>
                            <th>Ref Number</th>
                            <th>Account Number</th>
                            <th>Paid By</th>
                            <th>Initiation time</th>
                            <th>Completion time</th>
                            <th style="text-align: right">Amount </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($payments))
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment['Receipt No.'] }}</td>
                                    <td>{{ $payment['A/C No.'] }}</td>
                                    <td>{{ $payment['Other Party Info'] }}</td>
                                    <td>{{ $payment['Initiation Time'] }}</td>
                                    <td>{{ $payment['Completion Time'] }}</td>
{{--                                    <td>{{  }}</td>--}}
                                    {{--<td>{{ $payment['Receipt No.'] }}</td>--}}
                                    {{--<td>{{ $payment->ref_number }}</td>--}}
{{--                                    <td>{{ (!is_null($payment->masterfile))? $payment->masterfile->full_name : $payment->FirstName.' '.$payment->LastName }}</td>--}}
{{--                                    <td>{{ \Carbon\Carbon::parse($payment->received_on)->toFormattedDateString()}}</td>--}}
                                    <td  style="text-align: right;">{{ number_format($payment['Paid In'],2) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th><h3 class="no-top">{{ count($payments) }} </h3></th>
                                <th><h3 class="no-top"></h3></th>
                                <th><h3 class="no-top"></h3></th>
                                <th><h3 class="no-top"></h3></th>
                                <th><h3 class="no-top">Total</h3></th>
                                <th style="text-align: right;"><h3 class="no-top">{{ number_format($payments->sum('Paid In'),2) }}</h3></th>
                            </tr>
                        @else
                            <tr>
                                <td class="text-center" colspan="6">No records found</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                </div>
                <!-- /.col -->
            </div>

            <br>
            <br>
            <div class="row no-print">
                <div class="col-xs-12">
                    <a onclick="window.print()" target="_blank" class="btn btn-success pull-left"><i class="fa fa-print"></i> Print</a>

                    @if(count($payments))
                        <form method="post" action="{{ url('importTransactions') }}">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $payments }}" name="transactions" required>
                            <button type="submit" class="btn btn-success pull-right">Import</button>
                        </form>
                        @endif

                </div>
            </div>
        </section>
    @endif


@endsection