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
                    <form action="{{ url('searchBills') }}" method="post">
                        {{ csrf_field() }}
                        <div class="col-md-3">
                            <label >Search By</label>

                            <div class="form-group">
                                <input type="radio" checked name="filter" class="i-check-line filter" value="tenant"><label> Tenant</label>
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<input type="radio"  name="filter" class="i-check-line filter" value="house_number"><label>House Number</label>--}}
                            {{--</div>--}}
                        </div>
                        <div class="col-md-9">
                        <div class="form-group" id="pre-defined-div"{{-- style="margin-top: 18px;"--}}>
                            <div class="col-md-10 ">
                                <label> Tenant</label>
                                <select name="tenant" class="form-control select2" id="tenant-select" required>
                                    <option value="">Select Tenant</option>
                                    @if(count($tenants))
                                        @foreach($tenants as $tenant)
                                            <option value="{{ $tenant->id }}">{{ $tenant->full_name }}</option>
                                            @endforeach
                                        @endif

                                </select>
                            </div>
                            <div class="col-md-10 " style="display: none;">
                                <label> House Number</label>
                                <select name="house_number" class="form-control select2" id="pre-defined-select">
                                    <option value="">Select House Number</option>

                                </select>
                            </div>
                            <div class="col-md-2 ">
                                <button type="submit" class="btn btn-primary " style="margin-top: 25px;">Search</button>
                            </div>
                        </div>
                </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="invoice">
            <div class="row invoice-info no-print">

                @include('flash::message')
                @include('adminlte-templates::common.errors')
            </div>
        </section>


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
    </script>
    @endpush