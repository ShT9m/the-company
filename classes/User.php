<?php
require_once "Database.php";

class User extends Database{

  public function store($request){
    $first_name = $request['first_name'];
    $last_name = $request['last_name'];
    $email = $request['email'];
    $password = $request['password'];

    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(first_name, last_name, email, `password`)
    VALUES ('$first_name', '$last_name', '$email', '$password')";

    if($this->conn->query($sql)){
      header('location: ../views'); // redirect or go to views/index.php
      exit;
    }else{
      die('Error registering the new user: ' . $this->conn->error);
    }
  }

  public function login($request){
    $email = $request['email'];
    $password = $request['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";

    $result = $this->conn->query($sql);

    if($result->num_rows == 1){
      // check if password is correct
      $user = $result->fetch_assoc();
      if(password_verify($password, $user['password'])){
        session_start();
        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['full_name'] = $user['first_name'] . " " . $user['last_name'];

        header('location: ../views/dashboard.php');
        exit;
      }else{
        die('Password is Incorrect');
        exit;
      }
    }else{
      die('Email not found!');
    }
  }

  public function logout(){
    session_start();
    session_unset();
    session_destroy();

    header('location: ../views');
    exit;
  }

  public function getAllUsers(){
    $sql = "SELECT id, first_name, last_name, email, photo FROM users";

    if($result = $this->conn->query($sql)){
      return $result;
    }
    else{
      die('Error retrieving all users' . $this->conn->error);
    }
  }
  public function getUser(){
    // session_start();
    $id = $_SESSION['id'];

    $sql = "SELECT first_name, last_name, email, photo FROM users WHERE id = $id";

    if($result = $this->conn->query($sql)){
      return $result->fetch_assoc();
    }else{
      die('Error retrieving the user data: ' . $this->conn->error);
    }
  }

  public function update($request, $files){
    session_start();
    $id         = $_SESSION['id'];
    $first_name = $request['first_name'];
    $last_name  = $request['last_name'];
    $email      = $request['email'];
    $photo      = $files['photo']['name'];
    $tmp_photo  = $files['photo']['tmp_name'];

    $sql = "UPDATE users SET
        first_name = '$first_name',
        last_name = '$last_name',
        email = '$email'
        WHERE id = $id";

    if($this->conn->query($sql)){
      $_SESSION['email']      = $email;
      $_SESSION['full_name'] = "$first_name $last_name";

      // if there is an uploaded photo, save it to the database and then save the file to 'images' folder
      if($photo){
        $sql = "UPDATE users SET photo = '$photo' WHERE id = $id";
        $destination = "../assets/images/$photo";

        // Save the image name to database
        if($this->conn->query($sql)){
          if(move_uploaded_file($tmp_photo, $destination)){
            header('location: ../views/dashboard.php');
            exit;
          }else{
            die('Error moving the photo');
          }
        }else{
          die('Error uploading the photo: ' . $this->conn->error);
        }
      }
      header('location: ../views/dashboard.php');
      exit;
    }else{
      die('error updating the user: ' . $this->conn->error);
    }
  }

  public function delete(){
    session_start();
    $id = $_SESSION['id'];

    $sql = "DELETE FROM users WHERE id = $id";

    if($this->conn->query($sql)){
      // Call public function logout()
      $this->logout();
    }else{
      die('Error deleting your account: ' . $this->conn->error);
      }
    // 1.Delete the account
    // 2. Logout / Destroy the session

    // die('Error deleting your account: ')
  }
}


?>