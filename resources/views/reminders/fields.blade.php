<!-- Days Field -->
<div class="form-group col-sm-12">
    {!! Form::label('days', 'Days:') !!}
    {!! Form::number('days', null, ['class' => 'form-control']) !!}
</div>

{{--<!-- Time Field -->--}}
{{--<div class="form-group col-sm-12">--}}
    {{--{!! Form::label('time', 'Time:') !!}--}}
    {{--{!! Form::text('time', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- Message Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('message', 'Message:') !!}
    {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
</div>

