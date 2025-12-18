<?php
require_once "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit;
}

$id = $_GET["id"] ?? null;
if (!$id || !ctype_digit($id)) {
    http_response_code(400);
    die("Invalid contact ID.");
}

// Fetch contact details
$stmt = $pdo->prepare("SELECT c.*, 
                              u1.firstname AS assigned_first, u1.lastname AS assigned_last,
                              u2.firstname AS created_first, u2.lastname AS created_last
                       FROM contacts c
                       LEFT JOIN users u1 ON c.assigned_to = u1.id
                       LEFT JOIN users u2 ON c.created_by = u2.id
                       WHERE c.id = :id");
$stmt->execute(["id" => $id]);
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$contact) {
    http_response_code(404);
    die("Contact not found.");
}

// Fetch notes
$noteStmt = $pdo->prepare("SELECT n.*, u.firstname, u.lastname 
                           FROM notes n 
                           JOIN users u ON n.created_by = u.id 
                           WHERE n.contact_id = :id 
                           ORDER BY n.created_at DESC");
$noteStmt->execute(["id" => $id]);
$notes = $noteStmt->fetchAll(PDO::FETCH_ASSOC);

// Determine alternate type label
$currentType = strtoupper($contact['type'] ?? '');
$switchLabel = ($currentType === 'SALES LEAD') ? 'Support' : 'Sales Lead';

// Current user ID
$currentUserId = $_SESSION['user_id'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Details</title>
  <link rel="stylesheet" href="assets/CSS/contact_detailsstyles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="contact-page">

  <!-- Header -->
  <div class="top-header">
    <img src="assets/images/dolphin.png" alt="Dolphin CRM Logo" class="logo" />
    <h1>Dolphin CRM</h1>
  </div>

  <!-- Layout -->
  <div class="contact-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
      <nav>
        <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
        <a href="contacts.php"><i class="fas fa-user-plus"></i> New Contact</a>
        <a href="users.php"><i class="fas fa-users"></i> Users</a>
        <hr class="sidebar-divider">
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </nav>
    </aside>

    <!-- Main content -->
    <div class="contact-content">
      <div class="card contact-full">

        <!-- Row 1: Name + actions + meta -->
        <div class="row">
          <div class="card-header">
            <div class="title">
              <h2>
                <i class="fa-solid fa-circle-user contact-avatar"></i>
                <?= htmlspecialchars($contact["title"] . " " . $contact["firstname"] . " " . $contact["lastname"]) ?>
              </h2>

              <div class="meta">
                <div><i class="fa-solid fa-calendar-plus"></i> Created on:
                  <?= date("F j, Y", strtotime($contact["created_at"])) ?>
                  by <?= htmlspecialchars($contact["created_first"] . " " . $contact["created_last"]) ?>
                </div>
                <div><i class="fa-solid fa-calendar-check"></i> Updated on:
                  <?= date("F j, Y", strtotime($contact["updated_at"])) ?>
                </div>
              </div>
            </div>

            <div class="actions">
              <!-- Assign to me -->
              <form action="assign_contact.php" method="POST">
                <input type="hidden" name="contact_id" value="<?= $contact['id'] ?>">
                <input type="hidden" name="assigned_to" value="<?= htmlspecialchars($currentUserId) ?>">
                <button type="submit" class="btn btn-assign"><i class="fa-solid fa-user-check"></i> Assign to me</button>
              </form>

              <!-- Switch type -->
              <form action="switch_type.php" method="POST">
                <input type="hidden" name="contact_id" value="<?= $contact['id'] ?>">
                <input type="hidden" name="target_type" value="<?= htmlspecialchars($switchLabel) ?>">
                <button type="submit" class="btn btn-switch"><i class="fa-solid fa-shuffle"></i> Switch to <?= htmlspecialchars($switchLabel) ?></button>
              </form>
            </div>
          </div>
        </div>

        <!-- Row 2: Info grid -->
        <div class="row">
          <hr class="section-divider">
          <div class="info-grid">
            <div class="info-item"><i class="fa-solid fa-envelope"></i> <strong>Email:</strong> <?= htmlspecialchars($contact["email"]) ?></div>
            <div class="info-item"><i class="fa-solid fa-phone"></i> <strong>Telephone:</strong> <?= htmlspecialchars($contact["telephone"] ?? "N/A") ?></div>
            <div class="info-item"><i class="fa-solid fa-building"></i> <strong>Company:</strong> <?= htmlspecialchars($contact["company"]) ?></div>
            <div class="info-item"><i class="fa-solid fa-user-tag"></i> <strong>Assigned To:</strong> <?= htmlspecialchars($contact["assigned_first"] . " " . $contact["assigned_last"]) ?></div>
          </div>
        </div>

        <!-- Row 3: Notes -->
        <div class="row">
          <hr class="section-divider">
          <div class="notes-header"><i class="fa-solid fa-note-sticky"></i> Notes</div>

          <?php if (count($notes) === 0): ?>
            <p>No notes yet.</p>
          <?php else: ?>
            <?php foreach ($notes as $note): ?>
              <div class="note">
                <div class="note-author"><?= htmlspecialchars($note["firstname"] . " " . $note["lastname"]) ?></div>
                <div class="note-content"><?= nl2br(htmlspecialchars($note["comment"])) ?></div>
                <div class="note-meta"><i class="fa-solid fa-clock"></i> <?= date("F j, Y \a\\t g:ia", strtotime($note["created_at"])) ?></div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>

          <form action="add_note.php" method="POST" class="add-note">
            <h4><i class="fa-solid fa-pen"></i> Add a note about <?= htmlspecialchars($contact["firstname"] . " " . $contact["lastname"]) ?>:</h4>
            <textarea name="comment" placeholder="Enter details here..." required></textarea>
            <input type="hidden" name="contact_id" value="<?= $contact["id"] ?>">
            <button type="submit" class="save-note-btn"><i class="fa-solid fa-save"></i> Save Note</button>
          </form>
        </div>

      </div>
    </div>
  </div>
</body>
</html>
