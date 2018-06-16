@extends('layouts.app')
 @section("pageTitle")
     <a href="{{ url('properties') }}" style="color: #1b1e21"><i class="fa fa-arrow-circle-left"></i> </a>
     {{ (!empty($property))? 'Property Units for '.$property->name : "" }}
     @endsection
 {{--@section("pageSubtitle",'create, edit, delete PropertyUnits')--}}
  @section("breadcrumbs")
         <li>Home</li> <li>PropertyUnits</li>
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
                    @include('property_units.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="create-modal" role="dialog">
            {!! Form::open(['route' => 'propertyUnits.store']) !!}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Create Property Unit</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @include('property_units.fields')
                            @if(count($services))
                                <div class="form-group col-sm-12 form-horizontal" >
                                    <div class="col-md-4">
                                        <label>Service</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Amount</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Interval</label>
                                    </div>
                                </div>
                                @foreach($services as $service)
                                    <div class="form-group col-sm-12 form-horizontal parent-div" style="padding-left: 0;padding-right: 0;">
                                        <div class="col-md-4">
                                            <label class="control-label"> <input type="checkbox" name="service_bills[{{ $service->id }}][service_bill_id]" value="{{ $service->id }}" class="minimal-red service-bill"><span style="padding-left: 10px;">{{ $service->name }}</span></label>
                                        </div>
                                        <div class="col-md-4 params" style="display: none;">
                                            <input type="number" class="form-control amount" name="service_bills[{{ $service->id }}][amount]" placeholder="amount">
                                        </div>
                                        <div class="col-md-4 params" style="display: none;">
                                            <select class="form-control select2" name="service_bills[{{ $service->id }}][period]">
                                                <option value="Monthly">Monthly</option>
                                                <option value="Once">Once</option>
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
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
                       <h4 class="modal-title">Edit Property Unit</h4>
                   </div>
                   <div class="modal-body">
                        <div class="row">
                           @include('property_units.fields')
                        </div>
                   </div>
                   <div class="modal-footer">
                       <input type="hidden" id="editDetails" value="{{ url("/propertyUnits") }}">
                       <input name="property_id" value="{{ (!empty($property))? $property->id : ""  }}" type="hidden">
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
                            <h4 class="modal-title">Delete Property Unit</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this Property Unit?</p>
                        </div>
                        <div class="modal-footer">
                            <input name="property_id" value="{{ (!empty($property))? $property->id : ""  }}" type="hidden">
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
      $('a#properties').parent('li').addClass('active').parent('ul').parent().addClass('active');
      
      $('.service-bill').on('ifClicked',function () {
          var divs = $(this).parents('div.parent-div').find('.params');
            if(!$(this).is(':checked')){
                divs.find('.amount').attr('required','required');
                divs.show();
            }else{
                divs.hide();
                divs.find('.amount').removeAttr('required');
            }
      })

    </script>
    @endpush