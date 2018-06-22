@extends('layouts.app')
 @section("pageTitle",'Import Masterfiles')
 {{--@section("pageSubtitle",'create, edit, delete Landlords')--}}
  @section("breadcrumbs")
         <li>Home</li> <li>upload masterfiles</li>
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
                    {{--@include('landlords.table')--}}
                <form action="{{url('importMasterfiles')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-md-3 col-md-offset-2">
                        <div class="form-group">
                            <label>Select file</label>
                        <input type="file" name="import_file" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                    <div class="form-group">
                        <label>Type file</label>
                        <select class="select2 form-control" name="type">
                            <option value="landlords">Landlords</option>
                            <option value="tenants">Tenants</option>
                        </select>
                    </div>
                </div>
                    <div class="col-md-2">
                        <input type="submit" class="btn btn-success btn-sm" value="import">
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection