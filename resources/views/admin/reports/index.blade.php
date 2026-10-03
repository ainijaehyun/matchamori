@extends('layouts.app')

@section('title', 'Sales Report')

@section('content')
<div class="report-page">
    <div class="report-title">
        Sales Report
    </div>

    <div class="report-filter">
        <form action="{{ route('admin.reports.index') }}" method="GET">
            <div class="filter-group">
                <label for="month">Month</label>
                <select name="month" id="month">
                    @foreach ([
                        1 => 'Jan',
                        2 => 'Feb',
                        3 => 'Mar',
                        4 => 'Apr',
                        5 => 'May',
                        6 => 'Jun',
                        7 => 'Jul',
                        8 => 'Aug',
                        9 => 'Sept',
                        10 => 'Oct',
                        11 => 'Nov',
                        12 => 'Dec'
                    ] as $number => $name )
                        <option value="{{ $number }}" {{ (int) $month === $number ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="year">Year</label>
                <select name="year" id="year">
                    @for ($i = now()->year; $i >= now()->year - 5; $i--)
                        <option value="{{ $i }}" {{ (int) $year === $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="filter-button">
                Filter
            </button>
        </form>
    </div>

    <div class="summary-container">
        <div class="summary-card">
            <div class="summary-title">
                Total Sales
            </div>
            <div class="summary-value">
                Rp. {{ number_format($totalSales, 0, ',', '.') }}
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-title">
                Total Order
            </div>
            <div class="summary-">
                {{ $totalOrders }}
            </div>
        </div>
    </div>

    <div class="charts-container">
        <div class="chart-card">
            <div class="chart-title">
                Sales (Monthly)
            </div>
            <div class="chart-wrapper">
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-title">
                Sales by Category
            </div>

            @if ($salesByCategory->count() > 0)
                <div class="chart-container">
                    <canvas id="categorySalesChart"></canvas>
                </div>
            @else
                <div class="no-category-data">
                    Data sales not found!
                </div>
            @endif
        </div>
    </div>

    <div class="recap-card">
        <div class="recap-title">
            Recap per Month
        </div>
        <div class="recap-table-wrapper">
            <table class="recap-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Total Order</th>
                        <th>Total Sales</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($recapPerMonth as $recap)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ date('F', mktime(0, 0, 0, $recap->month, 1)) }}
                            </td>
                            <td>
                                {{ $recap->year }}
                            </td>
                            <td>
                                {{ $recap->total_order }}
                            </td>
                            <td>
                                Rp. {{ number_format($recap->total_sales, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-recap">
                                Data recap not found!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const monthlyLabels = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sept',
            'Oct',
            'Nov',
            'Dec'
        ];

        const monthlyData = @json(
            collect(range(1, 12))->map(function ($monthNumber) use ($monthlySales) {
                return (float) ($monthlySales[$monthNumber] ?? 0);
            })->values()
        );

        const monthlyCanvas =
            document.getElementById('monthlySalesChart');
        if (monthlyCanvas) {
            new Chart(monthlyCanvas, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Sales',
                        data: monthlyData,
                        borderColor: '#4F7942',
                        backgroundColor: 'rgba(79, 121, 66, 0.15)',
                        borderWidth: 3,
                        tension: 0.35,
                        fill: true,
                        pointBackgroundColor: '#AF7942',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp. ' + Number(value).toLocaleString('id-ID');
                                }
                            }
                        }
                    },

                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }


        const categoryLabels = @json(
            $salesByCategory->pluck('category_name')->values()
        );

        const categoryData = @json(
            $salesByCategory->pluck('total')->map(fn ($value) => (float) $value)->values()
        );

        const categoryCanvas =
            document.getElementById('categorySalesChart');

        if (categoryCanvas) {
            new Chart(categoryCanvas, {
                type: 'pie',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryData,
                        backgroundColor: [
                            '#2b5c1c',
                            '#3a7023',
                            '#82B366',
                            '#A1C77A'
                        ],
                        borderColor: '#FFFFFF',
                        borderWidth: 4
                    }]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'right'
                        }
                    }
                }
            });
        }
    });
