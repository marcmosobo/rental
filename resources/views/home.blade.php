@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2 col-md-offset-10">
        @include('flash::message')
        @include('adminlte-templates::common.errors')
            <!-- small box -->
            {{--<div class="small-box bg-aqua">--}}
                {{--<div class="inner">--}}
                    {{--<h3></h3>--}}

                    {{--<p>Employees on ground</p>--}}
                {{--</div>--}}
                {{--<div class="icon">--}}
                    {{--<i class="ion ion-ios-people-outline"></i>--}}
                {{--</div>--}}
                {{--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
            {{--</div>--}}
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <p>SMS Credits remaining</p>
                    <h3><span id="bal-span">...</span><sup style="font-size: 20px"> Ksh</sup></h3>

                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                {{--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
            </div>
        </div>
        {{--<!-- ./col -->--}}
        {{--<div class="col-lg-3 col-xs-6">--}}
            {{--<!-- small box -->--}}
            {{--<div class="small-box bg-yellow">--}}
                {{--<div class="inner">--}}
                    {{--<h3>44</h3>--}}

                    {{--<p>User Registrations</p>--}}
                {{--</div>--}}
                {{--<div class="icon">--}}
                    {{--<i class="ion ion-person-add"></i>--}}
                {{--</div>--}}
                {{--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<!-- ./col -->--}}
        {{--<div class="col-lg-3 col-xs-6">--}}
            {{--<!-- small box -->--}}
            {{--<div class="small-box bg-red">--}}
                {{--<div class="inner">--}}
                    {{--<h3>65</h3>--}}

                    {{--<p>Unique Visitors</p>--}}
                {{--</div>--}}
                {{--<div class="icon">--}}
                    {{--<i class="ion ion-pie-graph"></i>--}}
                {{--</div>--}}
                {{--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
            {{--</div>--}}
        {{--</div>--}}
        <!-- ./col -->
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function(){
            $.ajax({
                url: '{{ url('infobipBalance') }}',
                type: 'GET',
                beforeSend: function(){
                    // $("#bal-span").html('...')
                },
                dataType: 'json',
                success: function(data){
                    $("#bal-span").html(data)
                }
            });
        });
    </script>
    @endpush
