@extends('layouts.app')
 @section("pageTitle",'Pay Bills')
 @section("pageSubtitle",'Search and pay bills')
  @section("breadcrumbs")
         <li>Home</li> <li>PayBills</li>
         @endsection

@section('css')
    {{--<style>--}}
        {{--﻿table thead--}}
        {{--{--}}
            {{--background-color:#ddd;--}}
        {{--}--}}
        {{--.product {--}}
            {{--height: 120px;--}}
            {{--padding:0px 2px 2px 0px;--}}
            {{--margin-bottom:2px;--}}
            {{--text-align: center;--}}
            {{--background-size: cover;--}}
            {{--color: #fff;--}}
            {{--overflow: hidden;--}}
            {{---webkit-transition: all 0.3s ease-in-out 0.1s;--}}
            {{---moz-transition: all 0.3s ease-in-out 0.1s;--}}
            {{---o-transition: all 0.3s ease-in-out 0.1s;--}}
            {{---ms-transition: all 0.3s ease-in-out 0.1s;--}}
            {{--transition: all 0.3s ease-in-out 0.1s;--}}
        {{--}--}}
        {{--.waves-effect {--}}
            {{--position: relative;--}}
            {{--display: inline-block;--}}
            {{--overflow: hidden;--}}
            {{---webkit-user-select: none;--}}
            {{---moz-user-select: none;--}}
            {{---ms-user-select: none;--}}
            {{--user-select: none;--}}
            {{---webkit-tap-highlight-color: transparent;--}}
        {{--}--}}
        {{--.product h3--}}
        {{--{--}}
            {{--position: absolute;--}}
            {{--width: 100%;--}}
            {{--text-align: center;--}}
            {{--color: #000;--}}
            {{--display: block;--}}
            {{--font-weight: 700;--}}
            {{--font-size: 0.9em;--}}
            {{--text-transform: uppercase;--}}
            {{---webkit-transition: all 0.1s ease-in-out 0.1s;--}}
            {{---moz-transition: all 0.1s ease-in-out 0.1s;--}}
            {{---o-transition: all 0.1s ease-in-out 0.1s;--}}
            {{---ms-transition: all 0.1s ease-in-out 0.1s;--}}
            {{--transition: all 0.1s ease-in-out 0.1s;--}}
        {{--}--}}
        {{--.product .btn{--}}
            {{--position: absolute;--}}
            {{--top: 77px;--}}
            {{--text-align: center;--}}
            {{--left: 35px;--}}
            {{--cursor: pointer;--}}
            {{--z-index:9;--}}
        {{--}--}}

        {{--.product img {--}}
            {{--width: 100%;--}}
            {{--height: 120px;--}}
            {{--opacity: 0.3;--}}
            {{---webkit-transition: all 0.3s ease-in-out 0.1s;--}}
            {{---moz-transition: all 0.3s ease-in-out 0.1s;--}}
            {{---o-transition: all 0.3s ease-in-out 0.1s;--}}
            {{---ms-transition: all 0.3s ease-in-out 0.1s;--}}
            {{--transition: all 0.3s ease-in-out 0.1s;--}}
        {{--}--}}

        {{--.product:hover h3 {--}}
            {{--opacity: 1;--}}
        {{--}--}}
        {{--.mask h3 {--}}
            {{--margin-top: 50px;--}}
        {{--}--}}
        {{--.delete--}}
        {{--{--}}
            {{--color:Red;--}}
            {{--cursor:pointer;--}}
        {{--}--}}
        {{--#productList th,#productList td{text-align:right;padding:5px}--}}
        {{--#productList th.name,#productList td.name{text-align:left;}--}}
        {{--#productList input.qty {--}}
            {{--text-align:center;height: 23px;padding-right: 1px;padding-left: 2px;--}}
        {{--}--}}
        {{--#ticketModal{width:380px}--}}
        {{--#printSection table td,#printSection table th{font-size:14px;padding:2px}--}}

        {{--#OpenBill .bill--}}
        {{--{--}}
            {{--background-color: #834f50;--}}
            {{--color: #FFF;--}}
            {{--margin: 7px 20px;--}}
            {{--padding-top: 10px;--}}
            {{--padding-bottom: 10px;--}}
        {{--}--}}
    {{--</style>--}}
    @endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-right">
           {{--<a class="btn btn-primary pull-right btn-sm" data-toggle="modal" style="margin-top: -10px;margin-bottom: 5px" href="#create-modal">Add New</a>--}}
        </h1>
    </section>
    <div class="content">
        {{--<section class="invoice no-print">--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-12">--}}
                    {{--<form action="{{ url('searchBills') }}" method="post">--}}
                        {{--{{ csrf_field() }}--}}
                        {{--<div class="col-md-2">--}}
                            {{--<label >Search By</label>--}}

                            {{--<div class="form-group">--}}
                                {{--<input type="radio" checked name="filter" class="i-check-line filter" value="tenant"><label> Tenant</label>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<input type="radio"  name="filter" class="i-check-line filter" value="house_number"><label>House Number</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-8">--}}
                        {{--<div class="form-group" id="pre-defined-div"--}}{{-- style="margin-top: 18px;"--}}{{-->--}}
                            {{--<div class="col-md-10 ">--}}
                                {{--<label> Select House Number</label>--}}
                                {{--<select name="tenant" class="form-control select2" id="tenant-select" required>--}}
                                    {{--<option value="">Select house number/tenant</option>--}}
                                    {{--@if(count($tenants))--}}
                                        {{--@foreach($tenants as $tenant)--}}
                                            {{--<option value="{{ $tenant->id }}">{{ $tenant->unit->unit_number.' - '.  $tenant->masterfile->full_name }}</option>--}}
                                            {{--@endforeach--}}
                                        {{--@endif--}}

                                {{--</select>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-10 " style="display: none;">--}}
                                {{--<label> House Number</label>--}}
                                {{--<select name="house_number" class="form-control select2" id="pre-defined-select">--}}
                                    {{--<option value="">Select House Number</option>--}}

                                {{--</select>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-2 ">--}}
                                {{--<button type="submit" class="btn btn-primary " style="margin-top: 25px;">Search</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</section>--}}

        @if(isset($payment))
        <section class="invoice">
            <div class="row invoice-info no-print">

                {{--@include('flash::message')--}}
                {{--@include('adminlte-templates::common.errors')--}}
            </div>

            <div class="modal-dialog" role="document" id="ticketModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="ticket">
                            Receipt #{{ $payment->id }}
                        </h4>
                    </div>
                    <div class="modal-body" id="modal-body">
                        <div id="printSection">
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">

                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col text-center">
                                    <address>
                                        <strong>Marite Enterprises Limited</strong><br>
                                        Lentile House, 2<sup>nd</sup> Floor Rm 213<br>
                                        P.O Box 1440 - 10400<br>
                                        Nanyuki<br>
                                        <br>
                                        Phone number: 0700634000
                                        Email: info@mariteenterprises.co.ke
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">

                                </div>
                                <!-- /.col -->
                            </div>
                            <div class="">
                                <div style="clear: both;">
                                    <h4 class="text-center">
                                        Payment receipt
                                    </h4>
                                    <span><strong>Ref Number: {{ $payment->ref_number }} </strong></span>
                                    {{--<hr style="border-top: 1px solid #000; padding-top: 2px;margin-bottom: 2px;">--}}
                                    <table class="table" cellspacing="0" border="0" style="margin-bottom: 8px; border-top: 1px solid #000;">
                                        <thead style="background-color: #ffffff;">
                                        <tr>
                                            <td>Date</td>
                                            <td></td>
                                            <td style="text-align: right">{{ \Carbon\Carbon::parse($payment->received_on)->toFormattedDateString() }}</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td style="text-align: left; padding-top: 5px;">
                                                Tenant
                                            </td>
                                            <td style="padding-top: 5px; text-align: right;"></td>
                                            <td style="padding-top: 5px; text-align: right;">
                                                {{ \App\Models\Masterfile::find($payment->tenant_id)->full_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left; padding-top: 5px;">
                                                House Number
                                            </td>
                                            <td style="padding-top: 5px; text-align: right;"></td>
                                            <td style="padding-top: 5px; text-align: right;">
                                                {{ \App\Models\PropertyUnit::find($payment->house_number)->unit_number }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left; padding-top: 5px;">
                                                Amount Received
                                            </td>
                                            <td style="padding-top: 5px; text-align: right;"></td>
                                            <td style="padding-top: 5px; text-align: right;">
                                                <strong>{{ number_format($payment->amount) }} Ksh</strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div style="clear: both;">
                                        <div style="clear: both;">
                                            <div style="border-top: 1px solid #000; padding-top: 10px;">
                                                <span class="float-right">
                                                    Served by: {{\Illuminate\Support\Facades\Auth::user()->name}}
                                                </span>
                                                <div style="clear: both;margin-top: 20px">
                                                    <p class="text-center" style="margin: 0 auto; margin-top: 10px;">
                                                    </p>
                                                    {{--<div class="text-center" style="background-color: #000; padding: 5px; width: 85%;color: #fff; margin: 0 auto; border-radius: 3px; margin-top: 20px;">--}}
                                                        {{--Thank you for your business--}}
                                                    {{--</div>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer no-print">
                        <button type="button" class="btn btn-primary" onclick="PrintTicket()">
                            print
                        </button>
                    </div>
                </div>
            </div>
        </section>
        @endif


        @if(isset($bills))
        <section class="invoice">
            <div class="row invoice-info no-print">

                <div class="col-sm-4 text-center col-md-offset-8 invoice-col">
                    <p> <h3 class="total-amount inline"></h3></p>
                </div>
                <!-- /.col -->
            </div>

            <div class="row">
                <div class="col-md-12 table-responsive">
                    @if(count($bills))
                        <div class="col-md-11">
                            <ul class="list-unstyled">
                                <li ><a href="#create-modal" data-toggle="modal" class="btn btn-sm btn-primary pull-right">Make Payment</a> </li>
                            </ul>
                        </div>
                        @endif

                    <br>
                    <br>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Bill Name</th>
                            <th>Bill Date</th>
                            <th>Bill Amount</th>
                            <th>Amount Paid</th>
                            <th>Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($bills))
                                @foreach($bills as $bill)
                                    <tr>
                                        <td>{{ $bill->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($bill->created_at)->toFormattedDateString() }}</td>
                                        <td>{{ $bill->amount }}</td>
                                        <td>{{ $bill->amount - $bill->balance }}</td>
                                        <td>{{ $bill->balance }}</td>
                                    </tr>
                                    @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><h3>{{ number_format($bills->sum('balance')) }} Ksh</h3></td>
                                </tr>
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">No records </td>
                                </tr>
                                @endif

                        </tbody>
                        <tfoot id="total-foot" style="display: none">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td id="total"><h3>Total</h3></td>
                            <td ><h3 class="total-amount"></h3></td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="col-md-4 col-md-offset-8">


                    </div>

                </div>
                <!-- /.col -->
            </div>


            <!-- /.row -->


            {{--<!-- this row will not appear when printing -->--}}
            {{--<br>--}}
            {{--<br>--}}
            {{--<div class="row no-print">--}}
                {{--<div class="col-xs-12">--}}

                    {{--<a onclick="window.print()" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        </section>
            @endif
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="create-modal" role="dialog">
            {!! Form::open(['route' => 'payBills.store']) !!}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Pay Bill</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @include('pay_bills.fields')
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        {!! Form::close() !!}
    </div>

    @endsection

@push('js')
    <script>
        $('a#payBills').parent('li').addClass('active').parent('ul').parent().addClass('active');

        function PrintTicket() {
            //            $('.modal-body').removeAttr('id');
            //            $('.modal-header').html('');
            //            window.print();
            //            $('.modal-body').attr('id', 'modal-body');
            var divElements = document.getElementById('modal-body').innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            // document.body.innerHTML =
            //     "<html><head><title>Print Copy</title></head><body style=\"width:380px\"><center>" +
            //     divElements + "</center></body>";
            //printWindow.document.write('<html><head><title>Report Print</title>');
            //Print Page
            window.print();

            //Restore orignal HTML
            // document.body.innerHTML = oldPage;
        }

        $('#payment-mode').on('change',function(){
            let val = $(this).val();
            if(val === 'Bank slip'){
                $('#bank-div').show();
            }else{
                $('#bank-div').hide();
            }
        })
    </script>
    @endpush

{{--@section Scripts--}}
{{--{--}}
{{--<script type="text/javascript">--}}

{{--</script>--}}
{{--}--}}

