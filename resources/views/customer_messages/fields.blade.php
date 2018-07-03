<!-- Phone Number Field -->

<div class="form-group col-md-12">
    <label>Send to</label>
    <select name="send_to" class="form-control select2">
        <option value="individual">Individual</option>
        {{--<option value="group">Client Group</option>--}}
    </select>
</div>

<div class="form-group col-md-12">
    <label>Recipient</label>
    <select name="recipient" class="form-control select2" required>
        <option value="">Select recipient</option>
        @if(count($recipients))
            @foreach($recipients as $recipient)
                <option value="{{$recipient->id  }}">{{$recipient->full_name}}</option>
            @endforeach
        @endif
    </select>

</div>

<!-- Message Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('message', 'Message:') !!}
    {!! Form::textarea('message', null, ['class' => 'form-control','rows'=>'3','required']) !!}
</div>

{{--<!-- Execution Time Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('execution_time', 'Execution Time:') !!}--}}
    {{--{!! Form::date('execution_time', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

