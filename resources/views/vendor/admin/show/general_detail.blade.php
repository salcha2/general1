@extends('admin::layouts.content')

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Detail</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{ $detail->ID }}</td>
                    </tr>
                    <tr>
                        <th>Device Type</th>
                        <td>{{ $detail->device_type }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $detail->NAME }}</td>
                    </tr>
                    <tr>
                        <th>Serial Number</th>
                        <td>{{ $detail->SERIAL_NUMBER }}</td>
                    </tr>
                    <tr>
                        <th>Reception Date</th>
                        <td>{{ $detail->RECEPTION_DATE }}</td>
                    </tr>
                    <tr>
                        <th>Origin</th>
                        <td>{{ $detail->entity }}</td>
                    </tr>
                    <tr>
                        <th>Recipient</th>
                        <td>{{ $detail->reciver }}</td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td>{{ $detail->state }}</td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td>{{ $detail->LOCATION }}</td>
                    </tr>
                    <tr>
                        <th>Owner</th>
                        <td>{{ $detail->company }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $detail->QUANTITY }}</td>
                    </tr>
                    <tr>
                        <th>Notes</th>
                        <td>{{ $detail->NOTES }}</td>
                    </tr>
                    <tr>
                        <th>Insertion Date</th>
                        <td>{{ $detail->INSERTION_DATE }}</td>
                    </tr>
                    <tr>
                        <th>Inserted By</th>
                        <td>{{ $detail->inserted_B }}</td>
                    </tr>
                    <tr>
                        <th>Modification Date</th>
                        <td>{{ $detail->MODIFICATION_DATE }}</td>
                    </tr>
                    <tr>
                        <th>Modified By</th>
                        <td>{{ $detail->modified_B }}</td>
                    </tr>
                    <tr>
                        <th>Visible</th>
                        <td>{{ $detail->VISIBLE }}</td>
                    </tr>
                    <!-- Agrega más campos según tus necesidades -->
                </tbody>
            </table>
        </div>
    </div>
@endsection
