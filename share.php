<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {
        if (
            !isset($_FILES['letter_file']['error']) ||
            is_array($_FILES['letter_file']['error'])
        ) {
            http_response_code(400);
            // header('HTTP/1.1 400 Bad Request');
            throw new RuntimeException('Invalid parameters.');
        }

        switch ($_FILES['letter_file']['error']) {
            case UPLOAD_ERR_OK:
                break;

            case UPLOAD_ERR_NO_FILE:
                http_response_code(400);
                throw new RuntimeException('No file sent.');

            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                http_response_code(400);
                throw new RuntimeException('Exceeded filesize limit.');

            default:
                http_response_code(500);
                throw new RuntimeException('Unknown errors.');
        }

        if ($_FILES['letter_file']['size'] > 1000000) {
            http_response_code(400);
            throw new RuntimeException('Exceeded filesize limit.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (
            false === $ext = array_search(
                $finfo->file($_FILES['letter_file']['tmp_name']),
                array(
                    'png' => 'image/png'
                ),
                true
            )
        ) {
            http_response_code(400);
            throw new RuntimeException('Invalid file format.');
        }

        $file_name = sprintf(
            './uploads/%s.%s',
            sha1_file($_FILES['letter_file']['tmp_name']),
            $ext
        );

        if (
            !move_uploaded_file(
                $_FILES['letter_file']['tmp_name'],
                $file_name
            )
        ) {
            http_response_code(500);
            throw new RuntimeException('Failed to move uploaded file.');
        }
    } catch (RuntimeException $exc) {
        die($exc->getMessage());
    }

    $file_link = $_SERVER['HTTP_ORIGIN'] . substr($file_name, 1);

} else {
    header('Location: ./');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/svg+xml" href="./assets/icons/favicon.svg" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share your letter</title>

    <link rel="stylesheet" href="./assets/styles/output.css">
    <link rel="stylesheet" href="./assets/icons/fontawesome/css/font-awesome.min.css">

</head>

<body class="bg-slate-50 flex flex-col h-screen justify-between">
    <?php include_once(__DIR__ . '/partials/header.php'); ?>

    <div class="container mx-auto">
        <h3 class="font-cc text-5xl text-green-500 mb-4 text-center">Success! Your letter will be saved for 30 days.
        </h3>
        <p class="font-cc text-4xl text-center">Here is your link:</p>

        <a target="_blank" href="<?= $file_link ?>">

            <div class="envelope">
                <div class="paper"></div>
            </div>
        </a>
        <p class="text-center text-2xl my-3">
            <i onclick="copyText(this)" class="fa fa-copy text-green-600 hover:text-blue-600 hover:cursor-pointer"></i>
        </p>

        <h3 class="font-cc text-4xl text-center text-sky-600 my-4">social share:</h3>

        <p class="text-center my-3 text-2xl text-slate-700">
            <a class="mx-3" href="https://www.facebook.com/sharer/sharer.php?u=<?= $file_link ?>" target="_blank"
                rel="nofollow noopener"><i class="fa fa-facebook hover:text-red-600"></i></a>
            <a class="mx-3" href="https://twitter.com/intent/tweet?url=<?= $file_link ?>&text=Share%20Your%20Letter"
                target="_blank" rel="nofollow noopener"><i class="fa fa-twitter hover:text-red-600"></i></a>
            <a class="mx-3" href="https://reddit.com/submit?url=<?= $file_link ?>&title=Share%20Your%20Letter"
                target="_blank" rel="nofollow noopener"><i class="fa fa-reddit hover:text-red-600"></i></a>
        </p>

    </div>

    <?php include_once(__DIR__ . '/partials/footer.php'); ?>
    <script>

        function copyText(eve) {
            navigator.clipboard.writeText("<?= $file_link ?>")
            eve.classList.add('fa-spin')

            setTimeout(() => {
                eve.classList.remove('fa-spin')

            }, 1000);
        }
    </script>

</body>

</html>