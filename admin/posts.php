<?php

    include "layouts/nav_sidebar.php";

    include "dbconnect.php";

    $sql = " SELECT posts.*, categories.name as category_name, users.name as user_name FROM posts INNER JOIN categories ON posts.category_id = categories.id INNER JOIN users ON posts.user_id = users.id ORDER BY posts.id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $posts = $stmt->fetchAll();
    // var_dump($posts);

?>

    <main>
        <div class="container-fluid px-4">
            <div class="mt-3">
                <h1 class="mt-4 d-inline">Posts</h1>
                <a href="create_post.php" class="btn btn-primary float-end">Create Post</a>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Posts</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Posts
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>User</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>User</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            
                                foreach($posts as $post) {

                            ?>

                            <tr>
                                <th><?= $post['id'] ?></th>
                                <th><?= $post['title'] ?></th>
                                <th><?= $post['user_name'] ?></th>
                                <th><img src="<?= $post['image'] ?>" alt="..." width="50px" height="50px"></th>
                                <th><?= $post['category_name'] ?></th>
                                <th>
                                    <!-- <button type="button" class="btn btn-outline-primary">Detail</button> -->
                                    <a href="edit.php?id=<?= $post['id']?>" type="button" class="btn btn-outline-warning mx-1">Edit</a>
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