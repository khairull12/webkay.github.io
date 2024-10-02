<?php
// include database connection file
include_once("config.php");

// Check if form is submitted for surat update, then redirect to homepage after update
if(isset($_POST['update']))
{   
    $id = $_POST['id'];

    $asal_surat = $_POST['asal_surat'];
    $tempat = $_POST['tempat'];
    $waktu = $_POST['waktu'];
    $hal = $_POST['hal'];
    $keterangan = $_POST['keterangan'];

    // update surat data
    $result = mysqli_query($mysqli, "UPDATE surat SET asal_surat='$asal_surat',tempat='$tempat',waktu='$waktu',hal='$hal',keterangan='$keterangan' WHERE id=$id");

    // Redirect to homepage to display updated surat in list
    header("Location: index.php");
}
?>
<?php
// Display selected surat data based on id
// Getting id from url
$id = $_GET['id'];

// Fetch surat data based on id
$result = mysqli_query($mysqli, "SELECT * FROM surat WHERE id=$id");

while($surat_data = mysqli_fetch_array($result))
{
    $asal_surat = $surat_data['asal_surat'];
    $tempat = $surat_data['tempat'];
    $waktu = $surat_data['waktu'];
    $hal = $surat_data['hal'];
    $keterangan = $surat_data['keterangan'];
}
?>
<!DOCTYPE html>
<html>
<head>  
    <title>Edit Surat Data</title>
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
            background-color: #ddd;
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
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1>Edit Surat Data</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php" class="btn">Home</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <form name="update_surat" method="post" action="edit.php">
            <input type="hidden" name="id" value=<?php echo $_GET['id'];?>>
            <label for="asal_surat">Asal Surat</label>
            <input type="text" name="asal_surat" value="<?php echo $asal_surat;?>">

            <label for="tempat">Tempat</label>
            <input type="text" name="tempat" value="<?php echo $tempat;?>">

            <label for="waktu">Waktu</label>
            <input type="datetime-local" name="waktu" value="<?php echo $waktu;?>">

            <label for="hal">Hal</label>
            <input type="text" name="hal" value="<?php echo $hal;?>">

            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan"><?php echo $keterangan;?></textarea>

            <input type="submit" name="update" value="Update">
        </form>
    </div>
</body>
</html>