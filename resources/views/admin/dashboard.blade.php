@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
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
                Sales (Monthly)
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

@endsection
