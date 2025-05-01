<?php
require_once './Auth/auth_check.php';
ob_start();
?>
<link rel="stylesheet" href="assets/css/reports.css">

<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card header-card">
                <div class="card-body">
                    <h1 class="page-title">Reports & Analytics</h1>
                    <p class="page-subtitle">Generate insights and track medical records compliance</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Generation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Generate Report</h5>
                    <div class="report-filters">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Report Type</label>
                                    <select class="form-select">
                                        <option value="compliance">Completed Report</option>
                                        <option value="expiry">Expired Report</option>
                                        <option value="summary">Expiring Report</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date Range</label>
                                    <select class="form-select">
                                        <option value="7">Last 7 Days</option>
                                        <option value="30">Last 30 Days</option>
                                        <option value="90">Last 90 Days</option>
                                        <option value="custom">Custom Range</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Format</label>
                                    <select class="form-select">
                                        <option value="pdf">PDF</option>
                                        <option value="excel">Excel</option>
                                        <option value="csv">CSV</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button class="btn btn-primary w-100">
                                        <i class="fas fa-file-export"></i> Generate Report
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Overview -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Compliance Overview</h5>
                    <div class="chart-container">
                        <canvas id="complianceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Document Status</h5>
                    <div class="chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Upcoming Expirations</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Document Type</th>
                                    <th>Count</th>
                                    <th>Next Expiry</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Immunization Records</td>
                                    <td>15</td>
                                    <td>Apr 30, 2024</td>
                                </tr>
                                <tr>
                                    <td>Physical Examinations</td>
                                    <td>8</td>
                                    <td>May 15, 2024</td>
                                </tr>
                                <tr>
                                    <td>TB Test Results</td>
                                    <td>12</td>
                                    <td>Jun 01, 2024</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Compliance by Year Level</h5>
                    <div class="chart-container">
                        <canvas id="yearLevelChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Compliance Overview Chart
    const complianceCtx = document.getElementById('complianceChart').getContext('2d');
    new Chart(complianceCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Complete Records',
                data: [65, 70, 75, 80, 85, 90],
                borderColor: '#0288d1',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

        // Document Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Valid', 'Expiring Soon', 'Expired'],
                datasets: [{
                    data: [70, 20, 10],
                    backgroundColor: ['#057a55', '#d97706', '#dc2626']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

    // Year Level Chart
    const yearLevelCtx = document.getElementById('yearLevelChart').getContext('2d');
    new Chart(yearLevelCtx, {
        type: 'bar',
        data: {
            labels: ['1st Year', '2nd Year', '3rd Year', '4th Year'],
            datasets: [{
                label: 'Compliance Rate',
                data: [75, 85, 90, 95],
                backgroundColor: '#0288d1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
</script>

<?php
$pageContent = ob_get_clean();
include './Navigations/navbar.php';           
?> 