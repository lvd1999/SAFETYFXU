<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/config.php';

$docID = $_GET['docid'];
$doc = docById($docID);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- <embed src="../adminwebappv4/pdf/<?php echo $doc['name'];?>" width="100%" height="100%"> -->
    <object
    data="../adminwebappv4/pdf/<?php echo $doc['name'];?>"
    type="application/pdf"
    width="100%"
    height="100%">
    <p>Your browser does not support PDFs.
        <a href="../adminwebappv4/pdf/<?php echo $doc['name'];?>">Download the PDF</a>.</p>
    </object>
</body>
</html>