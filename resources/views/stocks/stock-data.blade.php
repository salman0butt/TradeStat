@extends('layouts.app')

@section('title', 'TradeStat Data')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
@endpush

@section('content')
    <h1>Historical Quotes for {{ $symbol }}</h1>
    <h2>Date Range: {{ $startDate }} to {{ $endDate }}</h2>

    <!-- Loader -->
    <div class="loader">
        <p>Loading...</p>
    </div>

    <table id="stock-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Open</th>
                <th>High</th>
                <th>Low</th>
                <th>Close</th>
                <th>Volume</th>
            </tr>
        </thead>
        <tbody>
            @if ($historicalData && count($historicalData) > 0)
                @foreach ($historicalData as $data)
                    <tr>
                        <td>{{ $data->date ? Carbon\Carbon::parse($data->date)->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $data->open ?? 'N/A' }}</td>
                        <td>{{ $data->high ?? 'N/A' }}</td>
                        <td>{{ $data->low ?? 'N/A' }}</td>
                        <td>{{ $data->close ?? 'N/A' }}</td>
                        <td>{{ $data->volume ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <!-- Include a chart library and display the chart -->
    <div id="stock-chart-container">
        <canvas id="stock-chart" width="400" height="200"></canvas>
    </div>

@endsection


<!-- Push additional JS file to the 'scripts' stack -->
@push('scripts')
    <!-- Add Chart.js JavaScript -->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Show the loader
            $('.loader').show();

            // Initialize DataTables
            var table = $('#stock-table').DataTable();

            // Show the table once DataTables is initialized
            $('.loader').hide();
            $('#stock-table').show();

            function convertUnixToDate(data) {
                let date = new Date(data);
                // Extract the different components of the date
                let year = date.getFullYear();
                let month = date.getMonth() + 1; // Months are zero-based, so add 1
                let day = date.getDate();

                // Format the date string as "YYYY-MM-DD"
                let formattedDate = year + '-' + month.toString().padStart(2, '0') + '-' + day.toString().padStart(
                    2, '0');
                return formattedDate;
            }

            // Code to create the chart using Chart.js
            const historicalData = JSON.parse('{!! addslashes(json_encode($historicalData)) !!}');
            let dates = historicalData.map(function(data) {
                return convertUnixToDate(data.date * 1000);
            });
            let openPrices = historicalData.map(function(data) {
                return data.open;
            });

            let closedPrices = historicalData.map(function(data) {
                return data.close;
            });

            let ctx = document.getElementById('stock-chart').getContext('2d');
            let chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                            label: 'Open Price',
                            data: openPrices,
                            borderColor: 'blue',
                            backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        },
                        {
                            label: 'Closed Price',
                            data: closedPrices,
                            borderColor: 'red',
                            backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        }
                    ]
                }
            });
        });
    </script>
@endpush

