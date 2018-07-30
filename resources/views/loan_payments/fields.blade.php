<!-- Loan Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('loan_id', 'Landlord:') !!}
    <select name="loan_id" class="form-control select2" required>
        <option value="">Select Landlord</option>
        @if(count($loans))
            @foreach($loans as $loan)
                <option value="{{ $loan->id }}">{{ $loan->masterfile->full_name }}</option>
                @endforeach
            @endif
    </select>
</div>

<!-- Landlord Id Field -->
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('landlord_id', 'Landlord Id:') !!}--}}
    {{--{!! Form::number('landlord_id', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- Reference Field -->
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('reference', 'Reference:') !!}--}}
    {{--{!! Form::text('reference', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- Transaction Type Field -->
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('transaction_type', 'Transaction Type:') !!}--}}
    {{--{!! Form::text('transaction_type', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control','required']) !!}
</div>

<!-- Date Field -->
<div class="form-group col-sm-12">
    {!! Form::label('date', 'Date:') !!}
    {!! Form::date('date', \Carbon\Carbon::today()->toDateString(), ['class' => 'form-control']) !!}
</div>

