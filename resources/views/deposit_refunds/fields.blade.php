<!-- Lease Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('lease_id', 'Lease Id:') !!}
    {!! Form::number('lease_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Refunded By Field -->
<div class="form-group col-sm-12">
    {!! Form::label('refunded_by', 'Refunded By:') !!}
    {!! Form::number('refunded_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Refund Date Field -->
<div class="form-group col-sm-12">
    {!! Form::label('refund_date', 'Refund Date:') !!}
    {!! Form::date('refund_date', null, ['class' => 'form-control']) !!}
</div>

