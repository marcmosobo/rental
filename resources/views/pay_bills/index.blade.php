@extends('layouts.app')
 @section("pageTitle",'Pay Bills')
 @section("pageSubtitle",'Search and pay bills')
  @section("breadcrumbs")
         <li>Home</li> <li>PayBills</li>
         @endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-right">
           {{--<a class="btn btn-primary pull-right btn-sm" data-toggle="modal" style="margin-top: -10px;margin-bottom: 5px" href="#create-modal">Add New</a>--}}
        </h1>
    </section>
    <div class="content">
        <section class="invoice no-print">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <label >Search By</label>
                        <div class="form-group">
                            <input type="radio" checked name="filter" class="i-check-line filter" value="pre-defined"><label>House Number</label>
                        </div>
                        <div class="form-group">
                            <input type="radio" name="filter" class="i-check-line filter" value="date-range"><label> Tenant</label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group" id="pre-defined-div" style="margin-top: 18px;">
                            <div class="col-md-10 ">
                            <label> House Number</label>
                            <select name="period" class="form-control select2" id="pre-defined-select">
                                <option value="today">Select House Number</option>

                            </select>
                            </div>
                            <div class="col-md-2 ">
                                <button type="submit" class="btn btn-primary " style="margin-top: 25px;">Search</button>
                            </div>
                        </div>
                        <div class="form-group" id="date-range-div" style="margin-top: 18px;display: none;">
                            <form action="{{ url('getExpectedRepayments') }}" id="policies-form" method="post">
                                {{ csrf_field() }}
                                <div class="col-md-5">
                                    <label>From</label>
                                    <input type="date" required class="form-control" id="date-from" name="from">
                                </div>
                                <div class="col-md-5">
                                    <label>To</label>
                                    <input type="date" required class="form-control" id="date-to" name="from">
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
        {{--<section class="invoice">--}}
            {{--<!-- title row -->--}}

            {{--<!-- info row -->--}}
            {{--<div class="row invoice-info">--}}
                {{--<div class="col-sm-4 invoice-col">--}}

                {{--</div>--}}
                {{--<!-- /.col -->--}}
                {{--<div class="col-sm-4 invoice-col text-center">--}}

                    {{--<address>--}}
                        {{--<strong>Expected Repayments</strong><br>--}}
                        {{--795 Folsom Ave, Suite 600<br>--}}
                        {{--San Francisco, CA 94107<br>--}}
                        {{--Phone: (555) 539-1037<br>--}}
                        {{--Email: john.doe@example.com--}}
                    {{--</address>--}}
                {{--</div>--}}
                {{--<!-- /.col -->--}}
                {{--<div class="col-sm-4 invoice-col">--}}

                {{--</div>--}}
                {{--<!-- /.col -->--}}
            {{--</div>--}}
            {{--<!-- info row -->--}}
            {{--<div class="row invoice-info no-print">--}}

                {{--<div class="col-sm-4 text-center col-md-offset-8 invoice-col">--}}
                    {{--<p> <h3 class="total-amount inline"></h3></p>--}}
                {{--</div>--}}
                {{--<!-- /.col -->--}}
            {{--</div>--}}

            {{--<div class="row">--}}
                {{--<div class="col-md-12 table-responsive">--}}
                    {{--<table class="table table-striped">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th>Client</th>--}}
                            {{--<th>Phone Number</th>--}}
                            {{--<th>Repayment Date</th>--}}
                            {{--<th>Amount</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody id="tbody">--}}

                            {{--<tr>--}}
                                {{--<td colspan="4" class="text-center">No records </td>--}}
                            {{--</tr>--}}
                        {{--</tbody>--}}
                        {{--<tfoot id="total-foot" style="display: none">--}}
                        {{--<tr>--}}
                            {{--<td></td>--}}
                            {{--<td></td>--}}
                            {{--<td id="total"><h3>Total</h3></td>--}}
                            {{--<td ><h3 class="total-amount"></h3></td>--}}
                        {{--</tr>--}}
                        {{--</tfoot>--}}
                    {{--</table>--}}
                    {{--<div class="col-md-4 col-md-offset-8">--}}


                    {{--</div>--}}

                {{--</div>--}}
                {{--<!-- /.col -->--}}
            {{--</div>--}}
            {{--<!-- /.row -->--}}


            {{--<!-- this row will not appear when printing -->--}}
            {{--<br>--}}
            {{--<br>--}}
            {{--<div class="row no-print">--}}
                {{--<div class="col-xs-12">--}}

                    {{--<a onclick="window.print()" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</section>--}}
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
                        <h4 class="modal-title">Create Pay Bill</h4>
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