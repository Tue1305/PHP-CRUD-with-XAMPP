<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-3">
    
<?php
require 'db.php';

function getAllProducts() {
    global $conn;
    $result = $conn->query("SELECT * FROM products ORDER BY category, name");
    return $result;
}

$products = getAllProducts();


while ($row = $products->fetch_assoc()) {
    $name     = $row['name'];
    $category = $row['category'];
    $price    = $row['price'];
    $img = !empty($row['image']) ? $row['image'] : 'images/no-image.png'; 

?>

<div class="card mb-2 shadow-sm">
  <div class="card-body">

    <div class="row align-items-center">

      <!-- IMAGE -->
      <div class="col-3">
        <img src="<?= $img ?>"
             class="img-fluid rounded"
             style="height:150px; width:100%; object-fit:cover;">
      </div>

      <!-- INFO -->
      <div class="col-6">
        <h6 class="mb-1"><?= htmlspecialchars($name) ?></h6>
        <small class="text-muted"><?= htmlspecialchars($category) ?></small>
      </div>

      <!-- PRICE + BUTTON -->
      <div class="col-3 text-end">
        <div class="fw-bold text-success">
          $<?= number_format($price, 2) ?>
        </div>

        <form method="POST" action="add_to_cart.php">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <button class="btn btn-sm btn-primary mt-1">
            Add
          </button>
        </form>

      </div>

    </div>

  </div>
</div>
<?php
} // end while
?>