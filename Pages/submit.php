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
            $category = $_REQUEST['category'];
            $allowedCategories = array(1 => 'mens', 2 => 'womens', 3 => 'sneakers', 4 => 'hats', 5 => 'jackets');
            // Check connection
            if (!$db) {
                die("Connection failed: ");
            }
            /*
            * Insert image data into database
            */
            if ($category == "mens") {
                //Insert image content into database
                $insert = mysqli_query($db, "INSERT into mens (product,price,image) VALUES ('$productName','$price','$imgContent')");
                if ($insert) {
                    echo "File uploaded successfully.";
                    header("refresh:3;url=../admin.php");
                } else {
                    echo "File upload failed, please try again.";
                }
            }
            if ($category == "womens") {
                //Insert image content into database
                $insert = mysqli_query($db, "INSERT into womens (product,price,image) VALUES ('$productName','$price','$imgContent')");
                if ($insert) {
                    echo "File uploaded successfully.";
                    header("refresh:3;url=../admin.php");
                } else {
                    echo "File upload failed, please try again.";
                }
            }
            if ($category == "hats") {
                //Insert image content into database
                $insert = mysqli_query($db, "INSERT into hats (product,price,image) VALUES ('$productName','$price','$imgContent')");
                if ($insert) {
                    echo "File uploaded successfully.";
                    header("refresh:3;url=../admin.php");
                } else {
                    echo "File upload failed, please try again.";
                }
            }
            if ($category == "sneakers") {
                //Insert image content into database
                $insert = mysqli_query($db, "INSERT into sneakers (product,price,image) VALUES ('$productName','$price','$imgContent')");
                if ($insert) {
                    echo "File uploaded successfully.";
                    header("refresh:3;url=../admin.php");
                } else {
                    echo "File upload failed, please try again.";
                }
            }
            if ($category == "jackets") {
                //Insert image content into database
                $insert = mysqli_query($db, "INSERT into jackets (product,price,image) VALUES ('$productName','$price','$imgContent')");
                if ($insert) {
                    echo "File uploaded successfully.";
                    header("refresh:3;url=../admin.php");
                } else {
                    echo "File upload failed, please try again.";
                }
            }
        } else {
            echo "Please select an image file to upload.";
        }
    }
    ?>

</body>

</html>