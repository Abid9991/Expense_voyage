<?php
// --- strict errors (helps find issues that break JSON) ---
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// --- DB ---
$host = "localhost";
$user = "root";
$pass = "";
$db   = "project";

try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset('utf8mb4');
} catch (Throwable $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'DB connect failed', 'detail' => $e->getMessage()]);
    exit;
}

// Helper to send JSON and exit
function json_exit($payload, $code = 200) {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload);
    exit;
}

// -------------------- AJAX HANDLERS --------------------

// Get user data for editing
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT user_id, first_name, last_name, email FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    json_exit($row ?: null);
}

// Save edited user
if (isset($_POST['save_user'])) {
    $id    = (int)($_POST['user_id'] ?? 0);
    $first = trim($_POST['first_name'] ?? '');
    $last  = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($id <= 0 || $first === '' || $last === '' || $email === '') {
        json_exit(['success' => false, 'error' => 'Invalid input'], 400);
    }

    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE user_id = ?");
    $stmt->bind_param("sssi", $first, $last, $email, $id);
    $stmt->execute();

    json_exit(['success' => true]);
}

// Delete user
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id <= 0) json_exit(['success' => false, 'error' => 'Invalid ID'], 400);

    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    json_exit(['success' => true]);
}

// -------------------- PAGE DISPLAY --------------------
$result = $conn->query("SELECT user_id, first_name, last_name, email FROM users ORDER BY user_id DESC");
$users  = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

// Get all users
$users = [];
$result = $conn->query("SELECT user_id, first_name, last_name, email FROM users ORDER BY user_id DESC");
if ($result) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}

// Get statistics
$stats = [
    'total_users' => count($users),
    'new_users_today' => 0, // You would need to implement this based on registration date
];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
       .back-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    color: white;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 500;
    box-shadow: 0 4px 15px rgba(106, 17, 203, 0.3);
    margin: 20px 0 25px 15px;
    font-size: 15px;
    position: relative;
    overflow: hidden;
}

.back-button:hover {
    background: linear-gradient(135deg, #2575fc 0%, #6a11cb 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37, 117, 252, 0.4);
    color: white;
    text-decoration: none;
}

.back-button:active {
    transform: translateY(0);
}

.back-button i {
    font-size: 14px;
    transition: transform 0.3s ease;
}

.back-button:hover i {
    transform: translateX(-3px);
}

/* Optional: Add a subtle shine effect on hover */
.back-button::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -60%;
    width: 50%;
    height: 200%;
    background: rgba(255, 255, 255, 0.2);
    transform: rotate(30deg);
    transition: all 0.3s ease;
}

