<?php
session_start();

require "../classes/User.php";

$user_obj = new User;
$user = $user_obj->getUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit</title>

  <!-- bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/CSS/style.css">

  <!-- fontawesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<nav class="navbar navbar-expand navbar-dark bg-dark" style="margin-bottom: 80px;">
    <div class="container">
      <a href="dashboard.php" class="navbar-brand">
        <h1 class="h3">The Company</h1>
      </a>

      <div class="navbar-nav">
        <span class="navbar-text"><?= $_SESSION['full_name'] ?></span>
        <form action="../actions/logout.php" class="d-flex ms-2">
          <button type="submit" class="text-danger bg-transparent border-0">Log out</button>
        </form>
      </div>
    </div>
  </nav>

<main class="row justify-content-center gx-0">
  <div class="col-4">
    <h2 class="text-center mb-4">EDIT USER</h2>
    <form action="../actions/edit-user.php" method="post" enctype="multipart/form-data">
      <div class="row justify-content-center mb-3">
        <div class="col-6">
          <?php
            if($user['photo']){
          ?>
            <img src="../assets/images/<?= $user['photo'] ?>" alt="<?= $user['photo'] ?>" class="d-block mx-auto rounded-circle edit-photo">
          <?php
            }else{
          ?>
            <i class="fa-solid fa-circle-user text-secondary d-block text-center edit-icon"></i>
          <?php
            }
          ?>
          <input type="file" name="photo" id="photo" class="form-control mt-2" accept="image/*">
        </div>
      </div>

      <div class="mb-3 row">
        <label for="first_name" class="form-label fw-bold">First Name</label>
        <input type="text" name="first_name" id="first_name" class="form-control" value="<?= $user['first_name'] ?>" required>
      </div>
            
      <div class="mb-3 row">
        <label for="last_name" class="form-label fw-bold">Last Name</label>
        <input type="text" name="last_name" id="last_name" class="form-control" value="<?= $user['last_name'] ?>" required>
      </div>

      <div class="mb-3 row">
        <label for="email" class="form-label fw-bold">Email Address</label>
        <input type="email" name="email" id="email" class="form-control" value="<?= $user['email'] ?>" required>
      </div>

      <div class="text-end">
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-success btn-sm px-5">Save</button>
      </div>
    </form>
  </div>
</main>
</body>
</html>