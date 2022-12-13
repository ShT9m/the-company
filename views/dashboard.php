<?php

session_start();

require '../classes/User.php';
$user = new User;
$all_users = $user->getAllUsers();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  
  <!-- bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/css/style.css">

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
  <div class="col-6">
    <h2 class="text-center">User List</h2>
    <table class="table table-hover align-middle">
      <thead>
        <tr>
          <th><!-- for photo --></th>
          <th>ID</th>
          <th>User Full Name</th>
          <th>Email</th>
          <th><!-- for action buttons --></th>
        </tr>
      </thead>
      <tbody>
        <?php
          while($user = $all_users->fetch_assoc()){
        ?>
        <tr>
          <td>
            <?php
              if($user['photo']){
            ?>
                <img src="../assets/images/<?= $user['photo'] ?>" alt="<?= $user['photo'] ?>" class="d-block mx-auto rounded-circle dashboard-photo">
            
            <?php
              }else{
            ?>
                <i class="fa-solid fa-circle-user text-secondary d-block text-center dashboard-icon"></i>
            <?php
              }
              ?>
          </td>

          <td><?= $user['id'] ?></td>
          <td><?= ucfirst($user['last_name']) . ", " . ucfirst($user['first_name']) ?></td>
          <td><?= $user['email'] ?></td>
          <td>
            <!-- Action Buttons -->
            <?php
            if($_SESSION['id'] == $user['id']){
            ?>
              <a href="edit-user.php" class="btn btn-outline-warning btn-sm border-0" title="Edit"><i class="fa-solid fa-user-pen"></i></a>
              <a href="delete-user.php" class="btn btn-outline-danger btn-sm border-0" title="Delete"><i class="fa-solid fa-user-minus"></i></a>
            <?php
            }
            ?>
          </td>
        </tr>
        <?php
        }
        ?>
      </tbody>

    </table>
  </div>
</main>

  <!-- script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>