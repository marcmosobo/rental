@extends('layouts.app')
 @section("pageTitle",'Cash/Bank Payments')
{{-- @section("pageSubtitle",'create, edit, delete CashPayments')--}}
  @section("breadcrumbs")
         <li>Home</li> <li>Cash/Bank Payments</li>
         @endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right btn-sm" data-toggle="modal" style="margin-top: -10px;margin-bottom: 5px" href="#create-modal">Make Payment</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        @include('adminlte-templates::common.errors')
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('cash_payments.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="create-modal" role="dialog">
            {!! Form::open(['route' => 'cashPayments.store']) !!}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Create Cash/Bank Payment</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @include('cash_payments.fields')
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

    <div class="modal fade" id="edit-modal" role="dialog">
           <form method="post" id="edit-form">
               {{ csrf_field() }}
           <input name="_method" type="hidden" value="PATCH">
           <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                       <h4 class="modal-title">Edit Cash/Bank Payment</h4>
                   </div>
                   <div class="modal-body">
                        <div class="row">
                           {{--@include('cash_payments.fields')--}}
                            <div class="form-group col-sm-12">
                                {!! Form::label('received_on', 'Received On:') !!}
                                {!! Form::date('received_on', null, ['class' => 'form-control','id'=>'received_on']) !!}
                            </div>

                       <!-- Amount Field -->
                       {{--<div class="form-group col-sm-12">--}}
                           {{--{!! Form::label('payment-mode', 'Payment Mode:') !!}--}}
                           {{--<select class="form-control select2" id="payment-m" name="payment_mode">--}}
                               {{--<option value="CASH">Cash</option>--}}
                               {{--<option value="Bank">Bank</option>--}}
                           {{--</select>--}}
                       {{--</div>--}}
                       {{--<div class="form-group col-sm-12" id="bank-d" style="display: none;">--}}
                           {{--{!! Form::label('bank_id', 'Bank:') !!}--}}
                           {{--<select name="bank_id"  id="bank-i" class="form-control select2">--}}
                               {{--<option value="">Select Bank</option>--}}
                               {{--@if(count($banks))--}}
                                   {{--@foreach($banks as $bank)--}}
                                       {{--<option value="{{ $bank->id }}">{{ $bank->name.' - '.$bank->account_number  }}</option>--}}
                                   {{--@endforeach--}}
                               {{--@endif--}}
                           {{--</select>--}}
                       {{--</div>--}}

                        </div>

                   </div>
                   <div class="modal-footer">
                       <input type="hidden" id="editDetails" value="{{ url("/cashPayments") }}">
                       <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                       <button type="submit" class="btn btn-primary">Save</button>
                   </div>
               </div>
               <!-- /.modal-content -->
           </div>
           </form>
       </div>

     {{--delete modal--}}
        <div class="modal fade" id="delete-modal" role="dialog">
            <form id="delete-form" method="post">
                <input name="_method" type="hidden" value="DELETE">
            {{ csrf_field() }}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Delete Cash Payment</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this Cash Payment?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-primary">Yes</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    @endsection

@push('js')
    <script>

        $('#payment-mode').on('change',function(){
            let val = $(this).val();
            if(val === 'Bank'){
                $('#bank-div').show();
                $('#bank-id').attr('required','required')
            }else{
                $('#bank-id').removeAttr('required');
                $('#bank-div').hide();

            }
        })
        $('#payment-m').on('change',function(){
            let val = $(this).val();
            if(val === 'Bank'){
                $('#bank-d').show();
                $('#bank-i').attr('required','required')
            }else{
                $('#bank-i').removeAttr('required');
                $('#bank-d').hide();

            }
        })
    </script>
@endpush
