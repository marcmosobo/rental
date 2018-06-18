<!-- Event Field -->
<div class="form-group col-sm-12">
    {!! Form::label('event', 'Event:') !!}
    {!! Form::text('event', null, ['class' => 'form-control']) !!}
</div>

<!-- Code Field -->
<div class="form-group col-sm-12">
    {!! Form::label('code', 'Code:') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

<!-- Message Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('message', 'Message:') !!}
    {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
</div>

{{--<!-- Status Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('status', 'Status:') !!}--}}
    {{--<label class="checkbox-inline">--}}
        {{--{!! Form::hidden('status', false) !!}--}}
        {{--{!! Form::checkbox('status', '1', null) !!} 1--}}
    {{--</label>--}}
{{--</div>--}}

