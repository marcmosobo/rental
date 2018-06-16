<!-- Vehicle Driver Name Field -->
<div class="form-group col-sm-4">
    {!! Form::label('vehicle_driver_name', 'Vehicle Driver Name:') !!}
    {!! Form::text('vehicle_driver_name', null, ['class' => 'form-control','placeholder'=>'Vehicle Driver\'s Name']) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-4">
    {!! Form::label('address', ' Driver\'s Address:') !!}
    {!! Form::text('address', null, ['class' => 'form-control','placeholder'=>'Driver\'s Address']) !!}
</div>

<!-- Reg Number Field -->
<div class="form-group col-sm-4">
    {!! Form::label('reg_number', 'Reg Number:') !!}
    {!! Form::text('reg_number', null, ['class' => 'form-control','placeholder'=>'T.P Registration Number']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', ' Vehicle Type:') !!}
    {!! Form::text('type', null, ['class' => 'form-control','placeholder'=>'Vehicle type']) !!}
</div>
<!-- Make Field -->
<div class="form-group col-sm-6">
    {!! Form::label('make', 'Make:') !!}
    {!! Form::text('make', null, ['class' => 'form-control','placeholder'=>'Make']) !!}
</div>



<!-- Damage Field -->
{{--<div class="form-group col-sm-12 col-lg-12">--}}
    {{--{!! Form::label('damage', 'Damage:') !!}--}}
    {{--{!! Form::textarea('damage', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- Insurer Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insurer', 'Insurer Name:') !!}
    {!! Form::text('insurer', null, ['class' => 'form-control','placeholder'=>'Insurer Name']) !!}
</div>

<!-- Certificate Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('certificate_number', 'Certificate Number:') !!}
    {!! Form::text('certificate_number', null, ['class' => 'form-control','placeholder'=>'Certificate number']) !!}
</div>

<!-- Involved Lights Field -->
<div class="form-group no-padding-left col-sm-12">
    {!! Form::label('involved_lights', 'Involved Vehicle Lights:') !!}
</div>
<div class="col-md-4">
    <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_lights" value="Side Lights Only"><label>Side Lights Only</label></div>
</div>
<div class="col-md-4">
    <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_lights" value="Head Lights on"><label>Head Lights on</label></div>
</div>
<div class="col-md-4">
    <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_lights" value="No Lights"><label>No Lights</label></div>
</div>
<div class="col-md-12 no-padding-left"><label>Involved Vehicle Was</label></div>
<div class="form-group col-md-2">
    <div class="col-md-12 no-padding-left">
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_vehicle_was" value="Stationary"><label>Stationary</label></div>
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_vehicle_was" value="Slowing"><label>Slowing</label></div>
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_vehicle_was" value="Reversing"><label>Reversing</label></div>
    </div>
</div>

<div class="form-group col-md-2">
    <div class="col-md-12 no-padding-left">
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_vehicle_was" value="Moving Off"><label>Moving Off</label></div>
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_vehicle_was" value="Turning Left"><label>Turning Left</label></div>
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_vehicle_was" value="Turning Right"><label>Turning Right</label></div>
    </div>
</div>

<div class="form-group col-md-2">
    <div class="col-md-12 no-padding-left">
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_vehicle_was" value="hanging Lane"><label>Changing Lane</label></div>
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_vehicle_was" value="Overtaking"><label>Overtaking</label></div>
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_vehicle_was" value="Other"><label>Other</label></div>
    </div>
</div>

<div class="form-group col-md-2">
    <div class="col-md-12 no-padding-left">
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_vehicle_was" value="Taking evasive action"><label>Evading</label></div>
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_vehicle_was" value="Out of control"><label>Out of control</label></div>
    </div>
</div>

<div class="form-group col-md-3">
    <div class="col-md-12 no-padding-left">
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_vehicle_was" value="Proceeding Normally"><label>Proceeding Normally</label></div>
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="involved_vehicle_was" value="Making U-turn"><label>Making a U Turn</label></div>
    </div>
</div>
<div class="col-md-12 no-padding-left"><label>Damage</label></div>
<div class="form-group col-md-2">
    <div class="col-md-12 no-padding-left">
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="damage" value="Total loss"><label>Total loss</label></div>
    </div>
</div>

<div class="form-group col-md-2">
    <div class="col-md-12 no-padding-left">
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="damage" value="Badly Damaged"><label>Badly Damaged</label></div>
    </div>
</div>

<div class="form-group col-md-2">
    <div class="col-md-12 no-padding-left">
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="damage" value="Slight"><label>Slight</label></div>
    </div>
</div>

<div class="form-group col-md-2">
    <div class="col-md-12 no-padding-left">
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="damage" value="No Damage"><label>No Damage</label></div>
    </div>
</div>
<div class="form-group col-md-3">
    <div class="col-md-12 no-padding-left">
        <div class="col-md-12 no-padding" style="margin-bottom: 8px;"><input type="radio" class="i-check-line" name="damage" value="Not Badly Damaged"><label>Not Badly Damaged</label></div>
    </div>
</div>
