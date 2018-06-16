

<div class="col-md-12 no-padding-left">
    <div class="col-md-6 no-padding-left">
        <div class="form-group">
            <label class="control-label">Accident Date & Time</label>
            <input type="datetime-local" name="occurrence_date_time"  class="form-control" placeholder="Accident date and time" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Location of Accident</label>
            <input type="text" required name="location_of_accident"  class="form-control" placeholder="Location of accident" />
        </div>
    </div>
</div>


<div class="col-md-12 no-padding-left">
    <div class="col-md-6 no-padding-left">
        <div class="form-group">
            <label class="control-label">Speed Before Accident</label>
            <input type="text"  name="speed_before_accident"  class="form-control" placeholder="Speed Before Accident" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Speed At Accident</label>
            <input type="text"  name="speed_at_accident"  class="form-control" placeholder="Speed At Accident" />
        </div>
    </div>
</div>

<div class="col-md-12 no-padding-left">
    <div class="col-md-6 no-padding-left">
        <div class="form-group">
            {!! Form::label('other_vehicle_speed', 'Other Vehicle Speed:') !!}
            {!! Form::text('other_vehicle_speed', null, ['class' => 'form-control','placeholder'=>'Other Vehicle Speed']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('width_of_road', 'Width Of Road:') !!}
            {!! Form::text('width_of_road', null, ['class' => 'form-control','placeholder'=>'Width Of Road']) !!}
        </div>
    </div>
</div>

{{--<div class="col-md-12 no-padding-left">--}}
    <div class="form-group col-md-6 no-padding-left">
        {!! Form::label('radio_control_ob_number', 'Radio Control Ob Number:') !!}
        {!! Form::text('radio_control_ob_number', null, ['class' => 'form-control','placeholder'=>'Radio Control OB No']) !!}
    </div>
<div class="form-group col-md-6 no-padding-left">
    {!! Form::label('disciplinary_charge_sheet_number', 'Disciplinary Charge Sheet Number:') !!}
    {!! Form::text('disciplinary_charge_sheet_number', null, ['class' => 'form-control','placeholder'=>'Disciplinary Charge Sheet Number']) !!}
</div>

    <!-- Date Reported To Owner Field -->
    <div class="form-group col-md-6 no-padding-left">
        {!! Form::label('date_reported_to_owner', 'Date Reported To Owner:') !!}
        {!! Form::date('date_reported_to_owner', null, ['class' => 'form-control']) !!}
    </div>
{{--</div>--}}

<div class="form-group col-md-6 no-padding-left">
    {!! Form::label('date_reported_to_insurer', 'Date Reported To Insurer:') !!}
    {!! Form::date('date_reported_to_insurer', null, ['class' => 'form-control']) !!}
</div>



