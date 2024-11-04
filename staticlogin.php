<?php
    $arrUsersList = [
        'Admin' => [
            'Yuuji' => 'Itadori',
            'Satoru' => 'Gojo'
        ],
        'Content Manager' => [
            'Toge' => 'Inumaki',
            'Zenin' => 'Maki'
        ],
        'System User' => [
            'Ryomen' => 'Sukuna'
        ]
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/custom-login.css">
    <title>Login</title>
</head>
<body>
    <div class="container mt-5">
        <?php 
        // Display success or error message
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnSignIn'])) { 
            $userType = $_POST['inputUserType'] ?? '';
            $userUsername = $_POST['inputUserName'] ?? '';
            $userPassword = $_POST['inputPassword'] ?? '';

            if (isset($arrUsersList[$userType][$userUsername]) && $arrUsersList[$userType][$userUsername] === $userPassword) {
                echo '<div class="alert alert-success alert-dismissible fade show" style="max-width: 350px; margin: auto;">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        Welcome to the system: ' . htmlspecialchars($userUsername) . '.
                      </div>';
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show" style="max-width: 350px; margin: auto;">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        Incorrect Username / Password.
                      </div>';
            }
        } 
        ?>
        
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body text-center">
                <img class="profile-img-card mb-3" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" alt="Profile Image" />
                <h4 class="card-title">Login</h4>
                <form method="post" class="form-signin">
                    <div class="mb-3">
                        <select class="form-select" name="inputUserType" id="inputUserType" required>
                            <option disabled selected>Select User Type</option>
                            <?php 
                            // Generate user types dynamically from array keys
                            foreach (array_keys($arrUsersList) as $type) {
                                echo "<option value=\"$type\">$type</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="inputUserName" id="inputUserName" class="form-control" placeholder="User Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="btnSignIn">Sign in</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
