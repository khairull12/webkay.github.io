<!DOCTYPE html>
<html>
<head>
    <title>Add Surat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: auto;
            overflow: hidden;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        header {
            background: #006400;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #e8491d 3px solid;
        }
        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        header ul {
            padding: 0;
            list-style: none;
        }
        header li {
            float: left;
            display: inline;
            padding: 0 20px 0 20px;
        }
        header #branding {
            float: left;
        }
        header #branding h1 {
            margin: 0;
        }
        header nav {
            float: right;
            margin-top: 10px;
        }
        form {
            margin-top: 20px;
        }
        form input[type="text"], form input[type="datetime-local"], form textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        form input[type="submit"] {
            width: 100%;
            background-color: #006400;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background-color: #ddd
        }
        .btn {
            display: inline-block;
            font-size: 16px;
            color: white;
            background-color: #006400;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #ddd;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            border-radius: 4px;
        }
        .message a {
            color: #3c763d;
            text-decoration: none;
            font-weight: bold;
        }
        .message a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1>Add New Surat</h1>
            </div>
            <nav>
    <ul>
        <li><a href="index.php" class="btn">Home</a></li>
    </ul>
</nav>
</div>
</header>

<div class="container">
    <form action="add.php" method="post" name="form1">
        <label for="asal_surat">Asal Surat</label>
        <input type="text" name="asal_surat">

        <label for="tempat">Tempat</label>
        <input type="text" name="tempat">

        <label for="waktu">Waktu</label>
        <input type="datetime-local" name="waktu" placeholder="YYYY-MM-DDTHH:MM">

        <label for="hal">Hal</label>
        <input type="text" name="hal">

        <label for="keterangan">Keterangan</label>
        <textarea name="keterangan"></textarea>

        <input type="submit" name="Submit" value="Add">
    </form>

        <?php
    // Include config file
    include_once("config.php");
    
    if(isset($_POST['Submit'])) {
        $asal_surat = $_POST['asal_surat'];
        $tempat = $_POST['tempat'];
        $waktu = $_POST['waktu'];
        $hal = $_POST['hal'];
        $keterangan = $_POST['keterangan'];
    
        // Insert data into table
        $result = mysqli_query($mysqli, "INSERT INTO surat(asal_surat, tempat, waktu, hal, keterangan) VALUES('$asal_surat','$tempat','$waktu','$hal','$keterangan')");
    
        // Check if insert was successful
        if ($result) {
            echo "Data added successfully.";
        } else {
            echo "Error: " . mysqli_error($mysqli);
        }
    }
    ?>
</div>