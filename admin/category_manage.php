<?php
session_start();
require_once '../includes/dbconnect.php';
require_once '../classes/AdminClass.php';

$admin = new Admin();

// Handle Add Category
if (isset($_POST['addCategory'])) {
    $name = $_POST['categoryName'];
    $imagePath = "";

    if (!empty($_FILES['categoryImage']['name'])) {
        $uploadDir = '../uploads/categories/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $imageName = time() . '_' . basename($_FILES['categoryImage']['name']);
        $imagePath = $uploadDir . $imageName;
        move_uploaded_file($_FILES['categoryImage']['tmp_name'], $imagePath);
    }

    $query = "INSERT INTO category (name, image) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $name, $imagePath);
    $stmt->execute();
    header("Location: category_manage.php");
    exit();
}

// Handle Delete Category
if (isset($_GET['delete'])) {
    $categoryId = $_GET['delete'];
    $admin->deleteCategory($conn, $categoryId);
    header("Location: category_manage.php");
    exit();
}

// Handle Update Category
if (isset($_POST['updateCategory'])) {
    $id = $_POST['categoryId'];
    $name = $_POST['categoryName'];
    $imagePath = $_POST['existingImage']; // default

    if (!empty($_FILES['categoryImage']['name'])) {
        $uploadDir = '../uploads/categories/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $imageName = time() . '_' . basename($_FILES['categoryImage']['name']);
        $imagePath = $uploadDir . $imageName;
        move_uploaded_file($_FILES['categoryImage']['tmp_name'], $imagePath);
    }

    $query = "UPDATE category SET name = ?, image = ? WHERE category_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $name, $imagePath, $id);
    $stmt->execute();
    header("Location: category_manage.php");
    exit();
}

$categories = $admin->getAllCategories($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Category Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-primary">Category Management</h2>

    <!-- Add or Update Form -->
    <form method="POST" enctype="multipart/form-data" class="mb-5">
        <?php
        $edit = false;
        $editCategory = null;

        if (isset($_GET['edit'])) {
            $edit = true;
            $id = $_GET['edit'];
            $res = $conn->query("SELECT * FROM category WHERE category_id = $id");
            $editCategory = $res->fetch_assoc();
        }
        ?>
        <input type="hidden" name="categoryId" value="<?= $edit ? $editCategory['category_id'] : '' ?>">
        <input type="hidden" name="existingImage" value="<?= $edit ? $editCategory['image'] : '' ?>">

        <div class="mb-3">
            <label for="categoryName">Category Name</label>
            <input type="text" class="form-control" name="categoryName" required
                   value="<?= $edit ? htmlspecialchars($editCategory['name']) : '' ?>">
        </div>

        <div class="mb-3">
            <label for="categoryImage">Category Image</label>
            <input type="file" class="form-control" name="categoryImage">
            <?php if ($edit && $editCategory['image']): ?>
                <img src="<?= $editCategory['image'] ?>" width="100" class="mt-2">
            <?php endif; ?>
        </div>

        <button type="submit" name="<?= $edit ? 'updateCategory' : 'addCategory' ?>"
                class="btn btn-<?= $edit ? 'warning' : 'primary' ?>">
            <?= $edit ? 'Update Category' : 'Add Category' ?>
        </button>

        <?php if ($edit): ?>
            <a href="category_manage.php" class="btn btn-secondary">Cancel</a>
        <?php endif; ?>
    </form>

    <!-- Category Table -->
    <table class="table table-bordered">
        <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th style="width: 150px;">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $categories->fetch_assoc()): ?>
            <tr>
                <td><?= $row['category_id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td>
                    <?php if (!empty($row['image'])): ?>
                        <img src="<?= $row['image'] ?>" width="80">
                    <?php else: ?>
                        No Image
                    <?php endif; ?>
                </td>
                <td>
                    <a href="?edit=<?= $row['category_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="?delete=<?= $row['category_id'] ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Are you sure to delete this category?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
