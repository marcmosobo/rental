@extends('layouts.app')
 @section("pageTitle",'Bank Statement')
 {{--@section("pageSubtitle",'create, edit, delete Claims')--}}
  @section("breadcrumbs")
            <li>Reports</li>
            <li>Bank Statement</li>
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
                        <form action="{{ url('getBankStatement') }}" id="plot-form" method="post">
                            {{ csrf_field() }}
                            <div class="col-md-3">
                                <label>Status</label>
                                <select name="bank" class="form-control select2" required>
                                    <option value="">Select Bank</option>
                                    <option value="all">ALL</option>
                                @if(count($banks))
                                    @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                {{--<input type="text" required value="{{ \Carbon\Carbon::today()->startOfMonth()->toDateString() }}" class="form-control" id="date-from" name="date_from">--}}
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
                {{--<h4 class="">Property statement for: {{ $from }} - {{ $to }}</h4>--}}
                {{--<p class="">Property: {{ $prop }}</p>--}}
                {{--<p class="">Landlord/lady: {{ $landlord->full_name }}</p>--}}
                <table class="table table-striped">
                    {{--<thead>--}}
                    {{--<tr><td><strong>Bank Name:</strong></td><td><strong>{{(is_null($bank_name))? 'All Banks': $bank_name->name}}</strong></td></tr>--}}
                    {{--<td>{{ (!is_null($pays['full_name']))? $pays['full_name'] : $pays['FirstName'].' '.$pays['MiddleName'].' '.$pays['LastName'] }}</td>--}}
                    {{--<tr><td><strong>A/C Number:</strong></td><td><strong>{{(is_null($bank_name))? 'All Accounts':$bank->account_number}}</strong></td></tr>--}}
                    {{--<tr><td><strong>Statement Period</strong></td><td><strong>{{$input['date_from']}}</strong></td><td><strong>To:</strong></td><td><strong>{{$input['date_to']}}</strong></td></tr>--}}
                    {{--<tr><td>A:</td><td>{{$bank_name->branch}}</td></tr>--}}
                    {{--</thead>--}}
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date Paid</th>
                            <th>RefNumber</th>
                            <th>Property Name</th>
                            <th>Unit Number</th>
                            <th style="text-align: right;">Amount paid</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($payments))
                        @foreach($payments as $payment)
                            <tr>
                                {{--<td>{{ (!is_null($pays['full_name']))? $pays['full_name'] : $pays['FirstName'].' '.$pays['MiddleName'].' '.$pays['LastName'] }}</td>--}}
                                <td>{{ $payment->masterfile->full_name }}</td>
                                <td>{{\Carbon\Carbon::parse($payment->received_on)->toFormattedDateString() }}</td>
                                <td>{{$payment->ref_number}}</td>
                                <td>{{$payment->unit->property->name}}</td>
                                <td>{{ $payment->unit->unit_number }}</td>
                                <td  style="text-align: right;">{{ number_format($payment->amount,2) }}</td>
                            </tr>

                            @endforeach



                        <tr>
                            <th><h3 class="no-top">#{{count($payments)}}</h3></th>
                            <th><h3 class="no-top"></h3></th>
                            <th><h3 class="no-top"></h3></th>
                            <th><h3 class="no-top"></h3></th>
                            <th><h3 class="no-top">Totals</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($payments->sum('amount'),2) }}</h3></th>
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
@endsection

@push('js')
    <script>
        $('a#bankStatement').parent('li').addClass('active').parent('ul').parent().addClass('active');

    </script>
    @endpush