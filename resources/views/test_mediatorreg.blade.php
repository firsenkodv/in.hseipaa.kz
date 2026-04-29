@extends('layouts.layout')
@section('content')
<div style="overflow-x:auto; padding: 20px;">
    <h2>pc0ec_mediatorreg_reg ({{ $rows->count() }} записей)</h2>
    <table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse; font-size:12px; white-space:nowrap;">
        <thead style="background:#f0f0f0;">
            <tr>
                @foreach(array_keys((array) $rows->first()) as $col)
                    <th>{{ $col }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
                <tr>
                    @foreach((array) $row as $val)
                        <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis;">{{ $val }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
