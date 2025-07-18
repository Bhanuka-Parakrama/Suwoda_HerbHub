<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" 
     integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
   
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
    <div class="container">
        <div class="form-section">
            <a href="dashbord.php" class="btn btn-primary mb-3">
                <i class="bi bi-arrow-left-circle me-1"></i> Back to Dashboard
            </a>
            <h2 class="mb-4 text-primary"><i class="bi bi-box-seam me-2"></i>Product Management</h2>

            <form id="productForm">
                <input type="hidden" id="editIndex">

                <div class="mb-3">
                    <label for="productName" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="productName" placeholder="Enter product name" required>
                </div>

                <div class="mb-3">
                    <label for="productCategory" class="form-label">Category</label>
                    <select class="form-select" id="productCategory" required>
                        <option value="">Select Category</option>
                        <option>Herbal Oils</option>
                        <option>Herbal Teas</option>
                        <option>Herbal Powders</option>
                        <option>Capsules</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="productPrice" class="form-label">Price (LKR)</label>
                    <input type="number" class="form-control" id="productPrice" min="0" step="0.01" placeholder="Enter price" required>
                </div>

                <div class="mb-3">
                    <label for="productQuantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="productQuantity" min="0" step="1" placeholder="Enter quantity" required>
                </div>

                <div class="mb-3">
                    <label for="productImage" class="form-label">Product Image</label>
                    <input class="form-control" type="file" id="productImage" accept="image/*">
                </div>

                <div class="mb-3">
                    <label for="productDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="productDescription" rows="3" placeholder="Enter product description"></textarea>
                </div>

                <div class="text-center">
                <button type="submit" class="btn btn-primary" id="saveBtn">Save Product</button>
                 </div>
                <button type="button" class="btn btn-secondary w-100 mt-2 d-none" id="cancelEditBtn">Cancel Edit</button>
            </form>
        </div>

        <div class="table-section">
            <h4 class="mb-3">Product List</h4>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price (LKR)</th>
                            <th>Quantity</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th style="width:120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        <!-- Products will be shown here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
      integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script src="../assets/index.js"></script>
</body>
</html>
