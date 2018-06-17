<!-- Payment Mode Field -->
<div class="form-group col-sm-12">
    {!! Form::label('payment_mode', 'Payment Mode:') !!}
    <select name="payment_mode" class="form-control select2">
        <option value="CASH">Cash</option>
        <option value="MPESA">Mpesa</option>
        <option value="Bank slip">Bank Slip</option>
    </select>
</div>

{{--<!-- House Number Field -->--}}
<div class="form-group col-sm-12">
    {!! Form::label('ref_number', 'Reference Number:') !!}
    {!! Form::text('ref_number', null, ['class' => 'form-control','required']) !!}
</div>

<div class="form-group col-md-12">
    <label>Amount</label>
    <input type="number" class="form-control" required name="amount">
</div>

<!-- Tenant Id Field -->
{{--<div class="form-group col-sm-12">--}}
{{--    {!! Form::label('tenant_id', 'Tenant Id:') !!}--}}
    @if(isset($tenant))
        <input type="hidden" name="tenant_id" value="{{ $tenant->id }}">
        @endif
{{--</div>--}}


{{--<!-- Firstname Field -->--}}
<div class="form-group col-sm-12">
    {!! Form::label('received_on', 'Received On:') !!}
    {!! Form::date('received_on', \Carbon\Carbon::today()->toDateString(), ['class' => 'form-control']) !!}
</div>

{{--<!-- Middlename Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('middleName', 'Middlename:') !!}--}}
    {{--{!! Form::text('middleName', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<!-- Lastname Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('LastName', 'Lastname:') !!}--}}
    {{--{!! Form::text('LastName', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<!-- Received On Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('received_on', 'Received On:') !!}--}}
    {{--{!! Form::date('received_on', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<!-- Client Id Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('client_id', 'Client Id:') !!}--}}
    {{--{!! Form::number('client_id', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<!-- Created By Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('created_by', 'Created By:') !!}--}}
    {{--{!! Form::number('created_by', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<!-- Status Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('status', 'Status:') !!}--}}
    {{--<label class="checkbox-inline">--}}
        {{--{!! Form::hidden('status', false) !!}--}}
        {{--{!! Form::checkbox('status', '1', null) !!} 1--}}
    {{--</label>--}}
{{--</div>--}}

