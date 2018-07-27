<!-- Office Expenditure Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('office_expenditure_id', 'Office Expense:') !!}
    <select name="office_expenditure_id" id="office_expenditure_id" class="form-control select2" required>
        <option value="">Select Expense</option>
        @if(count($expenses))
            @foreach($expenses as $expense)
                <option value="{{ $expense->id }}">{{ $expense->name }}</option>
                @endforeach
            @endif
    </select>
</div>

{{--<!-- Transaction Type Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('transaction_type', 'Transaction Type:') !!}--}}
    {{--{!! Form::text('transaction_type', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- Ref Number Field -->
<div class="form-group col-sm-12">
    {!! Form::label('ref_number', 'Ref Number:') !!}
    {!! Form::text('ref_number', null, ['class' => 'form-control']) !!}
</div>

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

<!-- Created By Field -->
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('created_by', 'Created By:') !!}--}}
    {{--{!! Form::number('created_by', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

