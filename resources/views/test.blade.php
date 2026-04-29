@extends('layouts.layout')
@section('content')
<div style="overflow-x:auto; padding: 20px;">
    <h2>pc0ec_users ({{ $users->count() }} записей)</h2>
    <table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse; font-size:13px;">
        <thead>
            <tr>
                @foreach(array_keys((array) $users->first()) as $col)
                    <th>{{ $col }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($users as $row)
                <tr>
                    @foreach((array) $row as $val)
                        <td>{{ $val }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
