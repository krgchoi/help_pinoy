<?php
include('template/head.php');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:5000/donations");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

$donations = json_decode($response, true);
?>

<div class="container mt-5">
    <h2>Manage Donations</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Reference Number</th>
                <th>Amount</th>
                <th>Donor Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($donations)): ?>
                <?php foreach ($donations as $donation): ?>
                    <tr>
                        <td><?php echo $donation['reference_number']; ?></td>
                        <td>₱ <?php echo $donation['amount']; ?></td>
                        <td><?php echo $donation['donor_name']; ?></td>
                        <td>
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#donationModal<?php echo $donation['reference_number']; ?>">View</button>
                        </td>
                    </tr>

                    <!--Modal -->
                    <div class="modal fade" id="donationModal<?php echo $donation['reference_number']; ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="donationModalLabel<?php echo $donation['reference_number']; ?>">
                                        Donation Details - <?php echo $donation['donor_name']; ?>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Reference Number:</strong> <?php echo $donation['reference_number']; ?></p>
                                    <p><strong>Donor Name:</strong> <?php echo $donation['donor_name']; ?></p>
                                    <p><strong>Amount:</strong> ₱ <?php echo $donation['amount']; ?></p>
                                    <p><strong>Payment Method:</strong> <?php echo $donation['payment_method']; ?></p>
                                    <p><strong>Donation Date:</strong> <?php echo $donation['donation_date']; ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No donations found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include('template/foot.php'); ?>