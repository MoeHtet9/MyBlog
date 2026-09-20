<?php

    include "layouts/navbar.php";

    include "dbconnect.php";

    if (isset($_GET['categoryID'])){

        $categoryID = $_GET['categoryID'];
        $sql = "SELECT * FROM posts WHERE posts.category_id = $categoryID ORDER BY id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        
    }else{

        $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 10000000000000 OFFSET 1";
        // $stmt = $conn->query($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        // var_dump($posts);

        $sql ="SELECT * FROM posts ORDER BY id DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $feature_post = $stmt->fetch(PDO::FETCH_ASSOC);
        // var_dump($feature_post);

    }

?>

        <!-- Page header with logo and tagline-->
        <header class="py-5 bg-light border-bottom mb-4">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">Welcome to Blog Home!</h1>
                    <p class="lead mb-0">A Bootstrap 5 starter layout for your next blog homepage</p>
                </div>
            </div>
        </header>
        <!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->
                <div class="col-lg-8">
                    <!-- Featured blog post-->
                    <?php
                    
                        if(isset($_GET['categoryID'])){

                        }else{
                    
                    ?>
                        <div class="card mb-4">
                            <a href="#!"><img class="card-img-top" src="admin/<?= $feature_post['image'] ?>" alt="..." width="350px" height="200px"/></a>
                            <div class="card-body">
                                <div class="small text-muted"><?= date('M d,Y',strtotime($feature_post['created_at'])) ?></div>
                                <h2 class="card-title"><?= $feature_post['title']?></h2>
                                <p class="card-text"><?= substr($feature_post['description'],0,180) ?>...</p>
                                <a class="btn btn-primary" href="detail.php?id=<?= $feature_post['id'] ?>">Read more →</a>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- Nested row for non-featured blog posts-->
                    <div class="row">
                        <?php
                            foreach($posts as $post){
                        ?>
                        <div class="col-lg-6">
                            <!-- Blog post-->
                            <div class="card mb-4">
                                <a href="#!"><img src="admin/<?= $post['image'] ?>" alt="..." width="300px" height="200px"/></a>
                                <div class="card-body">
                                    <div class="small text-muted"><?= date('M d,Y',strtotime($post['created_at'])) ?></div>
                                    <h2 class="card-title h4"><?= $post['title']?></h2>
                                    <p class="card-text"><?= substr($post['description'],0,180) ?>...</p>
                                    <a class="btn btn-primary" href="detail.php?id=<?= $post['id'] ?>">Read more →</a>
                                </div>
                            </div>
                        </div>
                        <?php 
                            } 
                        ?>
                    </div>
                </div>
        
<?php

    include "layouts/footer.php";

?>