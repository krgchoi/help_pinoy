<?php
$ch = curl_init('http://localhost:5000/get_locations');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$locations = json_decode($response, true);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_location'])) {
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $latitude = htmlspecialchars($_POST['latitude']);
    $longitude = htmlspecialchars($_POST['longitude']);

    $data = json_encode([
        'name' => $name,
        'address' => $address,
        'latitude' => $latitude,
        'longitude' => $longitude
    ]);

    $ch = curl_init('http://localhost:5000/add_location');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    curl_close($ch);

    $flask_data = json_decode($response, true);
    if ($flask_data['status'] == 'success') {
        echo "<script>alert('Location added successfully!');</script>";
    } else {
        echo "<script>alert('Fail adding location!');</script>";
    }
    header("Location: location.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_center'])) {
    $location_id = $_POST['location_id'];

    $data = json_encode([
        'location_id' => $location_id
    ]);

    $ch = curl_init('http://localhost:5000/delete_location');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    curl_close($ch);

    $flask_data = json_decode($response, true);
    if ($flask_data['status'] == 'success') {
        echo "<script>alert('Location deleted successfully!');</script>";
    } else {
        echo "<script>alert('Fail deleting location!');</script>";
    }
    header("Location: location.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_location'])) {
    $location_id = $_POST['location_id'];
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $latitude = htmlspecialchars($_POST['latitude']);
    $longitude = htmlspecialchars($_POST['longitude']);

    $data = json_encode([
        'location_id' => $location_id,
        'name' => $name,
        'address' => $address,
        'latitude' => $latitude,
        'longitude' => $longitude
    ]);

    $ch = curl_init('http://localhost:5000/edit_location');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    curl_close($ch);

    $flask_data = json_decode($response, true);
    if ($flask_data['status'] == 'success') {
        echo "<script>alert('Location updated successfully!');</script>";
    } else {
        echo "<script>alert('Fail updating location!');</script>";
    }
}

include('template/head.php');
?>

<div class="container mt-5">
    <h2>Manage Donation Centers</h2>
    <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addcenters">Add New Location</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Location Name</th>
                <th>Address</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

            <?php if (!empty($locations)): ?>
                <?php foreach ($locations as $location): ?>
                    <tr>
                        <td><?php echo $location['id']; ?></td>
                        <td><?php echo $location['name']; ?></td>
                        <td><?php echo $location['address']; ?></td>
                        <td><?php echo $location['latitude']; ?></td>
                        <td><?php echo $location['longitude']; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCenter<?php echo $location['id']; ?>">
                                Edit
                            </button>

                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="location_id" value="<?php echo $location['id']; ?>">
                                <button type="submit" name="delete_center" class="btn btn-danger btn-sm" onclick="return confirm('Delete Center?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No locations found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add New Donation Center Modal -->
<div class="modal fade" id="addcenters" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Donation Center</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="locationName" class="form-label">Location Name</label>
                        <input type="text" class="form-control" id="locationName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="latitude" class="form-label">Latitude</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" required>
                    </div>
                    <div class="mb-3">
                        <label for="longitude" class="form-label">Longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" required>
                    </div>
                    <button type="submit" name="add_location" class="btn btn-primary">Add Location</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Donation Center Modal -->
<?php foreach ($locations as $location): ?>
    <div class="modal fade" id="editCenter<?php echo $location['id']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Donation Center</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="location_id" value="<?php echo $location['id']; ?>">
                        <div class="mb-3">
                            <label for="locationName" class="form-label">Location Name</label>
                            <input type="text" class="form-control" id="locationName" name="name" value="<?php echo $location['name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $location['address']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo $location['latitude']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo $location['longitude']; ?>" required>
                        </div>
                        <button type="submit" name="edit_location" class="btn btn-primary">Update Location</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<?php include('template/foot.php'); ?>