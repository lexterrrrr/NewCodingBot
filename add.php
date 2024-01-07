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
    
    if (isset($_POST['add'])) {
        $pdo = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $file= $_FILES['file']['name'];
        $filename = $_POST['filename'];
        $description = $_POST['description'];
        
    
  
        $targetDirectory = 'files/'; 
        $targetFile = $targetDirectory . basename($_FILES['file']['name']);
    
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
           
            $insert_query = "INSERT INTO files (filename,description, file,date_uploaded) VALUES (:filename, :description, :targetFile,NOW())";
            $stmt = $pdo->prepare($insert_query);
            $stmt->bindParam(':filename', $filename); 
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':targetFile', $targetFile);
        
            if ($stmt->execute()) {
                $_SESSION['message'] = "File added successfully!";
                header("Location: add.php");
                exit();
            } else {
                $_SESSION['message'] = "Failed to add File.";
                header("Location: add.php");
                exit();
            }
        } else {
            $_SESSION['message'] = "Failed to upload the file.";
            header("Location: add.php");
            exit();
        }
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
        .content form input[type="submit"],
        .content form input[type = "file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
        }

       
        .content form input[type="submit"],
        .content form input[type = "file"] {
            background-color: #4CAF50; 
            color: white;
            cursor: pointer;
        }

        .content form input[type="submit"]:hover {
            background-color: #45a049; 
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
        <a  href="home.php">Home</a>
        <a   href="#">Contact</a>
        <a   href="register.php">Register</a>
        <a   class="active" href="add.php">Add File</a>
        <a   href="loginadmin.php">Login as Admin</a>
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
       
        <h2 style = "padding:10px;background:grey;text-align:center;border-radius:10px;box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;">Add Files</h2>
        <?php
        if (isset($_SESSION['admin'])) {
            ?>
        <form class="form" method="post" enctype="multipart/form-data">
                    <label for="file">File:</label><br>
                    <input id = "file"  type="file" name="file" class="form-input" required>
                    <br>
                    <label for="filename">Filename:</label><br>
                    <input id = "filename"type="text" name="filename" class="form-input" required>
                    <br>
                    <label for="description">Description:</label><br>
                    <input id = "description" type="text" name="description" class="form-input" required>
                    <br>
                    <button style='width:100%;padding:10px;background:orange;cursor:pointer;' type='submit' name='add'>
                        ADD
                    </button>
        </form>
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
