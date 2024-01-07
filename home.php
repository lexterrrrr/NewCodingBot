<?php
session_start();
if (isset($_SESSION['message'])) {
    echo "<p style = 'padding:10px;background:lightgreen;' >{$_SESSION['message']}</p>";
    unset($_SESSION['message']);
} 
$servername = "localhost";
$username = "root";
$password = ""; 
$db_name = "let";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $username = $_POST['username'];
        $enteredPassword = $_POST['password'];

        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $enteredPassword === $user['password']) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            header("Location: login.php");
            exit();
        } else {
            $errorMessage = "Password verification failed. Invalid username or password.";
        }
    }

    if (isset($_POST['logout'])) {
        $_SESSION = array();
    
        session_destroy();
    
        header("Location: login.php");
        exit();
    }



    if (isset($_POST['logout'])) {
        $_SESSION = array();
    
        session_destroy();
    
        header("Location: login.php");
        exit();
    }

?>


<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Let</title>
  <link rel="stylesheet" href="style.css">

</head>
<head>
    <title>Navigation Bar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #283048, #859398, #283048);
            background-attachment: fixed;
        }

        .navbar {
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            padding: 10px;
        }
        
        .logo {
            width: 50px; 
            height: 50px;
            margin-right: 10px;
            border-radius: 50%; 
        }
        
        .navbar a {
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        
        .active {
            background-color: #585151;
            color: black;
        }

        .content-section {
            display: none;
        }

        .content-section:target {
            display: block;
        }

        .content {
            border-radius: 20px;
            color: #333;
            background-image: url('img/bg.jpg'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            max-width:90%;
            overflow: auto;
            padding:10px;
            margin: auto;
            box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
            min-height: 550px; 
        }

        .footer {
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top:10px;
            width: 100%;
        }

        .content p {
            line-height: 1.6;
        }

        .content-section {
            padding:20px;
            margin: auto;
        }

        .content-section h2 {
            margin-bottom: 10px;
        }
        .content form {
            max-width: 90%;
            margin: auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;
            
        }

        .content form label {
            font-weight: bold;
        }

        .content form input[type="text"],
        .content form input[type="password"],
        .content form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
        }

       
        .content form input[type="submit"] {
            background-color: #4CAF50; 
            color: white;
            cursor: pointer;
        }

        .content form input[type="submit"]:hover {
            background-color: #45a049; 
        }
        .flex-container {
          display: flex;
        }

        .flex-item {
          border: 1px solid #ccc;
          padding: 20px;
          margin: 10px;
          width:100%;
          
        }







        table {
      width: 100%;
      border-collapse: collapse;
    }

    /* Table cell styling */
    td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
      
    }

    /* Styling the 4th row */
    tr:nth-child(4) {
      background-color: #f0f0f0;
    }

    /* Styling the 4th td in every row */
    tr td:nth-child(4) {
      font-weight: bold;
      color: blue;
    }





    










    </style>
</head>

