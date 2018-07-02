<!-- Unit Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('unit_id', 'Unit Id:') !!}
    {!! Form::number('unit_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Property Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('property_id', 'Property Id:') !!}
    {!! Form::number('property_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Tenant Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('tenant_id', 'Tenant Id:') !!}
    {!! Form::number('tenant_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-12">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::date('start_date', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('status', false) !!}
        {!! Form::checkbox('status', '1', null) !!} 1
    </label>
</div>

<!-- Created By Field -->
<div class="form-group col-sm-12">
    {!! Form::label('created_by', 'Created By:') !!}
    {!! Form::number('created_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Client Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('client_id', 'Client Id:') !!}
    {!! Form::number('client_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Reversed Field -->
<div class="form-group col-sm-12">
    {!! Form::label('is_reversed', 'Is Reversed:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_reversed', false) !!}
        {!! Form::checkbox('is_reversed', '1', null) !!} 1
    </label>
</div>

<!-- Reversed By Field -->
<div class="form-group col-sm-12">
    {!! Form::label('reversed_by', 'Reversed By:') !!}
    {!! Form::number('reversed_by', null, ['class' => 'form-control']) !!}
</div>

