<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/site.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<?php
include_once 'form.php';

function GetForm($filename = "structure.json")
{
    $fileData = file_get_contents($filename);
    $decodetData = json_decode($fileData, true);
    //var_dump($decodetData);
    $form = GetHTMLFromArray($decodetData);
    return $form;
}

echo GetForm();
?>
    <!-- <script src='js/main.js'></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        
        document.addEventListener('DOMContentLoaded', function(){
            const inputs = document.querySelectorAll('input');
            console.log(inputs.length);
            inputs.forEach(input => {
                const beforeInput = window.getComputedStyle(input,"::before");
                input.setAttribute('data-before', input.dataset.choosetext);
            });
        });
    </script>
</body>
</html>

