<?php
include '../includes/dbconnect.php';
include '../classes/adminClass.php';

$admin = new Admin();

if (isset($_POST['add'])) {
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $qty = $_POST['quantity'];
    $desc = $_POST['description'];
    $image = "";
    if ($_FILES['image']['name'] != "") {
        $image = '../uploads/products/' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }
    $admin->addNewProduct($conn, $name, $category, $price, $qty, $image, $desc);
    header("Location: product_manage.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $admin->removeProduct($conn, $id);
    header("Location: product_manage.php");
    exit();
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $qty = $_POST['quantity'];
    $desc = $_POST['description'];
    $image = $_POST['old_image'];
    if ($_FILES['image']['name'] != "") {
        $image = '../uploads/products/' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }
    $admin->editProduct($conn, $id, $name, $category, $price, $qty, $image, $desc);
    header("Location: product_manage.php");
    exit();
}

$products = $admin->getAllProducts($conn);
$categories = $admin->getCategories($conn);

$edit_product = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM product WHERE product_id = $edit_id");
    $edit_product = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .product-title { 
            color: #28a745; 
            border-bottom: 2px solid #28a745; 
            padding-bottom: 10px; 
            margin-bottom: 1rem;
        }
        .form-box { 
            border: 2px solid #28a745; 
            padding: 1.25rem; 
            margin-bottom: 2rem; 
            border-radius: .5rem; 
            background: #f8fff8; 
        }
        .product-image { 
            width: 80px; 
            height: 80px; 
            object-fit: cover; 
            border-radius: .3rem;
            border: 1px solid #28a745;
        }
        .preview-image { 
            width: 100px; 
            height: 100px; 
            object-fit: cover; 
            margin-top: 10px; 
            border-radius: .3rem;
            border: 1px solid #28a745;
        }
        .btn-back {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-back:hover {
            background-color: #218838;
        }
        .table-success, .table-info {
            background-color: #e9fbe7;
        }
        .text-success, .text-primary {
            color: #28a745 !important;
        }
        .border-success, .border-primary {
            border-color: #28a745 !important;
        }
    </style>
</head>

<body>
    <?php include './admin_header.php'; ?>

    <div class="container">
        <div class="main-container">
            <div class="mb-4"></div>
            <a href="dashbord.php" class="btn btn-success text-white mb-2">Back</a>
            <h2 class="product-title">Product Management</h2>

            <div class="form-box">
                <h4><?php echo $edit_product ? 'Edit Product' : 'Add New Product'; ?></h4>
                <form method="POST" enctype="multipart/form-data">
                    <?php if ($edit_product) { ?>
                        <input type="hidden" name="id" value="<?php echo $edit_product['product_id']; ?>">
                        <input type="hidden" name="old_image" value="<?php echo $edit_product['image']; ?>">
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="product_name" required
                                   value="<?php echo $edit_product ? $edit_product['product_name'] : ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="">Select</option>
                                <?php while ($cat = $categories->fetch_assoc()) { ?>
                                    <option value="<?php echo $cat['name']; ?>" <?php if ($edit_product && $edit_product['category_id'] == $cat['category_id']) echo 'selected'; ?>>
                                        <?php echo $cat['name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" required
                                   value="<?php echo $edit_product ? $edit_product['price'] : ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" required
                                   value="<?php echo $edit_product ? $edit_product['quantity'] : ''; ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <?php if ($edit_product && $edit_product['image']) { ?>
                            <img src="<?php echo $edit_product['image']; ?>" class="preview-image mt-2">
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description"><?php echo $edit_product ? $edit_product['description'] : ''; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <?php if ($edit_product) { ?>
                            <button type="submit" name="update" class="btn btn-warning">Update</button>
                            <a href="product_manage.php" class="btn btn-secondary ms-2">Cancel</a>
                        <?php } else { ?>
                            <button type="submit" name="add" class="btn btn-success">Add</button>
                        <?php } ?>
                    </div>
                </form>
            </div>

            <h3 class="mb-3 text-success">All Products</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $products->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['product_id']; ?></td>
                                <td><?php echo $row['product_name']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['price']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td>
                                    <?php if ($row['image']) { ?>
                                        <img src="<?php echo $row['image']; ?>" class="product-image border-primary">
                                    <?php } else { ?>
                                        <span class="text-muted">No image</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="?edit=<?php echo $row['product_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="?delete=<?php echo $row['product_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

<?php include './admin_footer.php'; ?>
</body>
</html>