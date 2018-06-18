<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','required']) !!}
</div>

<!-- Code Field -->
<div class="form-group col-sm-12">
    {!! Form::label('code', 'Code:') !!}
    {!! Form::text('code', null, ['class' => 'form-control','required']) !!}
</div>

<!-- Location Field -->
<div class="form-group col-sm-12">
    {!! Form::label('location', 'Location:') !!}
    {!! Form::text('location', null, ['class' => 'form-control','required']) !!}
</div>

<!-- Property Type Field -->
<div class="form-group col-sm-12">
    {!! Form::label('property_type', 'Property Type:') !!}
    <select name="property_type" class="form-control select2" id="property_type">
        <option value="Commercial">Commercial</option>
        <option value="Residential">Residential</option>
    </select>
</div>

<!-- Units Field -->
<div class="form-group col-sm-12">
    {!! Form::label('units', 'Units:') !!}
    {!! Form::number('units', null, ['class' => 'form-control','required']) !!}
</div>

<!-- Landlord Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('landlord_id', 'Landlord :') !!}
    <select name="landlord_id" class="form-control select2" required id="landlord_id">
        <option value="">Select landlord</option>
        @if(count($landlords))
            @foreach($landlords as $landlord)
                <option value="{{ $landlord->id }}">{{ $landlord->full_name }}</option>
                @endforeach
            @endif
    </select>
</div>

{{--<!-- Created By Field -->--}}
<div class="form-group col-sm-12">
    {!! Form::label('commission', 'Revenue Collection Commission Percentage:') !!}
    {!! Form::number('commission', null, ['class' => 'form-control','required']) !!}
</div>

{{--<!-- Client Id Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('client_id', 'Client Id:') !!}--}}
    {{--{!! Form::number('client_id', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<!-- Status Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('status', 'Status:') !!}--}}
    {{--<label class="checkbox-inline">--}}
        {{--{!! Form::hidden('status', false) !!}--}}
        {{--{!! Form::checkbox('status', '1', null) !!} 1--}}
    {{--</label>--}}
{{--</div>--}}

