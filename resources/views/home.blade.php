@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <!-- Bar Chart Card -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        Total Tours per Tour Planner
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height: 350px;">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Pie Chart Card -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-success text-white">
                        Percentage of Tours by Status
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height: 350px;">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Line Chart Card -->
            <div class="col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        Tours Created Monthly (Last 6 Months)
                    </div>
                    <div class="card-body" style="height: 400px;">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Pass PHP data to JS
            const tours = @json($tours);

            // Prepare Bar Chart data: Total tours per planner
            const plannerTourCounts = {};
            tours.forEach(tour => {
                const plannerName = tour.planner ? tour.planner.name : 'Unknown';
                if (plannerTourCounts[plannerName]) {
                    plannerTourCounts[plannerName]++;
                } else {
                    plannerTourCounts[plannerName] = 1;
                }
            });
            const barLabels = Object.keys(plannerTourCounts);
            const barData = Object.values(plannerTourCounts);

            // Prepare Pie Chart data: Upcoming, Ongoing, Ended
            let upcoming = 0,
                ongoing = 0,
                ended = 0;
            const today = new Date();

            tours.forEach(tour => {
                const startDate = new Date(tour.start_date);
                const endDate = new Date(tour.end_date);
                if (today < startDate) {
                    upcoming++;
                } else if (today >= startDate && today <= endDate) {
                    ongoing++;
                } else {
                    ended++;
                }
            });

            // Prepare Line Chart data: Tours Created Monthly (Last 6 Months)
            const months = [];
            const monthCounts = [];

            const now = new Date();
            for (let i = 5; i >= 0; i--) {
                const d = new Date(now.getFullYear(), now.getMonth() - i, 1);
                const monthName = d.toLocaleString('default', {
                    month: 'short'
                });
                months.push(monthName);

                const monthNumber = d.getMonth() + 1; // month is 0-indexed
                const year = d.getFullYear();
                const count = tours.filter(tour => {
                    const createdAt = new Date(tour.created_at);
                    return createdAt.getMonth() + 1 === monthNumber && createdAt.getFullYear() === year;
                }).length;

                monthCounts.push(count);
            }

            // Bar Chart
            const barCtx = document.getElementById('barChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: barLabels,
                    datasets: [{
                        label: 'Total Tours',
                        data: barData,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Pie Chart
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: ['Upcoming', 'Ongoing', 'Ended'],
                    datasets: [{
                        data: [upcoming, ongoing, ended],
                        backgroundColor: [
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(255, 99, 132, 0.8)'
                        ],
                        borderColor: [
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Line Chart
            const lineCtx = document.getElementById('lineChart').getContext('2d');
            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Tours Created',
                        data: monthCounts,
                        fill: true,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        });
    </script>
@endpush
