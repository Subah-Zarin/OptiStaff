@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Public Holidays in Bangladesh - 2025</h1>

    <div class="bg-white rounded-xl shadow p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Holiday</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @php
                    $holidays = [
                        ['name' => 'New Year\'s Day', 'date' => '01 Jan, 2025'],
                        ['name' => 'Language Martyrs\' Day', 'date' => '21 Feb, 2025'],
                        ['name' => 'Independence Day', 'date' => '26 Mar, 2025'],
                        ['name' => 'Bengali New Year', 'date' => '14 Apr, 2025'],
                        ['name' => 'Eid al-Fitr', 'date' => '30 Apr, 2025'],
                        ['name' => 'Labour Day', 'date' => '01 May, 2025'],
                        ['name' => 'Buddha Purnima', 'date' => '11 May, 2025'],
                        ['name' => 'Eid al-Adha', 'date' => '06 Jun, 2025'],
                        ['name' => 'Ashura', 'date' => '06 Jul, 2025'],
                        ['name' => 'Janmashtami', 'date' => '16 Aug, 2025'],
                        ['name' => 'Eid-e-Milad-un Nabi', 'date' => '05 Sep, 2025'],
                        ['name' => 'Durga Puja', 'date' => '01 Oct, 2025'],
                        ['name' => 'Victory Day', 'date' => '16 Dec, 2025'],
                        ['name' => 'Christmas Day', 'date' => '25 Dec, 2025'],
                    ];
                @endphp

                @foreach($holidays as $holiday)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-700">{{ $holiday['name'] }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $holiday['date'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
