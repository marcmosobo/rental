<!-- Seller Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('seller_id', 'Seller:') !!}
    <select name="seller_id" class="form-control select2" required id="seller_id">
        <option value="">Select Seller</option>
        @if(count($sellers))
            @foreach($sellers as $seller)
                <option value="{{ $seller->id }}">{{ $seller->full_name }}</option>
                @endforeach
            @endif
    </select>
</div>

<!-- Property Type Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('property_type_id', 'Property Type:') !!}
    <select name="property_type_id" class="form-control select2" required id="property_type_id">
        <option value="">Select property type</option>
        @if(count($types))
            @foreach($types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        @endif
    </select>
</div>

<!-- Location Field -->
<div class="form-group col-sm-12">
    {!! Form::label('location', 'Location:') !!}
    {!! Form::text('location', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control','required','rows'=>3]) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-12">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price', null, ['class' => 'form-control','required']) !!}
</div>

<!-- Sale Commission Field -->
<div class="form-group col-sm-12">
    {!! Form::label('sale_commission', 'Sale Commission:') !!}
    {!! Form::number('sale_commission', null, ['class' => 'form-control','required']) !!}
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

