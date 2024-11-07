<h2>{{ $category }} Subscribers List</h2>
<p>Exported on: {{ now()->format('Y-m-d H:i:s') }}</p> 
<br>

<table>
    <thead>
        <tr>
            <th>Names</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Joined on</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Duration</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subscribers as $entry)
            <tr>
                <td>
                    {{ $entry['subscriber']->names }}
                </td>

                <td>                        
                   {{ $entry['subscriber']->email }}                
                </td>
                <td>
                    {{ $entry['subscriber']->phone }}
                </td>

                <td>
                    {{ $entry['subscriber']->created_at }}
                </td>

                <td>
                    {{ $entry['start_date'] }}
                </td>
                <td>
                    {{ $entry['end_date'] }}
                </td>
                <td>
                    @php
                        $startDate = \Carbon\Carbon::parse($entry['start_date']);
                        $endDate = \Carbon\Carbon::parse($entry['end_date']);
                        $months = $startDate->diffInMonths($endDate);
                    @endphp
                    {{ $months }} months
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
