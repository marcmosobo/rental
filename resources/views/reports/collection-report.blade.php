@extends('layouts.app')
 @section("pageTitle",'Collection report summary')
 {{--@section("pageSubtitle",'create, edit, delete Claims')--}}
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
                                <label>Status</label>
                                <select name="status" id="status"  class="form-control">
                                    <option value="all">All</option>
                                    <option value="processed">Processed</option>
                                    <option value="pending">Pending</option>
                                    <option value="mpesa">MPESA</option>
                                    <option value="bank">Bank</option>
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
    @if(isset($pay))
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
                {{--<h4 class="">Property statement for: {{ $from }} - {{ $to }}</h4>--}}
                {{--<p class="">Property: {{ $prop }}</p>--}}
                {{--<p class="">Landlord/lady: {{ $landlord->full_name }}</p>--}}
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date Paid</th>
                            <th>RefNumber</th>
                            <th>Property Name</th>
                            <th>Unit Number</th>
                            <th>Amount Paid</th>
                            {{--<th>Status</th>--}}
                            {{--<th style="text-align: right;">Monthly Rent</th>--}}
                            {{--<th style="text-align: right;">Arrears B/F</th>--}}
                            {{--<th style="text-align: right;">Total Due</th>--}}
                            {{--<th style="text-align: right;">Amount Paid</th>--}}
                            {{--<th style="text-align: right;">Arrears C/F</th>--}}
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($pay))
                        <?php $total=0; ?>
                        @foreach($pay as $pays)

                            @php

                                $total=$total+$pays->amount;

                            @endphp
                            <tr>
                                <td>{{ (!is_null($pays['full_name']))? $pays['full_name'] : $pays['FirstName'].' '.$pays['MiddleName'].' '.$pays['LastName'] }}</td>
                                <td>{{$pays['TransTime']}}</td>
                                <td>{{$pays['ref_number']}}</td>
                                <td>{{$pays['name']}}</td>
                                <td>{{ $pays['house_number'] }}</td>
                                <td  style="text-align: right;">{{ number_format($pays['amount'],2) }}</td>
                            </tr>

                            @endforeach



                        <tr>
                            <th><h3 class="no-top"></h3></th>
                            <th><h3 class="no-top"></h3></th>
                            <th><h3 class="no-top"></h3></th>
                            <th><h3 class="no-top"></h3></th>
                            <th><h3 class="no-top">Totals</h3></th>
                            <th style="text-align: right;"><h3 class="no-top">{{ number_format($pay->sum('amount'),2) }}</h3></th>
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
        // $('a#propertyStatement').parent('li').addClass('active').parent('ul').parent().addClass('active');

    </script>
    @endpush