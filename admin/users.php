<?php

    include "layouts/nav_sidebar.php";

    include "dbconnect.php";

    $sql = "SELECT * FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();
    // var_dump($users);

?>

    <main>
        <div class="container-fluid px-4">
            <div class="mt-3">
                <h1 class="mt-4 d-inline">Users</h1>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Users
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php

                                foreach($users as $user){
                            
                            ?>

                            <tr>
                                <th><?= $user['name'] ?></th>
                                <th><?= $user['email'] ?></th>
                                <th><?= $user['password'] ?></th>
                                <th>
                                    <button type="button" class="btn btn-outline-warning mx-1">Edit</button>
                                    <button type="button" class="btn btn-outline-danger">Delete</button>
                                </th>
                            </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
                
<?php

    include "layouts/footer.php";

?>