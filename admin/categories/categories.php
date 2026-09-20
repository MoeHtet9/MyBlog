<?php

    include "../dbconnect.php";

    $sql = "SELECT * FROM categories ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();
    // var_dump($categories);

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $id = $_POST['id'];

        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();

        header('location:categories.php');

    }

    include "../layouts/nav_sidebar.php";

?>

    <main>
        <div class="container-fluid px-4">
            <div class="mt-3">
                <h1 class="mt-4 d-inline">Categories</h1>
                <a href="create_categories.php" class="btn btn-primary float-end">Create Post</a>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Categories
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            
                                foreach($categories as $category) {

                            ?>

                            <tr>
                                <th><?= $category['name'] ?></th>
                                <th>
                                    <a href="edit_c.php?c_id=<?= $category['id'] ?>" type="button" class="btn btn-outline-warning mx-1">Edit</a>
                                    <button type="button" class="btn btn-outline-danger delete" data-id="<?= $category['id'] ?>">Delete</button>
                                </th>
                            </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header bg-danger text-light">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Modal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3>Are you sure delete</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <input type="hidden" name="id" id="p-id">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function() {

            $('tbody').on('click','.delete',function(){
                // alert("HELLO")
                let id = $(this).data('id');
                // console.log(id);
                $('#p-id').val(id);
                $('#deleteModal').modal('show');
            })
          
        })

    </script>
                
<?php

    include "../layouts/footer.php";

?>