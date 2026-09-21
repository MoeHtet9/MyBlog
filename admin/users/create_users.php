<?php 

    session_start();

    if($_SESSION['user_role'] == 'admin'){
    
    include "../dbconnect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        $sql = "INSERT INTO users (name,email,password,role) VALUES(:name,:email,:password,:role)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':role',$role);
        $stmt->execute();

        header('location: users.php');

    }

    include '../layouts/nav_sidebar.php';
    
?>

    <div class="container-fluid px-4">
            
            <div class="mt-3">
                <h3 class="mt-4 d-inline">New user</h3>
                <a href="users.php" class="btn btn-danger float-end">Cancel</a>
            </div>
            
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            </ol>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    New User
                </div>
                <div class="card-body">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="role" aria-label="Default select example">
                                <option value="author">Author</option>
                                <option value="admin">Admin</option>
                            </select>
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