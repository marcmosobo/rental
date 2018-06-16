@extends('layouts.app')
@section("pageTitle")
    <a href="{{ \Illuminate\Support\Facades\URL::previous() }}" style="color: #1b1e21"><i class="fa fa-arrow-circle-left"></i> </a>
    {{ (!empty($unit))? 'Service bills for house ('.$unit->unit_number.')' : "" }}
@endsection
 {{--@section("pageSubtitle",'create, edit, delete UnitServiceBills')--}}
  @section("breadcrumbs")
         <li>Home</li> <li>UnitServiceBills</li>
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
                    @include('unit_service_bills.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="create-modal" role="dialog">
            {!! Form::open(['route' => 'unitServiceBills.store']) !!}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Create Unit Service Bill</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @include('unit_service_bills.fields')
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
                       <h4 class="modal-title">Edit Unit Service Bill</h4>
                   </div>
                   <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                {!! Form::label('amount', 'Amount:') !!}
                                {!! Form::number('amount', null, ['class' => 'form-control']) !!}
                            </div>

                            <!-- Period Field -->
                            <div class="form-group col-sm-12">
                                {!! Form::label('period', 'Period:') !!}
                                <select name="period" id="period" class="form-control select2">
                                    <option value="Monthly">Monthly</option>
                                    <option value="Once">Once</option>
                                </select>
                            </div>

                            <!-- Status Field -->
                            <div class="form-group col-sm-12">
                                {!! Form::label('status', 'Status:') !!}
                                <select name="status" id="status" class="select2 form-control">
                                    <option value="1">Active</option>
                                    <option value="0">In active</option>
                                </select>
                            </div>
                        </div>
                   </div>
                   <div class="modal-footer">
                       <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                       <input type="hidden" id="editDetails" value="{{ url("/unitServiceBills") }}">
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
                            <h4 class="modal-title">Delete Unit Service Bill</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this Unit Service Bill?</p>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="unit_id" value="{{ $unit->id }}">
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
        $('a#properties').parent('li').addClass('active').parent('ul').parent().addClass('active')
    </script>
@endpush