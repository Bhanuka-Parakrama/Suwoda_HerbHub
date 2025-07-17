<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Blog Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
   
    
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
            <h2 class="mb-4 text-primary"><i class="bi bi-journal-text me-2"></i>Blog Management</h2>
            <form id="blogForm">
                <input type="hidden" id="editIndex" />
                <div class="mb-3">
                    <label for="blogTitle" class="form-label">Blog Title</label>
                    <input
                        type="text"
                        class="form-control"
                        id="blogTitle"
                        placeholder="Enter blog title"
                        required
                    />
                </div>
                <div class="mb-3">
                    <label for="blogImage" class="form-label">Blog Image</label>
                    <input
                        class="form-control"
                        type="file"
                        id="blogImage"
                        accept="image/*"
                    />
                </div>
                <div class="mb-3">
                    <label for="blogContent" class="form-label">Content</label>
                    <textarea
                        class="form-control"
                        id="blogContent"
                        rows="3"
                        placeholder="Enter blog content"
                    ></textarea>
                </div>
                <div class="text-center">
                <button type="submit" class="btn btn-primary" id="saveBtn">
                    Save Blog
                </button>
                </div>
                <button type="button" class="btn btn-secondary w-100 mt-2 d-none" id="cancelEditBtn">
                    Cancel Edit
                </button>
            </form>
        </div>

        <div class="table-section">
            <h4 class="mb-3">Blog List</h4>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Blog ID</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Content</th>
                            <th style="width:120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="blogTableBody">
                        <!-- Blogs will be shown here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/index.js"></script>
</body>
</html>
