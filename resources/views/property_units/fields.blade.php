<!-- Property Id Field -->
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('property_id', 'Property Id:') !!}--}}
    {{--{!! Form::number('property_id', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}
<input name="property_id" value="{{ (!empty($property))? $property->id : ""  }}" type="hidden">

<!-- Unit Number Field -->
<div class="form-group col-sm-12">
    {!! Form::label('unit_number', 'Unit Number:') !!}
    {!! Form::text('unit_number', null, ['class' => 'form-control','required']) !!}
</div>

{{--<!-- Status Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('status', 'Status:') !!}--}}
    {{--<label class="checkbox-inline">--}}
        {{--{!! Form::hidden('status', false) !!}--}}
        {{--{!! Form::checkbox('status', '1', null) !!} 1--}}
    {{--</label>--}}
{{--</div>--}}

