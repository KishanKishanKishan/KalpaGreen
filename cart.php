<?php
session_start();
include("config/db.php");
include("includes/header.php");

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product
if (isset($_POST['product_id'])) {
    $_SESSION['cart'][] = $_POST['product_id'];
}

// Remove product
if (isset($_GET['remove'])) {
    $key = $_GET['remove'];

    if (isset($_SESSION['cart'][$key])) {
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    header("Location: cart.php");
    exit();
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">🛒 Shopping Cart</h2>

<?php
if (count($_SESSION['cart']) == 0) {

    echo "<h4 class='text-center'>Your cart is empty.</h4>";

} else {

    $total = 0;

    foreach ($_SESSION['cart'] as $key => $id) {

        $query = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
        $row = mysqli_fetch_assoc($query);

        $total += $row['price'];
?>

<div class="card mb-3">
    <div class="row g-0">

        <div class="col-md-3">
            <img src="assets/images/<?php echo $row['image']; ?>" class="img-fluid rounded-start">
        </div>

        <div class="col-md-9">
            <div class="card-body">

                <h4><?php echo $row['product_name']; ?></h4>

                <p><?php echo $row['description']; ?></p>

                <h3 class="text-success">₹<?php echo $row['price']; ?></h3>

                <a href="cart.php?remove=<?php echo $key; ?>" class="btn btn-danger">
                    Remove
                </a>

            </div>
        </div>

    </div>
</div>

<?php
    }
?>

<h2 class="text-end">
    Total : ₹<?php echo $total; ?>
</h2>

<div class="text-end">
    <a href="checkout.php" class="btn btn-success btn-lg">
        Proceed to Checkout
    </a>
</div>

<?php } ?>

</div>

<?php include("includes/footer.php"); ?>