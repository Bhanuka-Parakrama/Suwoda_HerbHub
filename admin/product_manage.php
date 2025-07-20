<?php
require_once '../includes/dbconnect.php';
require_once '../classes/adminClass.php';

$productObj = new Admin();

// Add product
if (isset($_POST['add'])) {
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];

    $imagePath = "";
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = '../uploads/products/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    $productObj->addProduct($conn, $name, $category, $price, $quantity, $imagePath, $description);
    header("Location: product_manage.php");
    exit();
}

// Delete product
if (isset($_GET['delete'])) {
    $productObj->deleteProduct($conn, $_GET['delete']);
    header("Location: product_manage.php");
    exit;
}

// Fetch products
$products = Admin::getProducts($conn);

// Fetch categories
$categories = Admin::getCategories($conn);

// Edit product
$editProduct = null;
if (isset($_GET['edit'])) {
    $editProduct = $productObj->getProductById($conn, $_GET['edit']);
    if (!$editProduct) {
        header("Location: product_manage.php");
        exit;
    }
}

// Update product
if (isset($_POST['update'])) {
    $id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $imagePath = $_POST['existing_image']; // Keep existing image by default

    // Handle new image upload
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = '../images/uploads/products';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    $productObj->updateProduct($conn, $id, $name, $category, $price, $quantity, $imagePath, $description);
    header("Location: product_manage.php");
    exit();
}

// Get edit data
$editProduct = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $editResult = $conn->query("SELECT * FROM product WHERE product_id = $editId");
    $editProduct = $editResult->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
<style>
    .form-section {
        border: 2px solid #0d6efd;
        border-radius: 15px;
        padding: 30px;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(13, 110, 253, 0.1);
        margin-bottom: 30px;
    }
    </style>

</head>
<body>
  <div class="container mt-4">
        <div class="form-section">
            <a href="dashbord.php" class="btn btn-primary mb-3">
                <i class="bi bi-arrow-left-circle me-1"></i> Back to Dashboard
            </a>
            <h2 class="mb-4 text-primary"><i class="bi bi-journal-text me-2"></i>Product Management</h2>
    <form method="post" enctype="multipart/form-data" class="border p-4 mb-4">
        <?php if ($editProduct): ?>
            <input type="hidden" name="product_id" value="<?= $editProduct['product_id'] ?>">
            <input type="hidden" name="existing_image" value="<?= $editProduct['image'] ?>">
        <?php endif; ?>
        
        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="product_name" class="form-control" 
                   value="<?= $editProduct ? htmlspecialchars($editProduct['product_name']) : '' ?>" required>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <select name="category" class="form-control" required>
                <option value="">Select Category</option>
                <?php 
                $categories = $productObj->getAllCategories($conn);
                while ($row = $categories->fetch_assoc()) { ?>
                    <option value="<?= $row['name'] ?>" 
                            <?= ($editProduct && $editProduct['category_id'] == $row['category_id']) ? 'selected' : '' ?>>
                        <?= $row['name'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Price (LKR)</label>
            <input type="number" name="price" class="form-control" step="0.01" 
                   value="<?= $editProduct ? $editProduct['price'] : '' ?>" required>
        </div>
        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" 
                   value="<?= $editProduct ? $editProduct['quantity'] : '' ?>" required>
        </div>
        <div class="mb-3">
            <label>Product Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <?php if ($editProduct && $editProduct['image']): ?>
                <div class="mt-2">
                    <img src="<?= $editProduct['image'] ?>" width="100" height="100" style="object-fit: cover;" class="rounded border">
                    <br><small class="text-muted">Current image (upload new file to replace)</small>
                </div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"><?= $editProduct ? htmlspecialchars($editProduct['description']) : '' ?></textarea>
        </div>
        <div class="text-center">
            <button type="submit" name="<?= $editProduct ? 'update' : 'add' ?>" 
                    class="btn btn-<?= $editProduct ? 'warning' : 'primary' ?>">
                <?= $editProduct ? 'Update Product' : 'Add Product' ?>
            </button>
            <?php if ($editProduct): ?>
                <a href="product_manage.php" class="btn btn-secondary ms-2">Cancel</a>
            <?php endif; ?>
        </div>
    </form>
    </div>
    <!-- Product Table -->
    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Product _id</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price (LKR)</th>
                <th>Quantyy</th>
                <th>Image</th>
                <th>Description</th>
                <th style="width: 150px;">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($product = $products->fetch_assoc()) { ?>
            <tr>
                <td><?= $product['product_id'] ?></td>
                <td><?= $product['product_name'] ?></td>
                <td><?= $product['name'] ?></td>
                <td><?= $product['price'] ?></td>
                <td><?= $product['quantity'] ?></td>
                <td>
                    <?php if ($product['image']) { ?>
                        <img src="<?= str_replace('../', '../', $product['image']) ?>" width="50" height="50" style="object-fit: cover;" class="rounded">
                    <?php } else { ?>
                        <span class="text-muted">No Image</span>
                    <?php } ?>
                </td>
                <td><?= $product['description'] ?></td>
                <td>
                    <a href="?edit=<?= $product['product_id'] ?>" class="btn btn-sm btn-warning me-1">Edit</a>
                    <a href="?delete=<?= $product['product_id'] ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</body>
</html>
