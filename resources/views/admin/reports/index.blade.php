@extends('layouts.app')

@section('title', 'Sales Report')


@push('styles')
    <link href="{{ asset('css/report.css') }}" rel="stylesheet">
@endpush

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

