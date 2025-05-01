<?php
$filename = basename($_GET['file']);
echo $filepath = "/assets/public/records/" . $filename;

// if (file_exists($filepath)) {
//     header('Content-Type: application/octet-stream');
//     header('Content-Disposition: attachment; filename="' . $filename . '"');
//     header('Content-Length: ' . filesize($filepath));
//     readfile($filepath);
//     exit;
// } else {
//     http_response_code(404);
//     echo "File not found.";
// }
?>
