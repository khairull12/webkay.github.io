<?php
// Include config file
include_once("config.php");

// Pagination logic
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Sorting and search logic
$sort_order = isset($_GET['sort']) && $_GET['sort'] == 'desc' ? 'DESC' : 'ASC';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$query = "SELECT * FROM surat WHERE 1=1";
if ($start_date && $end_date) {
    $query .= " AND DATE(waktu) BETWEEN '$start_date' AND '$end_date'";
} elseif ($start_date) {
    $query .= " AND DATE(waktu) >= '$start_date'";
} elseif ($end_date) {
    $query .= " AND DATE(waktu) <= '$end_date'";
}
$query .= " ORDER BY waktu $sort_order LIMIT $limit OFFSET $offset";
$result = mysqli_query($mysqli, $query);

// Check if query was successful
if (!$result) {
    die("Query Error: " . mysqli_error($mysqli));
}

// Fetch total number of records for pagination
$total_query = "SELECT COUNT(*) as total FROM surat WHERE 1=1";
if ($start_date && $end_date) {
    $total_query .= " AND DATE(waktu) BETWEEN '$start_date' AND '$end_date'";
} elseif ($start_date) {
    $total_query .= " AND DATE(waktu) >= '$start_date'";
} elseif ($end_date) {
    $total_query .= " AND DATE(waktu) <= '$end_date'";
}
$total_result = mysqli_query($mysqli, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html>
<head>    
    <title>Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #006400; /* Dark Green */
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #004d00 3px solid; /* Darker Green */
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
            display: flex;
            justify-content: flex-end;
        }
        header li {
            display: inline;
            padding: 0 20px;
        }
        header #branding {
            float: left;
            display: flex;
            align-items: center;
        }
        header #branding h1 {
            margin: 0;
            margin-left: 10px;
        }
        header nav {
            float: right;
            margin-top: 10px;
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        table, th, td {
            border: 4px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
            color: black; /* Set text color to black */
        }
        th {
            background-color: #006400; /* Dark Green */
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
         /* Specific styling for the Update column */
         th:last-child, td:last-child {
            width: 200px; /* Adjust the width as needed */
        }
        .btn {
            display: inline-block;
            font-size: 16px;
            color: white;
            background-color: #006400; /* Dark Green */
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
        }
        .btn:hover {
            background-color: #004d00; /* Darker Green */
        }
        .btn:active {
            background-color: #333333; /* Dark Grey */
        }
        .header-text {
            text-align: center;
            margin: 20px 0;
            width: 100%;
        }
        .header-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        .form-container {
            margin: 20px 0;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container label {
            margin-right: 10px;
        }
        .form-container select, .form-container input[type="date"], .form-container button {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            background: #006400; /* Dark Green */
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background: #004d00; /* Darker Green */
        }
        .pagination {
            margin: 20px 0;
            text-align: center;
        }
        .pagination a {
            padding: 10px 15px;
            margin: 0 5px;
            background: #006400; /* Dark Green */
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
        }
        .pagination a:hover {
            background: #004d00; /* Darker Green */
        }
        
    </style>
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = 'delete.php?id=' + id;
            }
        }

        function printTable() {
            var printContents = document.getElementById('printableTable').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</head>

<body>
    <header>
        <div class="container">
            <div id="branding" class="header-container">
                <img src="logo disbunnak baru.png" alt="Logo" width="150" height="140">
                <div class="header-text">
                    <h1>AGENDA HARIAN</h1>
                    <h1>DINAS PERKEBUNAN DAN PETERNAKAN PROVINSI KALIMANTAN BARAT</h1>
                </div>
                <img src="akcaya-removebg-preview.png" alt="Logo" width="150" height="140">
            </div>
            <nav>
                <ul>
                    <li><a href="index.php" class="btn">Home</a></li>
                    <li><a href="add.php" class="btn">tambah agenda</a></li>
                    <li><button onclick="printTable()" class="btn">PRINT</button></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="form-container">
            <form method="GET" action="">
                </select>
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
                <button type="submit">Search</button>
            </form>
    <div class="container">
        <div id="printableTable">
            <table>
                <tr>
                    <th>No</th>
                    <th>Asal Surat</th>
                    <th>Tempat</th>
                    <th>Waktu</th>
                    <th>Hal</th>
                    <th>Keterangan</th>
                    <th>Update</th>
                </tr>
                <?php  
                $no = 1; // Inisialisasi variabel counter
                while($surat_data = mysqli_fetch_array($result)) {         
                    echo "<tr>";
                    echo "<td>".$no++."</td>"; // Menampilkan nomor urut dan increment counter
                    echo "<td>".$surat_data['asal_surat']."</td>";
                    echo "<td>".$surat_data['tempat']."</td>";
                    echo "<td>".$surat_data['waktu']."</td>";
                    echo "<td>".$surat_data['hal']."</td>";
                    echo "<td>".$surat_data['keterangan']."</td>";    
                    echo "<td><a href='edit.php?id=$surat_data[id]' class='btn'>Edit</a> | <a href='#' onclick='confirmDelete($surat_data[id])' class='btn'>Delete</a></td></tr>";        
                }
                ?>
            </table>
        </div>
        </div>
        <div class="pagination">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='index.php?page=$i&sort=$sort_order&start_date=$start_date&end_date=$end_date' class='btn'>$i</a> ";
            }
            ?>
    </div>
</body>
</html>