@extends('layouts.app')
 @section("pageTitle",'Payments Summary Report')
  @section("breadcrumbs")
            <li>Reports</li>
            <li>Payments History</li>
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
                        <form action="{{ url('getDailyPayments') }}" id="plot-form" method="post">
                            {{ csrf_field() }}
                            <div class="col-md-3">
                                <label>Filter By</label>
                                <select name="filter_by" id="status" class="form-control select2">
                                    <option value="all">All</option>
                                    <option value="processed">Processed</option>
                                    <option value="pending">Pending</option>
                                    <option value="mpesa">MPESA Payments</option>
                                    <option value="bank">Bank Payments</option>
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
    @if(isset($payments))
        <section class="invoice">
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
                    {{--<h4 class="">Property statement for: {{ \Carbon\Carbon::parse($from)->toFormattedDateString() }} - {{ \Carbon\Carbon::parse($to)->toFormattedDateString() }}</h4>--}}
                    {{--<p class="">Property: {{ $prop }}</p>--}}
                    {{--<p class="">Landlord/lady: {{ $landlord->full_name }}</p>--}}
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: right;"><h2>Total : {{ number_format($payments->sum('amount'),2) }} Ksh</h2></td>
                        </tr>
                        <tr>
                            <th>Payment Mode</th>
                            <th>Reference Number</th>
                            {{--<th>Paid By</th>--}}
                            <th>Date Paid</th>
                            <th style="text-align: right">Amount </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($payments))
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_mode }}</td>
                                    <td>{{ $payment->ref_number }}</td>
                                    {{--<td>{{ $payment->reference_mode }}</td>--}}
                                    <td>{{ \Carbon\Carbon::parse($payment->received_on)->toFormattedDateString()}}</td>
                                    <td  style="text-align: right;">{{ number_format($payment['amount'],2) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th><h3 class="no-top">{{ count($payments) }} </h3></th>
                                <th><h3 class="no-top"></h3></th>
                                {{--<th><h3 class="no-top"></h3></th>--}}
                                <th><h3 class="no-top">Totals</h3></th>
                                <th style="text-align: right;"><h3 class="no-top">{{ number_format($payments->sum('amount'),2) }}</h3></th>
                            </tr>
                        @else
                            <tr>
                                <td class="text-center" colspan="5">No records found</td>
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
        $('a#dailyPayments').parent('li').addClass('active').parent('ul').parent().addClass('active');
    </script>
@endpush
