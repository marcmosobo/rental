<!-- Payment Mode Field -->
<div class="form-group col-sm-12">
    <label> Select House Number</label>
    <select name="lease_id" class="form-control select2" id="tenant-select" required>
        <option value="">Select house number/tenant</option>
        @if(count($tenants))
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}">{{ $tenant->unit->unit_number.' - '.  $tenant->masterfile->full_name }}</option>
            @endforeach
        @endif

    </select>
</div>


<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('payment-mode', 'Payment Mode:') !!}
    <select class="form-control select2" id="payment-mode" name="payment_mode">
        <option value="CASH">Cash</option>
        <option value="Bank">Bank</option>
    </select>
</div>
<div class="form-group col-sm-12" id="bank-div" style="display: none;">
    {!! Form::label('bank_id', 'Bank:') !!}
    <select name="bank_id"  id="bank-id" class="form-control select2">
        <option value="">Select Bank</option>
        @if(count($banks))
            @foreach($banks as $bank)
                <option value="{{ $bank->id }}">{{ $bank->name.' - '.$bank->account_number  }}</option>
            @endforeach
        @endif
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