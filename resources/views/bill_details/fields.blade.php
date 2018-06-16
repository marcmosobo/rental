<!-- Bill Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('bill_id', 'Bill Id:') !!}
    {!! Form::number('bill_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Service Bill Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('service_bill_id', 'Service Bill Id:') !!}
    {!! Form::number('service_bill_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('status', false) !!}
        {!! Form::checkbox('status', '1', null) !!} 1
    </label>
</div>

