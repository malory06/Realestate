<?php include('config/db.php'); ?>


<!DOCTYPE html>
<html>
<head>
    <title>Real Estate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: Arial;
        }

        .sidebar {
            height: 100vh;
            width: 220px;
            position: fixed;
            top: 0;
            left: 0;
            background: #111;
            padding-top: 20px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #333;
        }

        .main {
            margin-left: 220px;
            padding: 20px;
        }

        .card img {
            height: 180px;
            object-fit: cover;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<?php session_start(); 

if (!empty($_SESSION['user']))  {
    $_SESSION['role'] = 'guest';
}
?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="index.php">🏠 Real Estate</a>

    <!-- Toggle for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navBar">

        <!-- Left links -->
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="favorites.php">❤️ Favorites</a>
            </li>

            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                <li class="nav-item">
                    <a class="nav-link" href="admin/dashboard.php">Admin</a>
                </li>
            <?php } ?>
            
              <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'agent') { ?>
            <a class="nav-link" href="agent/dashboard.php">Agent</a>
            <?php } ?>

        </ul>

        <!-- 🔍 SEARCH BAR -->
        <form method="GET" class="d-flex me-3">
            <input 
                class="form-control form-control-sm me-2" 
                type="search" 
                name="search"
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                placeholder="Search..."
                style="width:200px;"
            >
            <button class="btn btn-outline-light btn-sm">Search</button>
        </form>

        <!-- Right side (auth) -->
        <ul class="navbar-nav">
        <?php
$name = $_SESSION['name'] ?? 'Guest';
$isLoggedIn = isset($_SESSION['user']);
?>

<li class="nav-item">
    <span class="nav-link">Welcome, <?= $name ?></span>
</li>

<?php if($isLoggedIn) { ?>
    <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
    </li>
<?php } else { ?>
    <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="register.php">Register</a>
    </li>
<?php } ?>

    
    


        </ul>

    </div>
   

  
    

</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- MAIN CONTENT -->
<div class="main">

    <h2 class="mb-4">Available Properties</h2>

    <div class="row">
        <?php
        $search = $_GET['search'] ?? '';

if ($search) {
    $result = $conn->query("
        SELECT * FROM properties 
        WHERE title LIKE '%$search%' 
        OR location LIKE '%$search%'
        ORDER BY id DESC
    ");
} else {
    $result = $conn->query("SELECT * FROM properties ORDER BY id DESC");
}
     while($row = $result->fetch_assoc()) {
        ?>
        <div class="col-md-4">
            <div class="card mb-3 shadow-sm">
                <img src="uploads/<?= $row['image'] ?>" class="card-img-top">
                <div class="card-body">
                    <h5><?= $row['title'] ?></h5>
                    <p><?= $row['location'] ?></p>
                    <b>$<?= $row['price'] ?></b>
    <?php
$agentInfo = $conn->query("
    SELECT name, phone FROM users 
    WHERE email='{$row['agent_email']}'
")->fetch_assoc();
?>

<p>
    <b>Agent:</b> 
    <a href="agent_profile.php?email=<?= $row['agent_email'] ?>">
        <?= $agentInfo['name'] ?>
    </a>
</p>

<!-- 📧 EMAIL -->
<a href="mailto:<?= $row['agent_email'] ?>" class="btn btn-primary btn-sm">
    📧 Email
</a>

<!-- 💬 WHATSAPP -->
<?php if(!empty($agentInfo['phone'])) { ?>
<a href="https://wa.me/<?= $agentInfo['phone'] ?>" 
   target="_blank" 
   class="btn btn-success btn-sm">
   💬 WhatsApp
</a>
<?php } ?>
<?php
if (isset($_SESSION['user_id'])) {

$favCheck = $conn->query("
    SELECT id FROM favorites 
    WHERE user_id={$_SESSION['user_id']}
    AND property_id={$row['id']}
");
?><?php } ?>
 

<?php
if (isset($_SESSION['user'])) {

    $favCheck = $conn->query("
        SELECT id FROM favorites 
        WHERE user_email='{$_SESSION['user']}'
        AND property_id={$row['id']}
    ");

    if ($favCheck && $favCheck->num_rows > 0) {
?>
        <a href="remove_favorite.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">
            ❤️ Remove
        </a>
<?php
    } else {
?>
        <a href="favorite.php?id=<?= $row['id'] ?>" class="btn btn-outline-danger btn-sm">
            🤍 Favorite
        </a>
<?php
    }

} else {
?>
    <a href="login.php" class="btn btn-outline-secondary btn-sm">
        🤍 Login to Favorite
    </a>
<?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

</div>

</body>
</html>

<?php if(isset($_GET['logged_out'])) { ?>
    <div class="alert alert-success">
        You have been logged out successfully.
    </div>
<?php } ?>

