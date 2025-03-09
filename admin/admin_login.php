<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $api_url = 'http://localhost:5000/admin_login';
    $data = json_encode(['email' => $email, 'password' => $password]);

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);

    if ($response === false) {
        $error = "Server error: Unable to connect.";
    } else {
        $result = json_decode($response, true);

        if (isset($result['status']) && $result['status'] === 'success' && isset($result['admin']) && isset($result['token'])) {
            $_SESSION['admin'] = $result['admin'];
            $_SESSION['jwt_token'] = $result['token'];
            session_regenerate_id(true);
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Invalid email or password";
        }
    }
    curl_close($ch);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>

<body>
    <div class="container">
        <h2>Admin Login</h2>
        <?php if (isset($error)) echo "<p style='color: red;'>" . htmlspecialchars($error) . "</p>"; ?>
        <form action="" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>