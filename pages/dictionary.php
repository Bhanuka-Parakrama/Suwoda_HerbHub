
<?php
require_once '../includes/dbconnect.php';
require_once '../classes/adminClass.php';

$selected_letter = isset($_GET['letter']) ? $_GET['letter'] : '';

try {
    $db = new DbConnector();
    $conn = $db->getConnection();
    $admin = new Admin($conn);

    // Get all herbs,filter by letter
    $herbs = $admin->manageHerb('get'); //USE get action to GET HERBS FUNCTION
    if ($selected_letter) {
        $herbs = array_filter($herbs, function($herb) use ($selected_letter) {
            return strtoupper(substr($herb['name'], 0, 1)) === strtoupper($selected_letter);
        });
    }
} catch (Exception $e) {
    $herbs = [];
    error_log("Herb loading error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Herbal Dictionary - Suwoda HerbHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles.css">
    <style>
        .herb-card:hover { transform: scale(1.05); transition: 0.3s; }
        .letter-btn { width: 50px; height: 50px; margin: 2px; }
        .herb-image { 
            height: 180px; 
            object-fit: cover; 
            border-bottom: 1px solid #ddd; 
        }
        
    </style>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="container py-5 mt-5">
        <h2 class="text-center mb-5 text-success">Herbal Dictionary</h2>
        
        <!-- Letters -->
        <div class="row justify-content-center mb-4">
            <div class="col-12 text-center">
                <div id="letter-buttons" class="d-flex flex-wrap justify-content-center gap-2">
                    <?php
                    $alphabet = range('A', 'Z');
                    foreach ($alphabet as $letter) {
                        $active = ($selected_letter == $letter) ? 'selected-letter' : '';
                        echo '<a href="?letter='.$letter.'" class="btn btn-outline-success letter-btn rounded-circle shadow-sm '.$active.'">'.$letter.'</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <div class="row" id="herb-results">
            <?php if (!$selected_letter): ?>
                <div class="col-12">
                    <div class="text-center">
                        <div class="alert alert-warning d-inline-block">
                            <strong>Select an English letter to browse herbs</strong>
                        </div>
                    </div>
                </div>
            <?php elseif (empty($herbs)): ?>
                <div class="col-12">
                    <div class="text-center">
                        <div class="alert alert-danger w-25 mx-auto text-center" role="alert">
                            <strong>No herbs found for letter "<?php echo($selected_letter); ?>"</strong>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($herbs as $herb): ?>
                    <div class="col-md-4 mb-4 d-flex align-items-stretch">
                        <div class="card h-100 border-success shadow-sm">
                            <?php if (!empty($herb['image'])): ?>
                                <img src="../uploads/herbs/<?php echo $herb['image']; ?>" 
                                     class="card-img-top herb-image" 
                                     alt="<?php echo $herb['name']; ?>"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="no-image d-none">
                                    <span>No Image Available</span>
                                </div>
                            <?php else: ?>
                                <div class="d-flex justify-content-center align-items-center">
                                    <span>No Image Available</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-2"><?php echo $herb['name']; ?></h5>
                                <p class="card-text mb-1">
                                    <span class="fw-semibold">Scientific Name:</span>
                                    <em><?php echo $herb['scientific_name']; ?></em>
                                </p>
                                <p class="card-text mb-2">
                                    <span class="fw-semibold">Uses:</span><br>
                                    <?php echo nl2br($herb['uses']); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    
    <?php include '../includes/footer.php'; ?>
</body>
</html>