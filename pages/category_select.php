<?php
// category_select.php
require_once '../classes/CategoryClass.php';
require_once '../classes/GuestUser.php';
require_once '../classes/RegisterUser.php';

session_start();
if (!RegisteredUser::isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$dbConnector = new DbConnector();
$conn = $dbConnector->getConnection();
$categories = Category::getAllCategories($conn);

//USE SAVE USER CATEGORIES FUNCTION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['category_ids']) && is_array($_POST['category_ids'])) {
        $selected = array_map('intval', $_POST['category_ids']);
        $registeredUser = new RegisteredUser();
        $registeredUser->saveUserCategories($user_id, $selected);
        header('Location: index.php');
        exit;
    } else {
        // User skipped selection
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Preferred Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center text-success mb-4">Select Your Preferred Categories</h2>
        <form method="POST" class="mb-4">
            <div class="row">
                <?php foreach ($categories as $category): ?>
                    <div class="col-md-4 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="category_ids[]" value="<?php echo $category['category_id']; ?>" id="cat_<?php echo $category['category_id']; ?>">
                            <label class="form-check-label" for="cat_<?php echo $category['category_id']; ?>">
                                <?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="d-flex justify-content-center gap-3 mt-4">
                <button type="submit" class="btn btn-success px-4">Save Selection</button>
                <button type="submit" name="skip" class="btn btn-outline-secondary px-4">Skip</button>
            </div>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
