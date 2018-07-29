<!-- Landlord Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('landlord_id', 'Landlord:') !!}
    <select name="landlord_id" class="form-control select2" required>
        <option value="">Select Landlord</option>
        @if(count($landlords))
            @foreach($landlords as $landlord)
                <option value="{{ $landlord->id }}">{{ $landlord->full_name }}</option>
            @endforeach
        @endif
    </select>
</div>

<!-- Principle Field -->
<div class="form-group col-sm-12">
    {!! Form::label('principle', 'Principle:') !!}
    {!! Form::number('principle', null, ['class' => 'form-control']) !!}
</div>

<!-- Rate Field -->
<div class="form-group col-sm-12">
    {!! Form::label('rate', 'Rate:') !!}
    <select name="rate" class="select2 form-control">
        <option value="8">8%</option>
    </select>
</div>

<!-- Loan Date Field -->
<div class="form-group col-sm-12">
    {!! Form::label('loan_date', 'Loan Date:') !!}
    {!! Form::date('loan_date', \Carbon\Carbon::today()->toDateString(), ['class' => 'form-control']) !!}
</div>

<!-- Created By Field -->
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('created_by', 'Created By:') !!}--}}
    {{--{!! Form::number('created_by', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- Status Field -->
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('status', 'Status:') !!}--}}
    {{--<label class="checkbox-inline">--}}
        {{--{!! Form::hidden('status', false) !!}--}}
        {{--{!! Form::checkbox('status', '1', null) !!} 1--}}
    {{--</label>--}}
{{--</div>--}}

