<?php 
    
    include "../dbconnect.php";

    $id = $_GET['id'];
    // echo $id;
    // die();

    $sql = "SELECT * FROM posts WHERE posts.id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $post = $stmt->fetch();
    // var_dump($post);
    // die();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category_id = $_POST['category_id'];
        $user_id = 1 ;

        $imageArray = $_FILES['image'];
        // var_dump($imageArray);
        // die();
        
        if(isset($imageArray) && $imageArray['size'] > 0) {
            $dir = 'images/';
            $imageDir = $dir.$imageArray['name'];
            $image = $dir.$imageArray['name'];  // DATABASE SAVE
            $tmpName = $imageArray['tmp_name'];
            move_uploaded_file($tmpName, $imageDir); // FOLDER SAVE
        }else{
            $image = $_POST['old_image'];
        }

        $sql = "UPDATE posts SET title = :title, image  = :image, description = :description, category_id = :category_id, user_id = :user_id WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id',$id);
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
                <li class="breadcrumb-item active">Post Edit</li>

            </ol>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Edit Posts
                </div>
                <div class="card-body">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= $post['title'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="category_id">Categories</label>
                            <select class="form-select" id="category_id" name="category_id" aria-label="Default select example">
                                <option selected>Choose....</option>
                                
                                    <?php 
                                        foreach($categories as $category){
                                    ?>
                                        <option value="<?= $category['id'] ?>" <?= ($post['category_id'] == $category['id']) ? "selected" :''; ?> > <?= $category['name'] ?> </option>
                                    <?php 
                                        } 
                                    ?>

                            </select>
                        </div>
                        <div class="mb-3">

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="image-tab" data-bs-toggle="tab" data-bs-target="#image-tab-pane" type="button" role="tab" aria-controls="image-tab-pane" aria-selected="true">Image</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="new-image-tab" data-bs-toggle="tab" data-bs-target="#new-image-tab-pane" type="button" role="tab" aria-controls="new-image-tab-pane" aria-selected="false">New Image</button>
                                </li>
                            </ul>
                            <br>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="image-tab-pane" role="tabpanel" aria-labelledby="image-tab" tabindex="0">
                                    <img src="<?= $post['image'] ?>" alt="" width="50px" height="50px">
                                    <input type="hidden" id="" name="old_image" value="<?= $post['image'] ?>">
                                </div>
                                <div class="tab-pane fade" id="new-image-tab-pane" role="tabpanel" aria-labelledby="new-image-tab" tabindex="0">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description"><?= $post['description']?></textarea>
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
?>