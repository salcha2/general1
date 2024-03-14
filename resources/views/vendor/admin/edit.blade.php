@extends('admin.layouts.content')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Edit General</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="{{ route('vendor.admin.edit', $general->ID) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="box-body">
                <div class="form-group">
                    <label for="DEVICE_ID" class="col-sm-2 control-label">Device Type</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="DEVICE_ID" name="DEVICE_ID">
                            @foreach($deviceTypes as $deviceType)
                                <option value="{{ $deviceType->id }}" {{ $general->DEVICE_ID == $deviceType->id ? 'selected' : '' }}>{{ $deviceType->DEVICE_TYPE }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="NAME" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="NAME" name="NAME" value="{{ $general->NAME }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="SERIAL_NUMBER" class="col-sm-2 control-label">Serial Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="SERIAL_NUMBER" name="SERIAL_NUMBER" value="{{ $general->SERIAL_NUMBER }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="RECEPTION_DATE" class="col-sm-2 control-label">Reception Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="RECEPTION_DATE" name="RECEPTION_DATE" value="{{ $general->RECEPTION_DATE }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="ORIGIN" class="col-sm-2 control-label">Origin</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="ORIGIN" name="ORIGIN">
                            @foreach($origins as $origin)
                                <option value="{{ $origin->id }}" {{ $general->ORIGIN == $origin->id ? 'selected' : '' }}>{{ $origin->ENTITY }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="RECIPIENT" class="col-sm-2 control-label">Recipient</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="RECIPIENT" name="RECIPIENT">
                            @foreach($recipients as $recipient)
                                <option value="{{ $recipient->id }}" {{ $general->RECIPIENT == $recipient->id ? 'selected' : '' }}>{{ $recipient->NAME }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="STATE_ID" class="col-sm-2 control-label">State</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="STATE_ID" name="STATE_ID">
                            @foreach($states as $state)
                                <option value="{{ $state->id }}" {{ $general->STATE_ID == $state->id ? 'selected' : '' }}>{{ $state->STATE }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="LOCATION" class="col-sm-2 control-label">Location</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="LOCATION" name="LOCATION" value="{{ $general->LOCATION }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="OWNER" class="col-sm-2 control-label">Owner</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="OWNER" name="OWNER">
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}" {{ $general->OWNER == $owner->id ? 'selected' : '' }}>{{ $owner->COMPANY }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="QUANTITY" class="col-sm-2 control-label">Quantity</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="QUANTITY" name="QUANTITY" value="{{ $general->QUANTITY }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="NOTES" class="col-sm-2 control-label">Notes</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="NOTES" name="NOTES">{{ $general->NOTES }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="INSERTION_DATE" class="col-sm-2 control-label">Insertion Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="INSERTION_DATE" name="INSERTION_DATE" value="{{ $general->INSERTION_DATE }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="INSERTED_BY" class="col-sm-2 control-label">Inserted By</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="INSERTED_BY" name="INSERTED_BY">
                            @foreach($insertedBys as $insertedBy)
                                <option value="{{ $insertedBy->id }}" {{ $general->INSERTED_BY == $insertedBy->id ? 'selected' : '' }}>{{ $insertedBy->NAME }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="MODIFICATION_DATE" class="col-sm-2 control-label">Modification Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="MODIFICATION_DATE" name="MODIFICATION_DATE" value="{{ $general->MODIFICATION_DATE }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="MODIFIED_BY" class="col-sm-2 control-label">Modified By</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="MODIFIED_BY" name="MODIFIED_BY">
                            @foreach($modifiedBys as $modifiedBy)
                                <option value="{{ $modifiedBy->id }}" {{ $general->MODIFIED_BY == $modifiedBy->id ? 'selected' : '' }}>{{ $modifiedBy->NAME }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="VISIBLE" class="col-sm-2 control-label">Visible</label>
                    <div class="col-sm-10">
                        <input type="checkbox" class="form-control" id="VISIBLE" name="VISIBLE" {{ $general->VISIBLE ? 'checked' : '' }}>
                    </div>
                </div>
                <!-- Repeat this pattern for other form fields -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.general.index') }}" class="btn btn-default">Cancel</a>
            </div>
            <!-- /.box-footer -->
        </form>
    </div> 
@endsection
