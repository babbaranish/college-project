<html>

<head>
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
            if (in_array($category, $allowedCategories)) {
                $query = "INSERT into $category (product,price,image) VALUES ('$productName','$price','$imgContent')";
                $insert = mysqli_query($db, $query);

                if ($insert) {
                    echo "Product uploaded successfully. REDIRECTING TO ADMIN PAGE";
                    header("refresh:3;url=../admin.php");
                } else {
                    echo "Product upload failed, please try again. REDIRECTING TO ADMIN PAGE";
                    header("refresh:3;url=../admin.php");
                }
            } else {
                echo "ENTER RIGHT CATEGORY HEHE, REDIRECTING TO ADMIN PAGE";
                header("refresh:3;url=../admin.php");
            }
        } else {
            echo "Please select an image file to upload. Redirecting to previous page.";
            header("refresh:3;url=../admin.php");
        }
    }
    ?>

</body>

</html>