@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@section('content')

<div class="dashboard-page">
    <div class="dashboard-title">
        Dashboard Page
    </div>

    <div class="stat-row">
        <a href="{{ route('admin.products.index') }}" class="stat-card">
            <div class="stat-info">
                <div class="stat-title">
                    Total Product
                </div>

                <div class="stat-number">
                    {{ $totalProducts }}
                </div>
            </div>

            <i class="fas fa-box stat-icon"></i>
        </a>

        <a href="{{ route('admin.customers.index') }}" class="stat-card">
            <div class="stat-info">
                <div class="stat-title">
                    Total Customer
                </div>

                <div class="stat-number">
                    {{ $totalCustomers }}
                </div>
            </div>

            <i class="fas fa-users stat-icon"></i>
        </a>

        <a href="{{ route('admin.orders.index') }}" class="stat-card">
            <div class="stat-info">
                <div class="stat-title">
                    Total Order
                </div>

                <div class="stat-number">
                    {{ $totalOrders }}
                </div>
            </div>

            <i class="fas fa-receipt stat-icon"></i>
        </a>

        <a href="{{ route('admin.reports.index') }}" class="stat-card">
            <div class="stat-info">
                <div class="stat-title">
                    Total Sales
                </div>

                <div class="stat-number">
                    Rp. {{ number_format($totalSales, 0, ',', '.') }}
                </div>
            </div>

            <i class="fas fa-shopping-bag stat-icon"></i>
        </a>
    </div>

    <div class="chart-row">
        <div class="chart-card">
            <div class="chart-title">
                Sales (Daily)
            </div>

            <div class="chart-container">
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-title">
                Sales by Category
            </div>

            <div class="chart-container">
                <canvas id="categorySalesChart"></canvas>
            </div>
        </div>
    </div>

    <div class="recent-title">
        Recent Orders
    </div>

    <div class="order-table-wrapper">
        <table class="order-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($recentOrders as $index => $order)
                    <tr>
                        <td>
                            {{ $index + 1 }}.
                        </td>
                        <td>
                            #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        <td>
                            {{ $order->user->name ?? '-' }}
                        </td>
                        <td>
                            {{ $order->created_at->format('d F Y') }}
                        </td>
                        <td>
                            Rp. {{ number_format($order->total, 0, ',', '.') }}
                        </td>
                        <td>
                            {{ ucfirst($order->order_status) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            Belum ada order.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


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
            $salesByCategory->pluck('total')
                ->map(fn ($value) => (float) $value)
                ->values()
        );

        const categoryCanvas =
            document.getElementById('categorySalesChart');

        if (categoryCanvas) {
            new Chart(categoryCanvas, {
                type: 'doughnut',

                data: {
                    labels: categoryLabels,
                    datasets: [{
                        label: 'Total Sales',
                        data: categoryData,

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
                                        Number(context.raw)
                                            .toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }

        
    });
</script>

@endsection
