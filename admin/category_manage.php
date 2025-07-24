<?php
session_start();
include '../includes/dbconnect.php';
include '../classes/AdminClass.php';

$admin = new Admin();

if (isset($_POST['addCategory'])) {
    $categoryName = $_POST['categoryName'];
    $imagePath = "";

    if (!empty($_FILES['categoryImage']['name'])) {
        $uploadDir = '../uploads/categories/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $imageName = time() . '_' . $_FILES['categoryImage']['name'];
        $imagePath = $uploadDir . $imageName;
        move_uploaded_file($_FILES['categoryImage']['tmp_name'], $imagePath);
    }

    $sql = "INSERT INTO category (name, image) VALUES ('$categoryName', '$imagePath')";
    if ($conn->query($sql)) {
        header("Location: category_manage.php");
        exit();
    }
}

if (isset($_GET['delete'])) {
    $categoryId = $_GET['delete'];
    $admin->removeCategory($conn, $categoryId);
    header("Location: category_manage.php");
    exit();
}

if (isset($_POST['updateCategory'])) {
    $categoryId = $_POST['categoryId'];
    $categoryName = $_POST['categoryName'];
    $imagePath = $_POST['existingImage'];

    if (!empty($_FILES['categoryImage']['name'])) {
        $uploadDir = '../uploads/categories/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $imageName = time() . '_' . $_FILES['categoryImage']['name'];
        $imagePath = $uploadDir . $imageName;
        move_uploaded_file($_FILES['categoryImage']['tmp_name'], $imagePath);
    }

    $sql = "UPDATE category SET name = '$categoryName', image = '$imagePath' WHERE category_id = $categoryId";
    if ($conn->query($sql)) {
        header("Location: category_manage.php");
        exit();
    }
}

$isEditing = false;
$editData = null;

if (isset($_GET['edit'])) {
    $isEditing = true;
    $editId = $_GET['edit'];
    $sql = "SELECT * FROM category WHERE category_id = $editId";
    $result = $conn->query($sql);
    $editData = $result->fetch_assoc();
}

$categories = $admin->getCategories($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Category Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; }
        .container { background: white; padding: 25px; margin-top: 20px; border-radius: 8px; }
        .form-box { border: 2px solid #28a745; padding: 20px; margin-bottom: 25px; border-radius: 5px; background-color: #f8fff8; }
        .category-image { width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd; border-radius: 5px; }
        .preview-image { width: 100px; height: 100px; object-fit: cover; margin-top: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .category-title { color: #28a745; border-bottom: 2px solid #28a745; padding-bottom: 10px; }
    </style>
</head>

<body>
   <?php include './admin_header.php'; ?>

    <div class="container">
        <a href="dashbord.php" class="btn btn-success mb-3">Back</a>
        <h2 class="category-title">Category Management</h2>

        <div class="form-box">
            <h4><?php echo $isEditing ? 'Edit Category' : 'Add New Category'; ?></h4>
            <form method="POST" enctype="multipart/form-data">
                <?php if ($isEditing) { ?>
                    <input type="hidden" name="categoryId" value="<?php echo $editData['category_id']; ?>">
                    <input type="hidden" name="existingImage" value="<?php echo $editData['image']; ?>">
                <?php } ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Category Name</label>
                        <input type="text" class="form-control" name="categoryName" required
                               value="<?php echo $isEditing ? $editData['name'] : ''; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Category Image</label>
                        <input type="file" class="form-control" name="categoryImage">
                        <?php if ($isEditing && $editData['image']) { ?>
                            <img src="<?php echo $editData['image']; ?>" class="preview-image">
                            <br><small class="text-muted">Current image</small>
                        <?php } ?>
                    </div>
                </div>

                <div class="mb-3">
                    <?php if ($isEditing) { ?>
                        <button type="submit" name="updateCategory" class="btn btn-warning">Update</button>
                        <a href="category_manage.php" class="btn btn-secondary ms-2">Cancel</a>
                    <?php } else { ?>
                        <button type="submit" name="addCategory" class="btn btn-success">Add</button>
                    <?php } ?>
                </div>
            </form>
        </div>

        <h3 class="mb-3 text-success">Categories</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($category = $categories->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $category['category_id']; ?></td>
                            <td><strong><?php echo $category['name']; ?></strong></td>
                            <td>
                                <?php if (!empty($category['image'])) { ?>
                                    <img src="<?php echo $category['image']; ?>" class="category-image">
                                <?php } else { ?>
                                    <span class="text-muted">No Image</span>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="?edit=<?php echo $category['category_id']; ?>" class="btn btn-sm btn-warning me-1">Edit</a>
                                <a href="?delete=<?php echo $category['category_id']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <?php include './admin_footer.php'; ?>
</body>
</html>