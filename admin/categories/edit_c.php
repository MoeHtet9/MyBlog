<?php 

    session_start();

    if($_SESSION['user_role'] == 'admin'){
    
    include "../dbconnect.php";

    $c_id = $_GET['c_id'];
    // var_dump ($c_id);
    $sql = "SELECT * FROM categories WHERE id = :c_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':c_id',$c_id);
    $stmt->execute();
    $c_name =$stmt->fetch();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $name = $_POST['name'];
        // var_dump ($name);

        $sql = "UPDATE categories SET name = :name WHERE id = :c_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':c_id',$c_id);
        $stmt->bindParam(':name',$name);
        $stmt->execute();
        
        header('location: categories.php');

    }

    include '../layouts/nav_sidebar.php';
    
?>

    <div class="container-fluid px-4">
            
            <div class="mt-3">
                <h3 class="mt-4 d-inline">Posts</h3>
                <a href="categories.php" class="btn btn-danger float-end">Cancel</a>
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
                            <label for="title" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $c_name['name'] ?>">
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

    }
?>