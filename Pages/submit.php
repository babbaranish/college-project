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
    if (isset($_POST['submit'])) {

        $image = $_FILES['image']['name'];
        echo $image;
        $productName = $_REQUEST['name'];
        $price = $_REQUEST['price'];
        $category = $_REQUEST['category'];
        $conn = mysqli_connect('localhost', 'root', '');
        $id = rand();






        // // Check connection
        // if (!$conn) {
        //     die("Connection failed: " . mysqli_connect_error());
        // }
        // $db = mysqli_select_db($conn, "shop");
        // //check connection with db
        // if (!$db) {
        //     die("Database not connected");
        // }

        // $query = "insert into . $category . values ('$productName',$price,'$image',$id";
        // if (mysqli_query($conn, $query)) {
        //     echo 'inserted af';
        // } else {
        //     echo 'not inserted properly';
        // }
        // if ($category == "mens") {
        //     $mensQuery = "INSERT INTO mens VALUES ('$productName', $price, '$image',$id)";
        //     $imageNewName = uniqid('', true . '.' . $imageActualExt);

        //     if (mysqli_query($conn, $mensQuery)) {
        //         $imageDestination = $category . '//' . $imageNewName;
        //         move_uploaded_file($imageTmpName, $imageDestination);
        //         echo "DATA INSERTED";
        //     } else {
        //         echo "NOT INSERTED PROPERLY";
        //     }
        // } elseif ($category == "womens") {
        //     $womensQuery = "INSERT INTO womens VALUES ('$productName', $price, '$image',$id)";
        //     if (mysqli_query($conn, $womensQuery)) {
        //         echo "DATA INSERTED";
        //     } else {
        //         echo "NOT INSERTED PROPERLY";
        //     }
        // } elseif ($category == "jackets") {
        //     $jacketQuery = "INSERT INTO jackets VALUES ('$productName', $price, '$image',$id)";
        //     if (mysqli_query($conn, $jacketQuery)) {
        //         echo "DATA INSERTED";
        //     } else {
        //         echo "NOT INSERTED PROPERLY";
        //     }
        // } elseif ($category == "sneakers") {
        //     $sneakersQuery = "INSERT INTO sneakers VALUES ('$productName', $price, '$image',$id)";
        //     if (mysqli_query($conn, $sneakersQuery)) {
        //         echo "DATA INSERTED";
        //     } else {
        //         echo "NOT INSERTED PROPERLY";
        //     }
        // } elseif ($category == "hats") {
        //     $hatsQuery = "INSERT INTO hats VALUES ('$productName', $price, '$image',$id)";
        //     if (mysqli_query($conn, $hatsQuery)) {
        //         echo "DATA INSERTED";
        //     } else {
        //         echo "NOT INSERTED PROPERLY";
        //     }
        // }
    }
    ?>

</body>

</html>