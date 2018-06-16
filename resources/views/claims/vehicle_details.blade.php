        <div class="form-group col-md-4">
            <label class="control-label">Vehicle</label>
            <select name="vehicle"  class="form-control select2" value="{{old('vehicle')}}">
                <option value="">Select vehicle</option>
                @if(count($activePolicies))
                    @foreach($activePolicies as $policy)
                        <option value="{{ $policy->policy_id }}">{{ $policy->registration_number }}</option>
                        @endforeach
                    @endif
            </select>
        </div>
        <div class="form-group col-md-4">
            <label class="control-label">Route number</label>
            <input name="route_number" type="text" value="{{old('route_number')}}"  class="form-control" placeholder="Route number" />
        </div>

        <div class="form-group col-md-4">
            <label class="control-label">Travelling From</label>
            <input type="text" required name="travelling_from" value="{{old('travelling_from')}}" class="form-control" placeholder="Travelling from" />
        </div>
        <div class="form-group  col-md-4">
            <label class="control-label">Travelling To</label>
            <input type="text" required name="travelling_to" value="{{old('travelling_to')}}"  class="form-control" placeholder="Travelling to" />
        </div>

        <div class="form-group col-md-4">
            <label class="control-label">Driver's Name</label>
            <input type="text" required name="driver_name" value="{{old('driver_name')}}"  class="form-control" placeholder="Driver's name" />
        </div>
        <div class="form-group  col-md-4">
            <label class="control-label">Driver's Number</label>
            <input type="text" name="driver_number" value="{{old('driver_number')}}"  class="form-control" placeholder="Driver's number" />
        </div>
        <div class="form-group col-md-4">
            <label class="control-label">Conductor's Name</label>
            <input type="text" name="conductor_name" value="{{old('conductor_name')}}" class="form-control" placeholder="Conductor's name" />
        </div>
        <div class="form-group col-md-4">
            <label class="control-label">Conductor's Number</label>
            <input type="text" name="conductor_number" value="{{old('conductor_number')}}" class="form-control" placeholder="Conductor's number" />
        </div>

        <div class="form-group col-md-4">
            <label class="control-label">Driver's DOB</label>
            <input type="date" name="driver_dob" value="{{old('driver_dob')}}"  class="form-control" placeholder="Driver's DOB" />
        </div>
        <div class="form-group col-md-4">
            <label class="control-label">Date Entered Company service</label>
            <input type="date" name="date_entered_company_service" value="{{old('date_entered_company_service')}}" class="form-control" placeholder="Date Entered Company service" />
        </div>

        <div class="form-group col-md-4">
            <label class="control-label">PSV Badge number</label>
            <input type="text" name="psv_badge_number" value="{{old('psv_badge_number')}}" class="form-control" placeholder="PSV Badge number" />
        </div>
        <div class="form-group col-md-4">
            <label class="control-label">Driver's Licence NO</label>
            <input type="text" name="driver_licence_number"  class="form-control" placeholder="Driver's licence number" />
        </div>

        <div class="form-group col-md-4">
            <label class="control-label">Licence Type</label>
            <input type="radio" name="licence_type" value="Full"> Full
            <input type="radio" name="licence_type" value="Provisional"> Provisional
        </div>
        <div class="form-group col-md-4">
            <label class="control-label">Driver's Experience</label>
            <input type="radio" name="experience" value="Intermediate"> Intermediate
            <input type="radio" name="experience" value="Experienced"> Experienced
        </div>


        <div class="form-group col-md-4">
            <label class="control-label">Use of Vehicle</label>
            <input type="radio" name="use_of_vehicle" value="On Bus Route"> On Bus Route
            <input type="radio" name="use_of_vehicle" value="Private Hire"> Private Hire
        </div>

        <div class="form-group col-md-4">
            <label class="control-label">Number Of Passengers</label>
            <input type="number" name="number_of_passengers" class="form-control">
        </div>

