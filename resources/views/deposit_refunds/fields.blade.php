<!-- Lease Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('lease_id', 'House number:') !!}
    <select name="lease_id" class="form-control select2" required>
        <option value="">Select Tenant</option>
        @if(count($leases))
            @foreach($leases as $lease)
                <option value="{{ $lease->id }}">{{ $lease->unit->unit_number }} - {{ $lease->masterfile->full_name }}</option>
                @endforeach
            @endif
    </select>
</div>

<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control','required']) !!}
</div>

{{--<!-- Refunded By Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('refunded_by', 'Refunded By:') !!}--}}
    {{--{!! Form::number('refunded_by', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- Refund Date Field -->
<div class="form-group col-sm-12">
    {!! Form::label('refund_date', 'Refund Date:') !!}
    {!! Form::date('refund_date', \Carbon\Carbon::today()->toDateString(), ['class' => 'form-control','required']) !!}
</div>

