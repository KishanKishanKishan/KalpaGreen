<?php include("includes/header.php"); ?>
<?php include("config/db.php"); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Our Products</h2>

    <div class="row">

    <?php

    $query = "SELECT * FROM products";
    $result = mysqli_query($conn,$query);

    while($row=mysqli_fetch_assoc($result))
    {

    ?>

    <div class="col-md-4 mb-4">

        <div class="card shadow h-100">

            <img src="assets/images/<?php echo $row['image']; ?>" class="card-img-top">

            <div class="card-body text-center">

                <h4><?php echo $row['product_name']; ?></h4>

                <p><?php echo $row['description']; ?></p>

                <h3 class="text-success">₹<?php echo $row['price']; ?></h3>

               <form action="cart.php" method="POST">
    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
    <button type="submit" class="btn btn-success">
        Add to Cart
    </button>
</form>

            </div>

        </div>

    </div>

    <?php
    }
    ?>

    </div>

</div>

<?php include("includes/footer.php"); ?>