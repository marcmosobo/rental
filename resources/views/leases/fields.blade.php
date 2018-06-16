<!-- Unit Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('property_id', 'Property:') !!}
    <select name="property" class="form-control select2" id="property_id">
        <option value="">Select Property</option>
        @if(count($properties))
            @foreach($properties as $property)
                <option value="{{ $property->id }}">{{ $property->name }}</option>
                @endforeach
            @endif
    </select>
</div>
<div class="form-group col-sm-12">
    {!! Form::label('house_number', 'House Number:') !!}
    <select name="house_number" class="form-control select2" id="house_number">
        <option value="">Select house number</option>
    </select>
</div>

<!-- Tenant Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('tenant_id', 'Tenant:') !!}
    <select name="tenant_id" class="form-control select2" id="tenant_id">
        <option value="">Select tenant</option>
        @if(count($tenants))
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}">{{ $tenant->full_name }}</option>
            @endforeach
        @endif
    </select>
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-12">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::date('start_date', \Carbon\Carbon::today()->toDateString(), ['class' => 'form-control']) !!}
</div>

{{--<!-- Status Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('status', 'Status:') !!}--}}
    {{--<label class="checkbox-inline">--}}
        {{--{!! Form::hidden('status', false) !!}--}}
        {{--{!! Form::checkbox('status', '1', null) !!} 1--}}
    {{--</label>--}}
{{--</div>--}}

{{--<!-- Created By Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('created_by', 'Created By:') !!}--}}
    {{--{!! Form::number('created_by', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<!-- Client Id Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('client_id', 'Client Id:') !!}--}}
    {{--{!! Form::number('client_id', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

