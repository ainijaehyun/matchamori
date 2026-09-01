@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<style>

    /* AREA DASHBOARD */
    .dashboard-page {
        padding: 35px 40px;
        background: #f7f8fb;
        min-height: calc(100vh - 70px);
        box-sizing: border-box;
    }


    /* JUDUL */
    .dashboard-title {
        font-family: Georgia, serif;
        font-size: 34px;
        margin-bottom: 25px;
        color: #111;
    }


    /* STATISTIC */
    .stat-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        margin-bottom: 45px;
    }


    .stat-card {
        background: #b9df9f;
        border-radius: 28px;
        padding: 22px 25px;
        min-height: 125px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.12);

        display: flex;
        justify-content: space-between;
        align-items: center;

        box-sizing: border-box;
    }


    .stat-info {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }


    .stat-title {
        font-size: 18px;
        color: #111;
    }


    .stat-number {
        font-size: 27px;
        color: #111;
    }


    .stat-icon {
        font-size: 45px;
        color: #000;
        flex-shrink: 0;
    }


    /* CHART */
    .chart-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 25px;
        margin-bottom: 45px;
    }


    .chart-card {
        background: white;
        border-radius: 25px;
        padding: 20px 25px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.10);
        min-height: 280px;
    }


    .chart-title {
        font-family: Georgia, serif;
        font-size: 22px;
        margin-bottom: 15px;
        color: #111;
    }


    .chart-container {
        position: relative;
        height: 220px;
    }


    /* RECENT ORDERS */
    .recent-title {
        font-family: Georgia, serif;
        font-size: 22px;
        margin-bottom: 18px;
    }


    .order-table-wrapper {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 3px 8px rgba(0,0,0,0.10);
    }


    .order-table {
        width: 100%;
        border-collapse: collapse;
    }


    .order-table th {
        background: #b9df9f;
        padding: 15px;
        text-align: center;
        font-size: 16px;
    }


    .order-table td {
        padding: 15px;
        text-align: center;
        border-top: 1px solid #ddd;
        font-size: 15px;
    }


    .order-table tr:hover {
        background: #f5f5f5;
    }


    /* RESPONSIVE */
    @media (max-width: 1100px) {

        .stat-row {
            grid-template-columns: repeat(2, 1fr);
        }

        .chart-row {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 768px) {

        .custom-sidebar {
            width: 200px;
        }

        .custom-navbar,
        .dashboard-page {
            margin-left: 200px;
        }

        .stat-row {
            grid-template-columns: 1fr;
        }

    }

</style>


<div class="dashboard-page">

    {{-- JUDUL --}}
    <div class="dashboard-title">
        Dashboard Page
    </div>


    {{-- ================= STATISTIK ================= --}}

    <div class="stat-row">

        {{-- PRODUCT --}}
        <div class="stat-card">

            <div class="stat-info">
                <div class="stat-title">
                    Total Product
                </div>

                <div class="stat-number">
                    {{ $totalProducts }}
                </div>
            </div>

            <i class="fas fa-box stat-icon"></i>

        </div>


        {{-- CUSTOMER --}}
        <div class="stat-card">

            <div class="stat-info">
                <div class="stat-title">
                    Total Customer
                </div>

                <div class="stat-number">
                    {{ $totalCustomers }}
                </div>
            </div>

            <i class="fas fa-users stat-icon"></i>

        </div>


        {{-- ORDER --}}
        <div class="stat-card">

            <div class="stat-info">
                <div class="stat-title">
                    Total Order
                </div>

                <div class="stat-number">
                    {{ $totalOrders }}
                </div>
            </div>

            <i class="fas fa-receipt stat-icon"></i>

        </div>


        {{-- SALES --}}
        <div class="stat-card">

            <div class="stat-info">
                <div class="stat-title">
                    Total Sales
                </div>

                <div class="stat-number">
                    Rp. {{ number_format($totalSales, 0, ',', '.') }}
                </div>
            </div>

            <i class="fas fa-shopping-bag stat-icon"></i>

        </div>

    </div>


    {{-- ================= CHART ================= --}}

    <div class="chart-row">

        {{-- MONTHLY SALES --}}
        <div class="chart-card">

            <div class="chart-title">
                Sales (Monthly)
            </div>

            <div class="chart-container">
                <canvas id="monthlySalesChart"></canvas>
            </div>

        </div>


        {{-- SALES BY CATEGORY --}}
        <div class="chart-card">

            <div class="chart-title">
                Sales by Category
            </div>

            <div class="chart-container">
                <canvas id="categorySalesChart"></canvas>
            </div>

        </div>

    </div>


    {{-- ================= RECENT ORDERS ================= --}}

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


{{-- ================= CHART.JS ================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    /* MONTHLY SALES */

    const monthlyLabels = [
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
        'Jul', 'Agst', 'Sep', 'Okt', 'Nov', 'Des'
    ];

    const monthlyData = Array(12).fill(0);

    @foreach($monthlySales as $month => $total)

        monthlyData[{{ $month - 1 }}] = {{ $total }};

    @endforeach


    new Chart(document.getElementById('monthlySalesChart'), {

        type: 'line',

        data: {

            labels: monthlyLabels,

            datasets: [{

                label: 'Sales',

                data: monthlyData,

                borderWidth: 2,

                tension: 0.3,

                fill: false

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            scales: {

                y: {
                    beginAtZero: true
                }

            }

        }

    });



    /* SALES BY CATEGORY */

    const categoryLabels = @json($salesByCategory->keys());
    const categoryData = @json($salesByCategory->values());


    new Chart(document.getElementById('categorySalesChart'), {

        type: 'pie',

        data: {

            labels: categoryLabels,

            datasets: [{

                data: categoryData,

                borderWidth: 2

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    position: 'right'
                }

            }

        }

    });

</script>

@endsection