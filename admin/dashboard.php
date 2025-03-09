<?php
include('template/head.php');


$api_url = "http://localhost:5000/dashboard_data";
$response = file_get_contents($api_url);
$data = json_decode($response, true);

$sd = $data['sd'];
$sd_month = $data['sd_month'];
$td = $data['td'];
$tu = $data['tu'];


//dummy data
$donationDates = ['2025-01-01', '2025-01-02', '2025-01-03', '2025-01-04'];
$donationAmounts = [2000, 1500, 1800, 2300];

$donationMonths = array_map(function ($date) {
    return date('M', strtotime($date));
}, $donationDates);

$paymentMethods = ['GCash', 'Bank Transfer', 'PayPal'];
$paymentMethodCounts = [50, 30, 20];

$donationTypes = ['Online', 'Onsite'];
$donationTypeCounts = [80, 45];
?>


<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Donations</h5>
                    <p class="card-text">₱ <?php echo $sd; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Donations This Month</h5>
                    <p class="card-text">₱ <?php echo $sd_month; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Donors</h5>
                    <p class="card-text"><?php echo $sd; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text"><?php echo $tu; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Donation Trends</div>
                <div class="card-body">
                    <div id="donationTrendsChart" style="width: 100%; height: 100%;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Payment Method Distribution</div>
                <div class="card-body">
                    <div id="paymentMethodChart" style="width: 100%; height: 100%;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Online vs Onsite Donations</div>
                <div class="card-body">
                    <div id="donationTypeChart" style="width: 100%; height: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <h4>Recent Donations</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Donor Name</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                        <td>1</td>
                        <td>John Doe</td>
                        <td>₱ 2,000</td>
                        <td>Completed</td>
                        <td><a href="donations.php" class="btn btn-info">View</a></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Alice Smith</td>
                        <td>₱ 1,500</td>
                        <td>Pending</td>
                        <td><a href="donations.php" class="btn btn-info">View</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            <h4>Ano pa butang di?</h4>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        packages: ['corechart']
    });
    google.charts.setOnLoadCallback(drawDonationTrends);

    function drawDonationTrends() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Month');
        data.addColumn('number', 'Donation Amount');
        data.addRows(<?php echo json_encode(array_map(null, $donationMonths, $donationAmounts)); ?>);

        var options = {
            title: 'Donation Trends Over Time',
            legend: {
                position: 'none'
            },
            hAxis: {
                title: 'Date'
            },
            vAxis: {
                title: 'Amount (₱)'
            },
            backgroundColor: '#f4f4f4',
            colors: ['#4285F4']
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('donationTrendsChart'));
        chart.draw(data, options);
    }
    google.charts.setOnLoadCallback(drawPaymentMethodChart);

    function drawPaymentMethodChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Payment Method');
        data.addColumn('number', 'Count');
        data.addRows(<?php echo json_encode(array_map(null, $paymentMethods, $paymentMethodCounts)); ?>);

        var options = {
            title: 'Payment Method Distribution',
            legend: {
                position: 'bottom'
            },
            pieHole: 0.4,
            backgroundColor: '#f4f4f4'
        };

        var chart = new google.visualization.PieChart(document.getElementById('paymentMethodChart'));
        chart.draw(data, options);
    }

    google.charts.setOnLoadCallback(drawDonationTypeChart);

    function drawDonationTypeChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Donation Type');
        data.addColumn('number', 'Count');
        data.addRows(<?php echo json_encode(array_map(null, $donationTypes, $donationTypeCounts)); ?>);

        var options = {
            title: 'Online vs Onsite Donations',
            legend: {
                position: 'bottom'
            },
            pieHole: 0.4, // For a donut chart
            backgroundColor: '#f4f4f4'
        };

        var chart = new google.visualization.PieChart(document.getElementById('donationTypeChart'));
        chart.draw(data, options);
    }
</script>


<?php include('template/foot.php'); ?>