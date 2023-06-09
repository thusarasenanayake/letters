<?php
$server_url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";

?>

<header class=" py-4 ">
    <nav class="flex justify-center gap-8">
        <a href="<?= $server_url ?>">
            <p
                class="font-mono font-bold text-purple-500 hover:cursor-pointer hover:font-extrabold hover:text-blue-600">
                <i class="fa fa-home"></i> Home
            </p>
        </a>
        <a href="https://github.com/thusarasenanayake/letters" target="_blank">
            <p class="font-mono font-bold text-cyan-500 hover:cursor-pointer hover:font-extrabold hover:text-blue-600">
                <i class="fa fa-github"></i> Source Code
            </p>
        </a>
    </nav>
</header>