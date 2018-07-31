@extends('layouts.app')
 @section("pageTitle",'Landlord Remittances')
 @section("pageSubtitle",'create, edit, delete LandlordRemittances')
  @section("breadcrumbs")
         <li>Home</li> <li>LandlordRemittances</li>
         @endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right btn-sm" data-toggle="modal" style="margin-top: -10px;margin-bottom: 5px" href="#create-modal">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        @include('adminlte-templates::common.errors')
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('landlord_remittances.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="create-modal" role="dialog">
            {!! Form::open(['route' => 'landlordRemittances.store']) !!}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Create Landlord Remittance</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @include('landlord_remittances.fields')
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
                       <h4 class="modal-title">Edit Landlord Remittance</h4>
                   </div>
                   <div class="modal-body">
                        <div class="row">
                           @include('landlord_remittances.fields')
                        </div>
                   </div>
                   <div class="modal-footer">
                       <input type="hidden" id="editDetails" value="{{ url("/landlordRemittances") }}">
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
                            <h4 class="modal-title">Delete Landlord Remittance</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this Landlord Remittance?</p>
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
        $('#payment_mode').on('change',function(){
            let mode = $(this).val();
            if(mode === 'Bank'){
                let landlord_id = $('#landlord_id').val();
                if(landlord_id!== ''){
                    $('#bank-div').show();
                    $('#bank_id').attr('required','required');

                    $.ajax({
                        url: '{{ url('getLandBanks') }}'+'/'+landlord_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            if(data.length >0){
                                let html = '<option value="">Choose Bank Account</option>';
                                for(var i=0; i<data.length; i++){
                                    html += '<option value="'+data[i].id+'">'+data[i].account_number+'</option>';
                                }
                                $('#bank_id').html(html);
                            }else{
                                let html = '<option value="">This landlord has no bank account defined</option>';
                                $('#bank_id').html(html);
                            }

                            // $('#bank_id').html(html);
                        }
                    });
                }else{
                    $('#payment_mode').val('CASH').change();
                    alert('you must choose a landlord first');
                }
            }else{
                $('#bank-div').hide();
                $('#bank_id').removeAttr('required');
            }
        });

        $('#landlord_id').on('change',function(){
            let mode = $('#payment_mode').val();
            // alert(mode);
            if(mode === 'Bank'){
                let landlord_id = $('#landlord_id').val();
                if(landlord_id!== ''){
                    $('#bank-div').show();
                    $('#bank_id').attr('required','required');

                    $.ajax({
                        url: '{{ url('getLandBanks') }}'+'/'+landlord_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            if(data.length >0){
                                let html = '<option value="">Choose Bank Account</option>';
                                for(var i=0; i<data.length; i++){
                                    html += '<option value="'+data[i].id+'">'+data[i].account_number+'</option>';
                                }
                                $('#bank_id').html(html);
                            }else{
                                let html = '<option value="">This landlord has no bank account defined</option>';
                                $('#bank_id').html(html);
                            }

                            // $('#bank_id').html(html);
                        }
                    });
                }else{
                    $('#payment_mode').val('CASH').change();
                    alert('you must choose a landlord first');
                }
            }else{
                $('#bank-div').hide();
                $('#bank_id').removeAttr('required');
            }
        });
    </script>
    @endpush