<div class="form-group col-md-12">
    <label>Select Payment</label>
    <select class="select2 form-control" name="payment_id" required>
        <option value="">Select Payment</option>
        @if(count($payments))
            @foreach($payments as $payment)
                <option value="{{ $payment->id }}">{{ $payment->ref_number }} - {{ $payment->house_number }} - {{ $payment->masterfile->full_name }} - {{ $payment->amount }} Ksh</option>
                @endforeach
            @endif
    </select>
</div>

<div class="form-group col-md-12">
    <label>Transfer to</label>
    <select class="select2 form-control" name="lease_id" required>
        <option value="">Select service account</option>
        @if(count($accounts))
            @foreach($accounts as $account)
                <option value="{{ $account->id }}">{{ $account->unit->unit_number }} - {{ $account->masterfile->full_name }}</option>
            @endforeach
        @endif
    </select>
</div>