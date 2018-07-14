<!-- Property Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('property_id', 'Property:') !!}
    <select name="property_id" class="form-control select2" required id="property_id">
        <option value="">Select Property</option>
        @if(count($properties))
            @foreach($properties as $property)
                <option value="{{ $property->id }}">{{ $property->name }}</option>
                @endforeach
            @endif
    </select>
</div>/

<!-- Expenditure Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('expenditure_id', 'Expenditure:') !!}
    <select name="expenditure_id" class="form-control select2" required id="expenditure_id">
        <option value="">Select Expense</option>
        @if(count($expenses))
            @foreach($expenses as $expense)
                <option value="{{ $expense->id }}">{{ $expense->name }}</option>
            @endforeach
        @endif
    </select>
</div>



{{--<!-- Landlord Id Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('landlord_id', 'Landlord Id:') !!}--}}
    {{--{!! Form::number('landlord_id', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<!-- Created By Field -->--}}


<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control','required']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('remarks', 'Remarks:') !!}
    {!! Form::text('remarks', null, ['class' => 'form-control']) !!}
</div>
<!-- Date Field -->
<div class="form-group col-sm-12">
    {!! Form::label('date', 'Date:') !!}
    {!! Form::date('date', \Carbon\Carbon::today()->toDateString(), ['class' => 'form-control']) !!}
</div>

