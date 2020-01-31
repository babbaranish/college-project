<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="./CSS/styles.css" />
    <title>ADD ITEMS</title>
</head>

<body>
    <center>

        <h1>ADD PRODUCT TO THE SHOP</h1>
        <form action='./Pages/submit.php' method="post">
            <label style="margin-right:10px;font-size:20px;margin-left:60px;">IMAGE : </label>
            <input type="file" name="image"></input><br><br>
            <label style="margin-right:10px;font-size:20px;">NAME : </label>
            <input type="text" name="name"></input><br><br>
            <label style="margin-right:10px;font-size:20px;">PRICE : </label>
            <input type="text" name="price"></input><br><br>
            <label style="margin-right:10px;font-size:20px;">CATEGORY : </label>
            <input type="text" name="category"></input><br><br>
            <input
                style="height: 50px;letter-spacing:0.5px;line-height: 50px;padding: 0 35px 0 35px;font-size: 15px;background-color: black;color: white;font-family: 'Open Sans Condensed';border:none;cursor:pointer"
                type="submit" name="submit">
        </form>

    </center>


</body>

</html>