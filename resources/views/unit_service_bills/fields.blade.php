<!-- Unit Id Field -->
{{--<div class="form-group col-sm-12">--}}
{{--    {!! Form::label('unit_id', 'Unit Id:') !!}--}}
    <input type="hidden" name="unit_id" value="{{ $unit->id }}">
{{--</div>--}}

<!-- Service Bill Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('service_bill_id', 'Service Bill:') !!}
    <select name="service_bill_id" class="form-control select2" required id="service_bill_id">
        <option value="">Select service bill</option>
        @if(count($bills))
{{--            {{ print_r($bills) }}--}}
            @foreach($bills as $bill)
                <option value="{{ $bill->id }}">{{ $bill->name }}</option>
                @endforeach
            @endif
    </select>
</div>

<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Period Field -->
<div class="form-group col-sm-12">
    {!! Form::label('period', 'Interval:') !!}
    <select name="period" class="form-control select2">
        <option value="Monthly">Monthly</option>
        <option value="Once">Once</option>
    </select>
</div>

<!-- Status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('status', 'Status:') !!}
        <select name="status" id="status" class="select2 form-control">
            <option value="1">Active</option>
            <option value="0">In active</option>
        </select>
</div>