.back-button:hover::after {
    left: 110%;
}
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 24px 0 rgba(34, 41, 47, 0.1);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 25px 0 rgba(34, 41, 47, 0.25);
        }
        
        .card-statistic {
            padding: 1.5rem;
        }
        
        .card-statistic .card-title {
            font-size: 1rem;
            font-weight: 500;
            color: #6E6B7B;
            margin-bottom: 0.5rem;
        }
        
        .card-statistic .card-value {
            font-size: 1.75rem;
            font-weight: 600;
            color: #5D596C;
        }
        
        .card-statistic .card-change {
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .card-statistic .card-change.positive {
            color: var(--success);
        }
        
        .card-statistic .card-change.negative {
            color: var(--danger);
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .stat-card h3 {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .stat-card .value {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        .stat-card .change {
            font-size: 14px;
            color: #28a745;
        }
        .stat-card .change.negative {
            color: #dc3545;
        }
        .table-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }
        .table td, .table th {
            padding: 12px 15px;
            vertical-align: middle;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 13px;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
      <a href="adminpanel.php" class="btn btn-secondary back-button">
    <i class="fas fa-arrow-left"></i> Back to Dashboard
</a>
    <h2>User Management</h2>
    
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card card-statistic">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <h3 class="card-value"><?php echo $stats['total_users']; ?></h3>
                        <span class="card-change positive">+<?php echo $stats['new_users_today']; ?> today</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-statistic">
                    <div class="card-body">
                        <h5 class="card-title">Active Users</h5>
                        <h3 class="card-value"><?php echo $stats['total_users']; ?></h3>
                        <span class="card-change positive">+0%</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-statistic">
                    <div class="card-body">
                        <h5 class="card-title">New Signups</h5>
                        <h3 class="card-value"><?php echo $stats['new_users_today']; ?></h3>
                        <span class="card-change positive">+0%</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-statistic">
                    <div class="card-body">
                        <h5 class="card-title">User Activity</h5>
                        <h3 class="card-value">100%</h3>
                        <span class="card-change positive">+0%</span>
                    </div>
                </div>
            </div>
        </div>
    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="usersTableBody">
                <?php foreach ($users as $user): ?>
                <tr id="userRow-<?= htmlspecialchars($user['user_id']) ?>">
                    <td><?= htmlspecialchars($user['user_id']) ?></td>
                    <td class="user-first-name"><?= htmlspecialchars($user['first_name']) ?></td>
                    <td class="user-last-name"><?= htmlspecialchars($user['last_name']) ?></td>
                    <td class="user-email"><?= htmlspecialchars($user['email']) ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-user" data-id="<?= htmlspecialchars($user['user_id']) ?>">Edit</button>
                        <button class="btn btn-danger btn-sm delete-user" data-id="<?= htmlspecialchars($user['user_id']) ?>">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Edit Form -->
<div id="editFormContainer" class="card p-3" style="display:none; max-width:700px;">
    <h4>Edit User</h4>
    <form id="editUserForm">
        <input type="hidden" name="user_id">
        <input type="hidden" name="save_user" value="1">
        <div class="mb-2">
            <label class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" id="cancelEdit" class="btn btn-secondary">Cancel</button>
        </div>
    </form>
</div>

<script>
$(function () {
    const API_URL = window.location.pathname; // use current file automatically

    // Edit - Load Data
    $(document).on('click', '.edit-user', function(){
        const id = $(this).data('id');
        $.ajax({
            url: API_URL,
            method: 'GET',
            data: { edit: id },
            dataType: 'json'
        }).done(function(user){
            if (user) {
                $('#editFormContainer').show();
                $('[name="user_id"]').val(user.user_id);
                $('[name="first_name"]').val(user.first_name);
                $('[name="last_name"]').val(user.last_name);
                $('[name="email"]').val(user.email);
            } else {
                alert('User not found.');
            }
        }).fail(function(xhr){
            console.error('Edit load failed:', xhr.responseText);
            alert('Failed to load user. Check console for details.');
        });
    });

    // Cancel Edit
    $('#cancelEdit').on('click', function(){
        $('#editFormContainer').hide();
        $('#editUserForm')[0].reset();
    });

    // Save Changes
    $('#editUserForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: API_URL,
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json'
        }).done(function(resp){
            if (resp.success) {
                const id = $('[name="user_id"]').val();
                $('#userRow-' + id + ' .user-first-name').text($('[name="first_name"]').val());
                $('#userRow-' + id + ' .user-last-name').text($('[name="last_name"]').val());
                $('#userRow-' + id + ' .user-email').text($('[name="email"]').val());
                $('#editFormContainer').hide();
            } else {
                alert(resp.error || 'Update failed.');
            }
        }).fail(function(xhr){
            console.error('Save failed:', xhr.responseText);
            alert('Save failed. Check console for details.');
        });
    });

    // Delete
    $(document).on('click', '.delete-user', function(){
        if (!confirm('Delete this user?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: API_URL,
            method: 'GET',
            data: { delete: id },
            dataType: 'json'
        }).done(function(resp){
            if (resp.success) {
                $('#userRow-' + id).remove();
            } else {
                alert(resp.error || 'Delete failed.');
            }
        }).fail(function(xhr){
            console.error('Delete failed:', xhr.responseText);
            alert('Delete failed. Check console for details.');
        });
    });
});
</script>

</body>
</html>