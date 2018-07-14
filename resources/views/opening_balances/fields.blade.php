<!-- Landlord Id Field -->
<!-- Landlord Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('landlord_id', 'Landlord Id:') !!}
    <select name="landlord_id" class="select2 form-control" required>
        <option value="">select Landlord</option>
        @if(count($landlords))
            @foreach($landlords as $landlord)
                <option value="{{ $landlord->id }}">{{ $landlord->full_name }}</option>
            @endforeach
        @endif
    </select>
</div>

<!-- Opening Balance Field -->
<div class="form-group col-sm-12">
    {!! Form::label('opening_balance', 'Opening Balance:') !!}
    {!! Form::number('opening_balance', null, ['class' => 'form-control']) !!}
</div>

