<!-- Landlord Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('landlord_id', 'Landlord :') !!}
    <select name="landlord_id" class="select2 form-control" required id="landlord_id">
        <option value="">Select landlord</option>
        @if(count($landlords))
            @foreach($landlords as $landlord)
                <option value="{{ $landlord->id }}">{{ $landlord->full_name }}</option>
                @endforeach
            @endif
    </select>
</div>
<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', ' Bank Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','required']) !!}
</div>



<!-- Account Number Field -->
<div class="form-group col-sm-12">
    {!! Form::label('account_number', 'Account Number:') !!}
    {!! Form::text('account_number', null, ['class' => 'form-control','required ']) !!}
</div>

