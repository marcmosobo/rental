@extends('layouts.app')
 @section("pageTitle",'All Leases')
 @section("pageSubtitle",'create, terminate leases')
  @section("breadcrumbs")
         <li>Home</li> <li>Leases</li>
         @endsection

@section('css')
    <style>
        /*body{*/
        /*margin-top:40px;*/
        /*}*/
        .no-padding-left{
            padding-left: 0;
        }
        .stepwizard-step p {
            margin-top: 10px;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 100%;
            position: relative;
        }

        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }

        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-order: 0;

        }

        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }
    </style>
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
                    @include('leases.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="create-modal" role="dialog">
            {!! Form::open(['route' => 'leases.store']) !!}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Create Lease</h4>
                    </div>
                    <div class="modal-body">
                        {{--<div class="row">--}}
                            {{--@include('leases.fields')--}}


                        {{--</div>--}}
                        <div class="stepwizard">
                            <div class="stepwizard-row setup-panel">
                                <div class="stepwizard-step">
                                    <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                                    <p>Lease Details</p>
                                </div>
                                <div class="stepwizard-step">
                                    <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                                    <p>Confirm Bills Attached</p>
                                </div>


                            </div>
                        </div>
                        <div class="row setup-content" id="step-1">
                            <div class="col-xs-12">
                                <div class="col-md-12">
                                    {{--<h3> Tenant Details</h3><br>--}}
                                    @include('leases.fields')
                                    <br>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-sm nextBtn btn-lg pull-right" type="button" >Next</button>
                                </div>
                            </div>
                        </div>
                        <div class="row setup-content" id="step-2">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <br>
                                </div>
                                <div class="col-md-12" id="service_bills_div">
                                    {{--<h3> Accident Details</h3><br>--}}
                                    {{--@include('claims.accident_details')--}}
                                    <br>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success btn-sm  pull-right" id="finish-btn" >Finish</button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        {{--<div class="col-md-12">--}}
                            {{--<button class="btn btn-primary btn-sm nextBtn btn-lg pull-right" type="button" >Next</button>--}}
                        {{--</div>--}}
                        {{--<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>--}}
                        {{--<button type="submit" class="btn btn-primary">Save</button>--}}
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
                       <h4 class="modal-title">Edit Lease</h4>
                   </div>
                   <div class="modal-body">
                        <div class="row">
                           {{--@include('leases.fields')--}}
                        </div>
                   </div>
                   <div class="modal-footer">
                       <input type="hidden" id="editDetails" value="{{ url("/leases") }}">
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
                            <h4 class="modal-title">Terminate Lease</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to terminate this Lease?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger">Yes</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    @endsection

@push('js')
    <script>
        var uId;
        $(document).ready(function () {

            var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allNextBtn = $('.nextBtn');

            allWells.hide();

            navListItems.click(function (e) {
                e.preventDefault();
                var $target = $($(this).attr('href')),
                    $item = $(this);

                if (!$item.hasClass('disabled')) {
                    navListItems.removeClass('btn-primary').addClass('btn-default');
                    $item.addClass('btn-primary');
                    allWells.hide();
                    $target.show();
                    $target.find('input:eq(0)').focus();
                }
            });

            allNextBtn.click(function(){
                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                    curInputs = curStep.find("input[type='text'],input[type='url']"),
                    isValid = true;

                $(".form-group").removeClass("has-error");
                for(var i=0; i<curInputs.length; i++){
                    if (!curInputs[i].validity.valid){
                        isValid = false;
                        $(curInputs[i]).closest(".form-group").addClass("has-error");
                    }
                }

                if (isValid)
                    nextStepWizard.removeAttr('disabled').trigger('click');
            });

            $('div.setup-panel div a.btn-primary').trigger('click');
        });

        $('#property_id').on('change',function(){
            var pId = $(this).val();

            if(pId !== ''){
                $.ajax({
                    url: '{{ url('getUnits') }}'+'/'+ pId,
                    type:'GET',
                    dataType: 'json',
                    success: function(data){
                        let html = '<option value="">Select house number</option>';
                        if(data.length >0){
                            for(let i =0; i<data.length;i++){
                                html += '<option value="'+data[i].id+'">'+data[i].unit_number+'</option>';
                            }
                        }else{
                            html = '<option value="">Please add more units to this property first</option>';
                        }
                        $('#house_number').html(html);
                    }
                })
            }else{
                $('#house_number').html('<option value="">Select house number</option>');
            }
        });
        $('#house_number').on('change',function () {
            let id = $(this).val();

            if(id !== ""){
                uId =id;
                $.ajax({
                    url: '{{ url('getBills') }}'+'/'+id,
                    type:'GET',
                    dataType:'json',
                    success: function(data){
                        if(data.length){
                            let html = '<table class="table table-striped table-hover">' +
                                '<thead>' +
                                '<tr>' +
                                '<th>Bill Name</th>' +
                                '<th>Bill Amount</th>' +
                                '<th>Bill Interval</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody>' ;

                            for(let i=0; i<data.length; i++){
                                html += '<tr>' +
                                    '<td>'+data[i].name+'</td>' +
                                    '<td>'+data[i].amount+'</td>' +
                                    '<td>'+data[i].period+'</td>' +
                                    '</tr>'
                            }
                            html += '</tbody>' +
                                '</table>';
                            $('#service_bills_div').html(html)
                            $('#finish-btn').show();
                        }else{
                            $('#service_bills_div').html('' +
                                '<div class="alert alert-info">' +
                                'There are no service bills attached to this house unit, kindly add at least one to continue ' +
                                '</div>');
                            $('#finish-btn').hide();

                        }

                    }
                })
            }
        })
    </script>
@endpush