<?php
session_start();
include("admin_login_header.php");

const DB_SERVER = "127.0.0.1";
const DB_USER = "root";
const DB_PASSWORD = "Atharv1107";
const DB_NAME = "ita";

function connect_db() {
    $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD);
    if (!$conn) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }
    mysqli_select_db($conn, DB_NAME);
    return $conn;
}

function fetch_distinct_pids($conn) {
    $sql = "SELECT DISTINCT(pid) FROM reviews";
    return $conn->query($sql);
}

function fetch_product_name($conn, $pid) {
    $sql = "SELECT pname FROM products WHERE pid='$pid'";
    $res = $conn->query($sql);
    $row = mysqli_fetch_assoc($res);
    return $row['pname'];
}

function fetch_reviews($conn, $pid) {
    $sql = "SELECT review FROM reviews WHERE pid='$pid'";
    $res = $conn->query($sql);
    $reviews = [];
    while($row = mysqli_fetch_assoc($res)) {
        $reviews[] = $row['review'];
    }
    return implode(" ", $reviews);
}

$conn = connect_db();
$result = fetch_distinct_pids($conn);
?>
<HTML>
<HEAD>
<TITLE>Product Rating</TITLE>
<style>
table, tr, td {
    border-style: solid;
    border-color: grey;
    border-collapse: collapse;
    padding: 10px;
    width: auto;
    background-color: #fff;
    font-family: Helvetica;
}

th {
    border-style: solid;
    border-color: darkgreen;
    background-color: #49a03d;
    font-family: Arial;
    font-weight: bold;
    text-align: center;
    padding: 10px;
}

/* Additional CSS */
td input, div.box input {
    margin: auto;
    align-self: center;
    background-color: #4CAF50;
    transition-duration: 0.4s;
}
</style>
</HEAD>
<BODY bgcolor="#E6E6FA">
<br><br>
<div class="main">
    <br><br>
    <table align="center">
        <tr>
            <th><font color="white"><b>Product ID</b></font></th>
            <th><font color="white"><b>Product</b></font></th>
            <th><font color="white"><b>Review</b></font></th>
            <th><font color="white"><b>Action</b></font></th>
        </tr>
        <?php
        while($row = mysqli_fetch_assoc($result)) {
            $pid =  $row['pid'];
            $pname = fetch_product_name($conn, $pid);
            $reviews = fetch_reviews($conn, $pid);
        ?>
        <tr>
            <td><?php echo $pid; ?></td>
            <td><?php echo $pname; ?></td>
            <td><?php echo $reviews; ?></td>
            <td><a href="admin-rate-confirm.php?pid=<?php echo $pid; ?>&treview=<?php echo $reviews; ?>">Rate</a></td>
        </tr>
        <?php
        }
        ?>
        <tr>
            <th colspan="4"><a href="ita-admin.php"><button type="button" class="btn btn-default">Go Back</button></a></th>
        </tr>
    </table>
</div>
</BODY>
</HTML>
<?php
include("admin-footer.php");
?>