<?php
include '../includes/dbconnect.php';
include '../classes/adminClass.php';

$admin = new Admin();

if(isset($_POST['add'])){
    $name = $_POST['herb_name'];
    $scientific = $_POST['scientific_name'];
    $desc = $_POST['description'];
    $image = "";
    
    if($_FILES['image']['name'] != ""){
        // Store only the filename in database, not the full path
        $image = $_FILES['image']['name'];
        $upload_path = '../uploads/herbs/' . $image;
        
        // Create directory if it doesn't exist
        if (!file_exists('../uploads/herbs/')) {
            mkdir('../uploads/herbs/', 0777, true);
        }
        
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);
    }
    
    $admin->addNewHerb($conn, $name, $scientific, $desc, $image);
    echo "<script>alert('Herb added!'); window.location='dictionary_manage.php';</script>";
}

if(isset($_GET['delete'])){
    $id = intval($_GET['delete']); // Use intval for security
    
    // Get image filename before deleting record
    $img_query = $conn->query("SELECT image FROM herb WHERE herb_id = $id");
    if($img_row = $img_query->fetch_assoc()){
        $image_file = '../uploads/herbs/' . $img_row['image'];
        if(file_exists($image_file) && !empty($img_row['image'])){
            unlink($image_file); // Delete the image file
        }
    }
    
    $result = $conn->query("DELETE FROM herb WHERE herb_id = $id");
    if($result){
        echo "<script>alert('Herb deleted!'); window.location='dictionary_manage.php';</script>";
    }
}

if(isset($_POST['update'])){
    $id = intval($_POST['herb_id']);
    $name = $_POST['herb_name'];
    $scientific = $_POST['scientific_name'];
    $desc = $_POST['description'];
    $image = $_POST['old_image']; // Keep old image by default
    
    if($_FILES['image']['name'] != ""){
        // Delete old image if exists
        if(!empty($_POST['old_image'])){
            $old_image_path = '../uploads/herbs/' . $_POST['old_image'];
            if(file_exists($old_image_path)){
                unlink($old_image_path);
            }
        }
        
        // Upload new image
        $image = $_FILES['image']['name'];
        $upload_path = '../uploads/herbs/' . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);
    }
    
    // Use prepared statement for security
    $stmt = $conn->prepare("UPDATE herb SET name=?, scientific_name=?, uses=?, image=? WHERE herb_id=?");
    $stmt->bind_param("ssssi", $name, $scientific, $desc, $image, $id);
    $result = $stmt->execute();
    
    if($result){
        echo "<script>alert('Herb updated!'); window.location='dictionary_manage.php';</script>";
    }
}

$herbs = $conn->query("SELECT * FROM herb ORDER BY name");
$edit_herb = null;
if(isset($_GET['edit'])){
    $edit_id = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM herb WHERE herb_id = $edit_id");
    $edit_herb = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Herb Dictionary Management</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
<style>
.container { background: white; padding: 25px; margin-top: 20px; border-radius: 8px; }
.form-box { border: 2px solid #28a745; padding: 20px; margin-bottom: 25px; border-radius: 5px; background-color: #f8fff8; }
.herb-image { border: 1px solid #ddd; border-radius: 5px; object-fit: cover; }
.dictionary-title { color: #28a745; border-bottom: 2px solid #28a745; padding-bottom: 10px; }
.no-image { 
    width: 50px; 
    height: 50px; 
    background: #f8f9fa; 
    border: 1px dashed #dee2e6; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    border-radius: 5px; 
    font-size: 12px; 
    color: #6c757d; 
}
</style>
</head>

<body>
<?php include './admin_header.php'; ?>

<div class="container">
    <a href="dashbord.php" class="btn btn-success mb-3">Back</a>
    <h2 class="dictionary-title">Herb Dictionary Management</h2>

    <div class="form-box">
        <h4><?php echo $edit_herb ? 'Edit Herb' : 'Add New Herb'; ?></h4>
        <form method="POST" enctype="multipart/form-data">
            <?php if($edit_herb){ ?>
                <input type="hidden" name="herb_id" value="<?php echo $edit_herb['herb_id']; ?>">
                <input type="hidden" name="old_image" value="<?php echo $edit_herb['image']; ?>">
            <?php } ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Herb Name</label>
                    <input type="text" name="herb_name" class="form-control" value="<?php if($edit_herb) echo htmlspecialchars($edit_herb['name']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Scientific Name</label>
                    <input type="text" name="scientific_name" class="form-control" value="<?php if($edit_herb) echo htmlspecialchars($edit_herb['scientific_name']); ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label>Uses & Description</label>
                <textarea name="description" class="form-control" rows="4" required><?php if($edit_herb) echo htmlspecialchars($edit_herb['uses']); ?></textarea>
            </div>
            <div class="mb-3">
                <label>Herb Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <?php if($edit_herb && !empty($edit_herb['image'])){ ?>
                <div class="mt-2">
                    <img src="../uploads/herbs/<?php echo($edit_herb['image']); ?>" 
                         width="80" height="80" class="herb-image" 
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div class="no-image" style="display:none; width:80px; height:80px;">No Image</div>
                    <br><small class="text-muted">Current image</small>
                </div>
                <?php } ?>
            </div>
            <div class="mb-3">
                <?php if($edit_herb){ ?>
                    <button type="submit" name="update" class="btn btn-warning">Update Herb</button>
                    <a href="dictionary_manage.php" class="btn btn-secondary">Cancel</a>
                <?php }else{ ?>
                    <button type="submit" name="add" class="btn btn-success">Add</button>
                <?php } ?>
            </div>
        </form>
    </div>

    <h3 class="mb-3 text-success">Herb List</h3>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-success">
                <tr>
                    <th>ID</th>
                    <th>Herb Name</th>
                    <th>Scientific Name</th>
                    <th>Image</th>
                    <th>Uses & Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($herb = $herbs->fetch_assoc()){ ?>
                <tr>
                    <td><?php echo $herb['herb_id']; ?></td>
                    <td><strong><?php echo htmlspecialchars($herb['name']); ?></strong></td>
                    <td><em><?php echo htmlspecialchars($herb['scientific_name']); ?></em></td>
                    <td>
                        <?php if(!empty($herb['image'])){ ?>
                            <img src="../uploads/herbs/<?php echo htmlspecialchars($herb['image']); ?>" 
                                 width="50" height="50" class="herb-image rounded border border-success"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="no-image" style="display:none;">No Image</div>
                        <?php } else { ?>
                            <div class="no-image">No Image</div>
                        <?php } ?>
                    </td>
                    <td><?php echo htmlspecialchars($herb['uses']); ?></td>
                    <td>
                        <a href="?edit=<?php echo $herb['herb_id']; ?>" class="btn btn-sm btn-warning mb-1">Edit</a>
                        <a href="?delete=<?php echo $herb['herb_id']; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Are you sure you want to delete this herb?')">Delete</a>
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