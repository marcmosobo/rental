<!-- Bill Id Field -->
<div class="form-group col-sm-12">
    <label>select house number</label>
    <select name="lease_id" class="select2 form-control" required>
        <option value="">Select house number</option>
        @if(count($leases))
            @foreach($leases as $lease)
                <option value="{{ $lease->id }}">{{ $lease->unit->unit_number }} - {{ $lease->masterfile->full_name }}</option>
            @endforeach
            @endif
    </select>
</div>

<!-- Service Bill Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('service_bill_id', 'Service Bill Id:') !!}
    <select name="service_bill_id" class="form-control select2" required>
        <option value="">Select bill</option>
        @if(count($bills))
            @foreach($bills as $bill)
                <option value="{{ $bill->id }}">{{$bill->name}}</option>
                @endforeach
            @endif
    </select>
</div>

<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control','required']) !!}
</div><!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('date', 'Bill Date:') !!}
    {!! Form::date('date', \Carbon\Carbon::today()->toDateString(), ['class' => 'form-control','required']) !!}
</div>


