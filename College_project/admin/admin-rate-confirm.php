<?php 

function getReviewData() {
    return [
        'pid' => $_GET['pid'],
        'review' => $_GET['treview']
    ];
}

function writeReviewToFile($review) {
    $filePath = "userReview.txt";
    $file = fopen($filePath, "w") or die("Unable to open file!");
    fwrite($file, $review . "\n");
    fclose($file);
    return $filePath;
}

function executePythonScript($filePath) {
    $pythonExecutable = 'C:/Users/shiva/Anaconda3/python.exe';
    $pythonScript = 'C:/xampp/htdocs/ita_project/admin/rate.py';
    exec("$pythonExecutable $pythonScript $filePath", $output);
    return $output[0];
}

function updateProductRating($pid, $rating) {
    $conn = mysqli_connect("localhost", "root", "");
    mysqli_select_db($conn, "ita");
    $sql = "UPDATE products SET rating='$rating' WHERE pid='$pid'";
    if ($conn->query($sql)) {
        echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('Product rating updated!!')
                window.location.href='admin-rate-product.php'
                </SCRIPT>");
    }
    mysqli_close($conn);
}

$reviewData = getReviewData();
$filePath = writeReviewToFile($reviewData['review']);
$rating = executePythonScript($filePath);
updateProductRating($reviewData['pid'], $rating);

?>