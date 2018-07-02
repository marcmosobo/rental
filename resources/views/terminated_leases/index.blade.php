@extends('layouts.app')
@section("pageTitle",'Terminated/Reversed Leases')
{{--@section("pageSubtitle",'create, terminate leases')--}}
@section("breadcrumbs")
    <li>Home</li> <li>Leases</li>
    <li>terminated leases</li>
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
            {{--<a class="btn btn-primary pull-right btn-sm" data-toggle="modal" style="margin-top: -10px;margin-bottom: 5px" href="#create-modal">Add New</a>--}}
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

    {{--delete modal--}}
    <div class="modal fade" id="reverse-modal" role="dialog">
        <form id="reverse-form" method="post">
            <input name="_method" type="hidden" value="DELETE">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Reverse Lease</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to reverse this Lease?</p>
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

        $('body').on('click','.reverse-btn',function(){
            var action = $(this).attr('action');
            $("#reverse-form").attr('action',action);
        })
    </script>
@endpush