</script>

@push('styles')
<style>
    .report-page {
        padding: 35px 40px;
        background: #f7f8fb;
        min-height: calc(100vh - 70px);
        box-sizing: border-box;
    }
    .report-title {
        font-family: Georgia, serif;
        font-size: 34px;
        color: #111;
        margin-bottom: 25px;
    }
    .report-filter {
        background: #ffffff;
        padding: 20px 25px;
        margin-bottom: 25px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, .10);
    }
    .report-filter form {
        display: flex;
        align-items: flex-end;
        gap: 18px;
        flex-wrap: wrap;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }
    .filter-group label {
        font-family: Georgia, serif;
        font-size: 16px;
        color: #111;
    }
    .filter-group select {
        min-width: 160px;
        height: 40px;
        padding: 0 12px;
        border: 1px solid #c9c9c9;
        border-radius: 5px;
        background: #fff;
        color: #111;
        font-size: 14px;
        outline: none;
    }
    .filter-group select:focus {
        border-color: #689F50;
    }
    .filter-button {
        height: 40px;
        padding: 0 25px;
        border: none;
        border-radius: 5px;
        background: #008000;
        color: #fff;
        font-family: Georgia, serif;
        font-size: 16px;
        cursor: pointer;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .15);
    }
    .filter-button:hover {
        background: #006b00;
    }
    .summary-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-bottom: 25px;
    }
    .summary-card {
        background: #ffffff;
        padding: 22px 25px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, .10);
    }
    .summary-title {
        font-family: Georgia, serif;
        font-size: 18px;
        color: #555;
        margin-bottom: 8px;
    }
    .summary-value {
        font-size: 27px;
        color: #315b25;
        font-weight: bold;
    }
    .charts-container { 
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 25px;
        margin-bottom: 25px;
    }
    .chart-container {
        position: relative;
        width: 100%;
        height: 310px;
    }
    .chart-container canvas {
        width: 100% !important;
        height: 100% !important;
    }
    .chart-card {
        background: #ffffff;
        padding: 22px 25px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, .10);
        min-height: 390px;
        box-sizing: border-box;
    }
    .chart-title {
        font-family: Georgia, serif;
        font-size: 20px;
        color: #111;
        margin-bottom: 20px;
    }
    .chart-wrapper {
        width: 100%;
        height: 310px;
    }
    .chart-wrapper canvas {
        width: 100% !important;
        height: 100% !important;
    }
    .pie-container canvas {
        width: 100% !important;
        height: 100% !important;
    }
    .no-category-data {
        min-height: 310px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #888;
        font-size: 15px;
    }
    .recap-card {
        background: #ffffff;
        padding: 22px 25px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, .10);
    }
    .recap-title {
        font-family: Georgia, serif;
        font-size: 20px;
        color: #111;
        margin-bottom: 20px;
    }
    .recap-table-wrapper {
        overflow-x: auto;
    }
    .recap-table {
        width: 100%;
        border-collapse: collapse;
    }
    .recap-table th,
    .recap-table td {
        border: 1px solid #275a2f;
    }
    .recap-table th {
        background: #6b8a5d;
        padding: 13px 15px;
        text-align: center;
        font-size: 15px;
        color: #f5f4e8;
    }
    .recap-table td {
        padding: 12px 15px;
        text-align: center;
        font-size: 14px;
        color: #111;
    }
    .recap-table tr:hover {
        background: #f5f8f3;
    }
    .empty-recap {
        padding: 25px !important;
        color: #777 !important;
    }


    @media (max-width: 1000px) {

        .charts-container {
            grid-template-columns: 1fr;
        }
        .summary-container {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 768px) {

        .report-page {
            padding: 25px 20px;
        }
        .report-title {
            font-size: 29px;
        }
        .category-chart-container {
            flex-direction: column;
        }
        .category-legend {
            width: 100%;
            align-items: flex-start;
        }

    }

</style>
@endpush