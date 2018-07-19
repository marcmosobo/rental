@extends('layouts.app')
 @section("pageTitle",'LandLord Remitance Statement')
 {{--@section("pageSubtitle",'create, edit, delete Claims')--}}
  @section("breadcrumbs")
            <li>Reports</li>
            <li>LandLord </li>
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
                <div class="col-md-11 col-md-offset-1">
                    <div class="form-group" id="date-range-div" >
                        <form action="{{ url('getRemittance') }}" id="plot-form" method="post">
                            {{ csrf_field() }}
                            <div class="col-md-3">
                                <label>Status</label>
                                <select name="landlord" class="form-control select2" required>
                                    <option value="">Select Landlord</option>
                                    <option value="all">ALL</option>
                                @if(count($landlords))
                                    @foreach($landlords as $landlord)
                                            <option value="{{ $landlord->id }}">{{ $landlord->full_name }}</option>
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
    </section>
    @if(isset($landlordsremm))
    <section class="invoice">
        @include('layouts.partials.report-header')

        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        {{--<td><strong>LanLord:</strong></td><td><strong>{{(is_null($bank_name))? 'All Banks': $bank_name->name}}</strong></td></tr>--}}
                    <tr><td><strong>Landlord Name:</strong></td><td><strong>{{ (is_null($landlords2))?"All Landlords": $landlords2->full_name}}</strong></td></tr>
                    <tr><td><strong>Statement Period</strong></td><td><strong>{{$input['date_from']}} {{  ' To '  }}{{$input['date_to']}}</strong></td></tr>
                        <tr>

                            <th>Date Paid</th>

                            <th style="text-align: right;">Amount paid</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($landlordsremm))
                        @foreach($landlordsremm as $payment)
                            <tr>
                                <td>{{\Carbon\Carbon::parse($payment->date)->toFormattedDateString() }}</td>

                                <td  style="text-align: right;">{{ number_format($payment->amount,2) }}</td>
                            </tr>

                            @endforeach
                        <tr>

                            <td><h3 class="no-top">Totals</h3></td>
                            <td style="text-align:right;"><h1 class="no-top">{{ number_format($landlordsremm->sum('amount'),2) }}</h1></td>
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

    <div class="clearfix"></div>
@endsection

@push('js')
    <script>
        $('a#bankStatement').parent('li').addClass('active').parent('ul').parent().addClass('active');
    </script>
    @endpush