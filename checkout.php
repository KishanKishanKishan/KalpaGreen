<?php
session_start();
include("config/db.php");
include("includes/header.php");

$total = 0;

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

foreach ($_SESSION['cart'] as $id) {
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $total += $row['price'];
    }
}

if (isset($_POST['place_order'])) {

    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $mobile  = mysqli_real_escape_string($conn, $_POST['mobile']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $sql = "INSERT INTO orders (customer_name, mobile, email, address, total)
            VALUES ('$name', '$mobile', '$email', '$address', '$total')";

    if (mysqli_query($conn, $sql)) {

        $_SESSION['cart'] = [];

        echo "<script>
                alert('Order Placed Successfully!');
                window.location='index.php';
              </script>";
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<div class="container mt-5">

<h2 class="text-center mb-4">Checkout</h2>

<div class="row">

<div class="col-md-7">

<form method="POST">

<div class="mb-3">
<label>Full Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label>Mobile Number</label>
<input type="text" name="mobile" class="form-control" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control">
</div>

<div class="mb-3">
<label>Delivery Address</label>
<textarea name="address" class="form-control" rows="4" required></textarea>
</div>

<button type="submit" name="place_order" class="btn btn-success btn-lg">
Place Order
</button>

</form>

</div>

<div class="col-md-5">

<div class="card shadow">

<div class="card-header bg-success text-white">
<h4>Order Summary</h4>
</div>

<div class="card-body">

<h5>Total Amount</h5>

<h2 class="text-success">
₹<?php echo number_format($total, 2); ?>
</h2>

</div>

</div>

</div>

</div>

</div>

<?php include("includes/footer.php"); ?>