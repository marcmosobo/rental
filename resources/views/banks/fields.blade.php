<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','required']) !!}
</div>

<!-- Branch Field -->
<div class="form-group col-sm-12">
    {!! Form::label('branch', 'Branch:') !!}
    {!! Form::text('branch', null, ['class' => 'form-control','required']) !!}
</div>

<!-- Account Number Field -->
<div class="form-group col-sm-12">
    {!! Form::label('account_number', 'Account Number:') !!}
    {!! Form::text('account_number', null, ['class' => 'form-control','required']) !!}
</div>

