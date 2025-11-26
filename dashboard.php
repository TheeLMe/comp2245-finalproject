<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dolphin CRM - Dashboard</title>
  <link rel="stylesheet" href="assets/CSS/styles.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="assets/JS/dashboard.js" defer></script>
</head>
<body class="dashboard-page">
  <div class="top-header">
    <img src="assets/images/dolphin.png" alt="Dolphin CRM Logo" class="logo" />
    <h1>Dolphin CRM</h1>
  </div>

  <div class="dashboard-wrapper">
    <aside class="sidebar">
      <nav>
        <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
        <a href="contacts.html"><i class="fas fa-user-plus"></i> New Contact</a>
        <a href="Users.html"><i class="fas fa-users"></i> Users</a>
        <hr class="sidebar-divider">
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </nav>
    </aside>

    <main class="main-content">
      <h2 class="section-title">Dashboard</h2>

      <div class="top-bar">
        <div class="filters">
          <span class="filter-label"><i class="fa-solid fa-filter"></i> Filter By:</span>
          <a href="#" data-filter="all">All</a>
          <a href="#" data-filter="sales">Sales Leads</a>
          <a href="#" data-filter="support">Support</a>
          <a href="#" data-filter="mine">Assigned to Me</a>
        </div>
        <a href="contacts.html" class="add-contact-btn">+ Add Contact</a>
      </div>

      <table class="contacts-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Company</th>
            <th>Type</th>
            <th>View</th>
          </tr>
        </thead>
        <tbody id="contacts-body">
          <!-- Rows created by dashboard.js -->
        </tbody>
      </table>
    </main>
  </div>


</body>
</html>
