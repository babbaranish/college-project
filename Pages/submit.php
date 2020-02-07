<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="./CSS/styles.css" />
    <title>ADD ITEMS</title>
</head>

<body>

    <?php
    include_once './db.php';
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));
            $productName = $_REQUEST['name'];
            $price = $_REQUEST['price'];
            $category = strtolower($_REQUEST['category']);
            $allowedCategories = array(1 => 'mens', 2 => 'womens', 3 => 'sneakers', 4 => 'hats', 5 => 'jackets');
            /*
            * Insert image data into database
            */
            switch ($category) {
                case "mens":
                    $insert = mysqli_query($db, "INSERT into mens (product,price,image) VALUES ('$productName','$price','$imgContent')");
                    if ($insert) {
                        echo "File uploaded successfully. REDIRECTING TO ADMIN PAGE";
                        header("refresh:3;url=../admin.php");
                    } else {
                        echo "File upload failed, please try again. REDIRECTING TO ADMIN PAGE";
                        header("refresh:3;url=../admin.php");
                    }
                    break;
                case "womens":
                    //Insert image content into database
                    $insert = mysqli_query($db, "INSERT into womens (product,price,image) VALUES ('$productName','$price','$imgContent')");
                    if ($insert) {
                        echo "File uploaded successfully. REDIRECTING TO ADMIN PAGE";
                        header("refresh:3;url=../admin.php");
                    } else {
                        echo "File upload failed, please try again. REDIRECTING TO ADMIN PAGE";
                        header("refresh:3;url=../admin.php");
                    }
                    break;
                case "hats":
                    //Insert image content into database
                    $insert = mysqli_query($db, "INSERT into hats (product,price,image) VALUES ('$productName','$price','$imgContent')");
                    if ($insert) {
                        echo "File uploaded successfully. REDIRECTING TO ADMIN PAGE";
                        header("refresh:3;url=../admin.php");
                    } else {
                        echo "File upload failed, please try again. REDIRECTING TO ADMIN PAGE";
                        header("refresh:3;url=../admin.php");
                    }
                    break;
                case "sneakers":
                    //Insert image content into database
                    $insert = mysqli_query($db, "INSERT into sneakers (product,price,image) VALUES ('$productName','$price','$imgContent')");
                    if ($insert) {
                        echo "File uploaded successfully.  REDIRECTING TO ADMIN PAGE";
                        header("refresh:3;url=../admin.php");
                    } else {
                        echo "File upload failed, please try again. REDIRECTING TO ADMIN PAGE";
                        header("refresh:3;url=../admin.php");
                    }
                    break;
                case "jackets":
                    //Insert image content into database
                    $insert = mysqli_query($db, "INSERT into jackets (product,price,image) VALUES ('$productName','$price','$imgContent')");
                    if ($insert) {
                        echo "File uploaded successfully. REDIRECTING TO ADMIN PAGE";
                        header("refresh:3;url=../admin.php");
                    } else {
                        echo "File upload failed, please try again.  REDIRECTING TO ADMIN PAGE";
                        header("refresh:3;url=../admin.php");
                    }
                default:
                    echo "ENTER RIGHT CATEGORY HEHE, REDIRECTING TO ADMIN PAGE";
                    header("refresh:3;url=../admin.php");
            }
        } else {
            echo "Please select an image file to upload.";
            header("refresh:3;url=../admin.php");
        }
    }
    ?>

</body>

</html>