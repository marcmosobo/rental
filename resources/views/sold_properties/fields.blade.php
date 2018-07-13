<!-- Listing Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('listing_id', 'Sale Listing:') !!}
    <select name="listing_id" class="select2 form-control" required>
        <option value="">Select listing</option>
        @if(count($listings))
            @foreach($listings as $listing)
                <option value="{{ $listing->id }}">{{ $listing->type->name }} - {{$listing->masterfile->full_name}} - {{$listing->price}}</option>
                @endforeach
            @endif
    </select>
</div>

<!-- Buyer Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('buyer_id', 'Buyer:') !!}
    <select name="buyer_id" class="form-control select2" required id="buyer_id">
        <option value="">Select buyer</option>
        @if(count($buyers))
            @foreach($buyers as $buyer)
                <option value="{{ $buyer->id }}">{{ $buyer->full_name }}</option>
            @endforeach
        @endif
    </select>
</div>

<!-- Amount Bought Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount_bought', 'Amount Sold:') !!}
    {!! Form::number('amount_bought', null, ['class' => 'form-control','required']) !!}
</div>

{{--<!-- Commission Percentage Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('commission_percentage', 'Commission Percentage:') !!}--}}
    {{--{!! Form::number('commission_percentage', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<!-- Commission Charged Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('commission_charged', 'Commission Charged:') !!}--}}
    {{--{!! Form::number('commission_charged', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--<!-- Less Commission Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('less_commission', 'Less Commission:') !!}--}}
    {{--{!! Form::number('less_commission', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

