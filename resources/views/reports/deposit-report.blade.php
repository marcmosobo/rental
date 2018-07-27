@extends('layouts.app')
 @section("pageTitle",'Deposit report')
 {{--@section("pageSubtitle",'create, edit, delete Claims')--}}
  @section("breadcrumbs")
            <li>Reports</li>
            <li>Deposit Report</li>
         @endsection
@section('content')
    {{--<div class="col-md-12">--}}
        {{--<div class="box">--}}
            {{----}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<section class="content-header">--}}
        {{--<h1 class="pull-right">--}}
           {{--<a href="{{ url('claims/create') }}" class="btn btn-primary btn-sm" style="margin-top: -10px;margin-bottom: 5px" >Create New</a>--}}
        {{--</h1>--}}
    {{--</section>--}}
    <section class="invoice no-print">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ url('getDepositReport') }}" id="policies-form" method="post">
                    {{ csrf_field() }}
                <div class="col-md-5 col-md-offset-2">
                    <label>Filter By</label>
                    <select name="filter_by" class="form-control select2" required>
                        <option value="refunded">Refunded</option>
                        <option value="not-refunded">Not Refunded</option>
                    </select>
                </div>
                    <div class="col-md-2 ">
                        <button type="submit" class="btn btn-primary " style="margin-top: 25px;">Search</button>
                    </div>

                </form>
            </div>
        </div>
    </section>
    @if(isset($deposits))
    <section class="invoice">
        <!-- title row -->

        <!-- info row -->
        @include('layouts.partials.report-header')

        <div class="row">
            <div class="col-md-12 table-responsive">
                {{--<h4 class="">Tenant Statement for: <strong>{{ $tenant_name }}</strong></h4>--}}
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>House Number</th>
                            <th>Tenant</th>
                            <th style="text-align: right">Deposit Amount</th>
                            <th style="text-align: right">Refunded Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($deposits))
                        @php
                        $refunds =0;
                        $depositsAmount = 0;
                        @endphp
                        @foreach($deposits as $deposit)

                            @php
                            $refunds = $refunds + $deposit->refunded;
                            $depositsAmount = $depositsAmount + $deposit->amount;
                            @endphp
                            <tr>
                                <td>{{ $deposit->bill->lease->unit->unit_number }}</td>
                                <td>{{ $deposit->bill->lease->masterfile->full_name }}</td>
                                <td style="text-align: right">{{ number_format($deposit->amount,2) }}</td>
                                <td style="text-align: right">{{ number_format($deposit->refunded,2) }}</td>
                            </tr>
                            @endforeach
                        <tr>
                            <th colspan="2">Totals</th>
                            <th style="text-align: right">{{ number_format($depositsAmount,2)  }}</th>
                            <th style="text-align: right">{{ number_format($refunds,2)  }}</th>
                        </tr>
                        @else
                        <tr>
                            <td class="text-center" colspan="3">No records found</td>
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

                <a onclick="window.print()" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>
            </div>
        </div>
    </section>
    @endif
    <!-- /.content -->
    <div class="clearfix"></div>
@endsection

@push('js')
    <script>
        // $("#policies-form").on('submit',function(e){
        //     e.preventDefault();
        //     var data = {
        //         "date_from": $('#date-from').val(),
        //         "date_to": $('#date-to').val(),
        //     };
        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type:'POST',
        //         dateType: 'json',
        //         data: data,
        //         success:function(data){
        //             var html = '';
        //             if(data.length > 0){
        //                 for(var i=0; i<data.length; i++){
        //                     html += '<tr>' +
        //                         '<td>'+ data[i].policy_number+'</td>' +
        //                         '<td>'+ data[i].payment_mode+'</td>' +
        //                         '<td>'+ data[i].reference+'</td>' +
        //                         '<td>'+ data[i].amount_paid+'</td>'
        //                 }
        //                 $('#tbody').html(html)
        //             }else{
        //                 $('#tbody').html('<tr><td colspan="4" class="text-center">No records available</td></tr>');
        //             }
        //
        //
        //         }
        //     })
        // })
        $('a#depositReport').parent('li').addClass('active').parent('ul').parent().addClass('active');

    </script>
    @endpush