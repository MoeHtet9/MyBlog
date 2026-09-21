<?php 

    session_start();
    if($_SESSION['user_id']){
    
    include "../dbconnect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category_id = $_POST['category_id'];
        $user_id = 3 ;

        $imageArray = $_FILES['image'];
        // var_dump($imageArray);
        // die();
        
        if(isset($imageArray) && $imageArray['size'] > 0) {
            $dir = 'images/';
            $imageDir = $dir.$imageArray['name'];
            $image = $dir.$imageArray['name'];  // DATABASE SAVE
            $tmpName = $imageArray['tmp_name'];
            move_uploaded_file($tmpName, $imageDir); // FOLDER SAVE
        }

        $sql = "INSERT INTO posts (title, image, description, category_id, user_id) VALUES(:title, :image, :description, :category_id, :user_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title',$title);
        $stmt->bindParam(':image',$image);
        $stmt->bindParam(':description',$description);
        $stmt->bindParam(':category_id',$category_id);
        $stmt->bindParam(':user_id',$user_id);
        $stmt->execute();

        header('location: posts.php');

    }

    include '../layouts/nav_sidebar.php';

    $sql = "SELECT * FROM categories";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();
    // var_dump($categories);
    
?>

    <div class="container-fluid px-4">
            
            <div class="mt-3">
                <h3 class="mt-4 d-inline">Posts</h3>
                <a href="posts.php" class="btn btn-danger float-end">Cancel</a>
            </div>
            
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="posts.php">Posts</a></li>
                <li class="breadcrumb-item active">Post Create</li>

            </ol>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Create Posts
                </div>
                <div class="card-body">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="category_id">Categories</label>
                            <select class="form-select" id="category_id" name="category_id" aria-label="Default select example">
                                <option selected>Choose....</option>
                                
                                    <?php 
                                        foreach($categories as $category){
                                    ?>
                                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                    <?php 
                                        } 
                                    ?>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description"></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<?php 
    include '../layouts/footer.php';

    }else{
        header('location: ../login.php');
    }
?>