<body>
<?php if(isset($errorMessage)) { ?>
        <p style = "background:red;padding:10px;"><?php echo $errorMessage; ?></p>
<?php } ?>

    <!-- Navigation bar -->
    <div class="navbar">
        <img src="img/logo.jpg" alt="Logo" class="logo">
        <a  class="active" href="home.php">Home</a>
        <a href="#">Contact</a>
        <a   href="register.php">Register</a>
        <a   href="add.php">Add File</a>
        <a    href="loginadmin.php">Login as Admin</a>
        <a   href="addlink.php">Add Link</a>
        <a   href="login.php">Login as User</a>
        <?php
				if (isset($_SESSION['user_id']) || isset($_SESSION['admin'])) {
					?>
				
				<form action="" method="post">
    			    <input  style = "padding:12px;margin-left:8px;background:lightgreen;border-radius:20px;" type="submit" name="logout" value="Logout">
    			</form>
                
				<?php
					}
		?>
    </div>

    <div style = "margin-top:10px;"></div>
    <div class="content">
       
        <h2 style = "padding:10px;background:grey;text-align:center;border-radius:10px;box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;">Tutorials For Licensure Examinations</h2>
        <?php
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['admin'])) {
        ?>
        <div class = "form" style = "background:white;height:400px;border-radius:20px;padding:20px;
        box-shadow:rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;">
        <h2 style = "padding:10px;background:lightgreen;text-align:center;border-radius:10px;box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;">Description</h2>
        
            <p style = "font-size:35px;">
            Welcome to Licensure Exam Mastery, your go-to online resource for comprehensive tutorials to help you ace your professional licensure examinations. Whether you're pursuing a career in becoming a Licenced Teacher, we've got you covered.
            </p>
        </div>
        <?php
        }
        /////////////////////////////////////////////////////////////////////////////////////////////////
        if (isset($_SESSION['user_id'])) {
        ?>
        <div class = "form" style = "overflow:auto;background:white;height:400px;border-radius:20px;padding:20px;
        box-shadow:rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;">   
            <div class="flex-container" >   
                <div class="flex-item" style = "text-align:center;background:lightgreen;border:solid 2px black;border-radius:10px;">
                    <p>Files</p>
                </div>
                
            </div>
            <div class="flex-container">
              
                <div class="flex-item">
                <table>
                    <tr>
                      <td>File Name</td>
                      <td>Description</td>
                      <td>Download File</td>
                      <td>Date Added</td>
                    </tr>
                <?php
                     $sql = "SELECT * FROM files";
                     $stmt = $pdo->query($sql);
                     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                         $linkname = $row['filename'];
                         $description = $row['description'];
                         $linkadd = $row['file'];
                         $date = $row['date_uploaded'];
                    ?>
                        <tr>
                          <td><?= $linkname ?></td>
                          <td><?= $description ?></td>
                          <td><a href = "<?= $linkadd ?>" download>File</a></td>
                          <td><?= $date ?></td>
                        </tr>
  
                    <?php
                     }
                    ?>
                    </table>   
                    
                </div>
                
            </div>


            <div class="flex-container" >   
                <div class="flex-item" style = "text-align:center;background:lightgreen;border:solid 2px black;border-radius:10px;">
                    <p>Yt Links</p>
                </div>
                
            </div>
            <div class="flex-container">
              
                <div class="flex-item">
                <table>
                    <tr>
                      <td>Link Name</td>
                      <td>Description</td>
                      <td>Link Add</td>
                      <td>Date Added</td>
                    </tr>
                <?php
                     $sql = "SELECT * FROM yt_link";
                     $stmt = $pdo->query($sql);
                     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                         $linkname = $row['link_name'];
                         $description = $row['description'];
                         $linkadd = $row['link_add'];
                         $date = $row['date_uploaded'];
                    ?>
                        <tr>
                          <td><?= $linkname ?></td>
                          <td><?= $description ?></td>
                          <td><a href = "<?= $linkadd ?>" >Link</a></td>
                          <td><?= $date ?></td>
                        </tr>
  
                    <?php
                     }
                    ?>
                    </table>   
                    
                </div>
                
            </div>
            
        </div>


        <?php
        }
        //for admin
        if (isset($_SESSION['admin'])) {
            ?>
        <div class = "form" style = "overflow:auto;background:white;height:400px;border-radius:20px;padding:20px;
        box-shadow:rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;">   
            <div class="flex-container" >   
                <div class="flex-item" style = "text-align:center;background:lightgreen;border:solid 2px black;border-radius:10px;">
                    <p>Files</p>
                </div>
                
            </div>
            <div class="flex-container">
              
                <div class="flex-item">
                <table>
                    <tr>
                      <td>File Name</td>
                      <td>Description</td>
                      <td>Download File</td>
                      <td>Date Added</td>
                    </tr>
                <?php
                     $sql = "SELECT * FROM files";
                     $stmt = $pdo->query($sql);
                     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $id = $row['id'];
                         $linkname = $row['filename'];
                         $description = $row['description'];
                         $linkadd = $row['file'];
                         $date = $row['date_uploaded'];
                    ?>
                        <tr>
                          <td><?= $linkname ?></td>
                          <td><?= $description ?></td>
                          <td><a href = "<?= $linkadd ?>" download>File</a></td>
                          <td><?= $date ?></td>
                          <td><a  href="delete.php?id=<?= $id; ?>">&#128942;</a></td>
                        </tr>
  
                    <?php
                     }
                    ?>
                    </table>   
                    
                </div>
                
            </div>


            <div class="flex-container" >   
                <div class="flex-item" style = "text-align:center;background:lightgreen;border:solid 2px black;border-radius:10px;">
                    <p>Yt Links</p>
                </div>
                
            </div>
            <div class="flex-container">
              
                <div class="flex-item">
                <table>
                    <tr>
                      <td>Link Name</td>
                      <td>Description</td>
                      <td>Link Add</td>
                      <td>Date Added</td>
                    </tr>
                <?php
                     $sql = "SELECT * FROM yt_link";
                     $stmt = $pdo->query($sql);
                     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $id = $row['id'];
                         $linkname = $row['link_name'];
                         $description = $row['description'];
                         $linkadd = $row['link_add'];
                         $date = $row['date_uploaded'];
                    ?>
                        <tr>
                          <td><?= $linkname ?></td>
                          <td><?= $description ?></td>
                          <td><a href = "<?= $linkadd ?>" >Link</a></td>
                          <td><?= $date ?></td>
                          <td><a  href="deletes.php?id=<?= $id; ?>">&#128942;</a></td>
                        </tr>
  
                    <?php
                     }
                    ?>
                    </table>   
                    
                </div>
                
            </div>
            
        </div>
            


        <?php
        }

        ?>
    </div>
    

    <!-- Footer -->
    <div class="footer">
    <p>Alright Recieved. &copy; 2023 Licensure Exam Mastery</p>
    </div>
<?php
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
</body>

</html>
