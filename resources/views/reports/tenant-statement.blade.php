@extends('layouts.app')
 @section("pageTitle",'Tenant Statement Report')
 {{--@section("pageSubtitle",'create, edit, delete Claims')--}}
  @section("breadcrumbs")
            <li>Reports</li>
            <li>Tenant Statement</li>
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
                <form action="{{ url('getPaymentsReport') }}" id="policies-form" method="post">
                    {{ csrf_field() }}
                <div class="col-md-5 col-md-offset-3">
                    <label>Tenant</label>
                    <select name="tenant" class="form-control select2">
                        <option value="">Select tenant</option>
                        @if(count($tenants))
                            @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}">{{ $tenant->full_name }}</option>
                                @endforeach
                            @endif
                    </select>
                </div>

                </form>
            </div>
        </div>
    </section>
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
                {{--<p class="lead">T.P Vehicles Involved</p>--}}
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Bill Type</th>
                            <th>Debit</th>
                            <th>Debit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center" colspan="4">Select tenant</td>
                        </tr>
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
    <!-- /.content -->
    <div class="clearfix"></div>
@endsection

@push('js')
    <script>
        $("#policies-form").on('submit',function(e){
            e.preventDefault();
            var data = {
                "date_from": $('#date-from').val(),
                "date_to": $('#date-to').val(),
            };
            $.ajax({
                url: $(this).attr('action'),
                type:'POST',
                dateType: 'json',
                data: data,
                success:function(data){
                    var html = '';
                    if(data.length > 0){
                        for(var i=0; i<data.length; i++){
                            html += '<tr>' +
                                '<td>'+ data[i].policy_number+'</td>' +
                                '<td>'+ data[i].payment_mode+'</td>' +
                                '<td>'+ data[i].reference+'</td>' +
                                '<td>'+ data[i].amount_paid+'</td>'
                        }
                        $('#tbody').html(html)
                    }else{
                        $('#tbody').html('<tr><td colspan="4" class="text-center">No records available</td></tr>');
                    }


                }
            })
        })
    </script>
    @endpush