<!-- Landlord Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('landlord_id', 'Landlord Id:') !!}
    <select name="landlord_id" class="select2 form-control" id="landlord_id" required>
        <option value="">select Landlord</option>
        @if(count($landlords))
            @foreach($landlords as $landlord)
            <option value="{{ $landlord->id }}">{{ $landlord->full_name }}</option>
            @endforeach
                @endif
    </select>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('payment_mode', 'Payment Mode:') !!}
    <select name="payment_mode" class="form-control select2" id="payment_mode">
        <option value="CASH">Cash</option>
        <option value="Bank">Bank</option>
        <option value="MPESA">MPESA</option>
    </select>
</div>
<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('ref_number', 'Reference Number:') !!}
    {!! Form::number('ref_number', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control','required']) !!}
</div>



{{--<!-- Remitted By Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('remitted_by', 'Remitted By:') !!}--}}
    {{--{!! Form::number('remitted_by', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- Date Field -->
<div class="form-group col-sm-12">
    {!! Form::label('date', 'Date:') !!}
    {!! Form::date('date', \Carbon\Carbon::today()->toDateString(), ['class' => 'form-control']) !!}
</div>

