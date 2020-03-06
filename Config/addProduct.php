<html>

<head>
    <title>ADD ITEMS</title>
</head>

<body>

    <?php
    include_once './db.php';
    // when someone press submit button then this query will run
    if (isset($_POST["submit"])) {
        // get the size of image and check if it is an image or not if this is not an image this won't run
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            //get the image 
            $image = $_FILES['image']['tmp_name'];
            //Reads entire file into a string & Quote string with slashes
            $imgContent = addslashes(file_get_contents($image));
            $productName = $_REQUEST['name'];
            $price = $_REQUEST['price'];
            $category = strtolower($_REQUEST['category']);
            // product categories which are allowed to be enter in the shop
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