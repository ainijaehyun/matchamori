@extends('layouts.app')

@section('title', 'Sales Report')


@push('styles')
    <link href="{{ asset('css/report.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@section('content')

<div class="report-page">
   <div class="report-header">
    <div class="report-title">
        Sales Report
    </div>
</div>
    
    <div class="report-filter">

        <form action="{{ route('admin.reports.index') }}" method="GET">

            <div class="filter-group">
                <label for="month">Bulan</label>
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
                    ] as $number => $name)
                        @if (
                            $year < $currentDate->year
                            || $number <= $currentDate->month
                        )
                            <option value="{{ $number }}"
                                {{ (int) $month === $number ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="year">Tahun</label>
                <select name="year" id="year">
                    @for ($i = $currentDate->year; $i >= $currentDate->year - 10; $i--)
                        <option value="{{ $i }}"
                            {{ (int) $year === $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="filter-button">
                Filter
            </button>

            <a href="{{ route('admin.reports.pdf', ['day' => $day, 'month' => $month, 'year' => $year]) }}" target="_blank" class="export-pdf-button">
                Export
                <i class="fas fa-print"></i>
            </a>

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
                Sales (Daily)
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

    
    {{-- Daftar Pesanan --}}
    <div class="report-orders-card">
        <div class="report-orders-heading">
            <div>
                <h2>Daftar Pesanan</h2>
                <p>Daftar pesanan yang telah dibayar pada periode yang dipilih.</p>
            </div>
        </div>

        <div class="report-orders-table-wrapper">
            <table class="report-orders-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Tanggal Pesanan</th>
                        <th>Metode Pembayaran</th>
                        <th>Total</th>
                        <th>Status Pembayaran</th>
                        <th>Status Pesanan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', ['id' => $order->id]) }}" class="report-invoice-link" style="position: relative; z-index: 9999; pointer-events: auto;">
                                {{ $order->invoice ?? 'Lihat Detail' }}
                                </a>
                            </td>
                            <td>{{ $order->user->name ?? '-' }}</td>
                            <td>
                                {{ $order->created_at
                                    ? $order->created_at->format('d-m-Y')
                                    : '-' }}
                            </td>
                            <td>{{ $order->payment_method ?? '-' }}</td>
                            <td class="report-order-total">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="report-status paid">
                                    {{ $order->payment_status }}
                                </span>
                            </td>
                            <td>
                                <span class="report-status order-status">
                                    {{ $order->order_status ?? '-' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="report-orders-empty">
                                Tidak ada pesanan yang sudah dibayar pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="report-orders-footer">
            Total pesanan ditampilkan: {{ $orders->count() }}
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
    
        const monthlyLabels = @json($salesChartLabels);
        const monthlyData = @json($salesChartData);

        const monthlyCanvas = document.getElementById('monthlySalesChart');

        if (monthlyCanvas) {
            new Chart(monthlyCanvas, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Total Penjualan',
                        data: monthlyData,
                        borderColor: '#27AE60',
                        backgroundColor: 'rgba(39, 174, 96, 0.12)',
                        pointBackgroundColor: '#FFFFFF',
                        pointBorderColor: '#27AE60',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        borderWidth: 2,
                        tension: 0,
                        fill: false,
                        spanGaps: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Penjualan: Rp ' +
                                        new Intl.NumberFormat('id-ID')
                                            .format(context.parsed.y || 0);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal'
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Penjualan (Rp)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('id-ID', {
                                        notation: 'compact',
                                        maximumFractionDigits: 1
                                    }).format(value);
                                }
                            }
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

        const categoryCanvas = document.getElementById('categorySalesChart');

        if (categoryCanvas) {
            new Chart(categoryCanvas, {
                type: 'doughnut',

                data: {
                    labels: @json($salesByCategory->pluck('category_name')),
                    datasets: [{
                        label: 'Total Sales',
                        data: @json($salesByCategory->pluck('total')),

                        backgroundColor: [
                            '#6F925C',
                            '#A8BE91',
                            '#D3DFC5',
                            '#8BA99A',
                            '#C5B89A',
                            '#54734A',
                            '#E3E9DC'
                        ],

                        borderColor: '#FFFFFF',
                        borderWidth: 3,
                        hoverOffset: 8,
                        borderRadius: 4,
                        spacing: 2
                    }]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '62%',

                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#687663',
                                padding: 18,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                boxWidth: 9,
                                boxHeight: 9,
                                font: {
                                    size: 11
                                }
                            }
                        },

                        tooltip: {
                            backgroundColor: '#304A2F',
                            padding: 12,
                            displayColors: true,

                            callbacks: {
                                label: function(context) {
                                    return context.label + ': Rp ' +
                                        Number(context.raw).toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
