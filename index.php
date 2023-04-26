<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/svg+xml" href="assets/icons/favicon.svg" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Letters</title>
  <link rel="stylesheet" href="./assets/styles/output.css">
  <link rel="stylesheet" href="./assets/icons/fontawesome/css/font-awesome.min.css">
</head>

<body>

  <?php include_once(__DIR__ . '/partials/header.php'); ?>


  <main class="letter bg-white max-w-xl">


    <div class="p-4" id="frame">
      <div class="m-4 max-w-xl" id="content">
        <h1 contenteditable="" class="outline-none font-autography text-5xl mb-3">Hey John,</h1>
        <p contenteditable="" class="outline-none font-autography text-4xl">You're invited to celebrate my birthday
          with me! Let's have a great time together with cake, balloons, and lots of laughter. Can't wait to see you!!
        </p>
        <div class="flex justify-between pt-8 bg-white bg-opacity-50 items-center">
          <p contenteditable="" class="outline-none font-autography text-5xl" id="sender">Anna</p>
          <canvas class="bg-white pl-2" id="identicon" width="60" height="60" data-jdenticon-value="Anna">
        </div>
        </canvas>
      </div>

    </div>
    <form class="text-center mt-5" id="share-form" action="./share.php" method="post" enctype="multipart/form-data">
      <input type="file" name="letter_file" hidden>
      <div
        class="hidden inline-block mx-10 h-5 w-5 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] text-blue-400 motion-reduce:animate-[spin_1.5s_linear_infinite]"
        role="status" id="save_loading">
        <span
          class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
      </div>

      <input class="font-cc text-4xl bg-blue-500 px-5 rounded-lg text-white cursor-pointer hover:bg-blue-800"
        type="button" value="save" onclick="saveLetter(this)">

      <div
        class="hidden inline-block mx-10 h-5 w-5 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] text-blue-400 motion-reduce:animate-[spin_1.5s_linear_infinite]"
        role="status" id="share_loading">
        <span
          class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
      </div>

      <input class="font-cc text-4xl bg-blue-500 px-5 rounded-lg text-white cursor-pointer hover:bg-blue-800"
        type="submit" value="share">

    </form>


  </main>

  <?php include_once(__DIR__ . '/partials/footer.php'); ?>

  <script src="./assets/scripts/FileSaver.min.js.js"></script>
  <script src="./assets/scripts/dom-to-image.min.js.js"></script>
  <script src="./assets/scripts/jdenticon.min.js.js"></script>
  <script>

    const letter = document.getElementById('frame')

    function updateIdenticon(eve) {
      jdenticon.update("#identicon", eve.target.textContent);

    }

    function saveLetter(eve) {
      document.getElementById('save_loading').classList.toggle('hidden')
      eve.classList.toggle('hidden')
      domtoimage.toBlob(letter, {
        bgcolor: 'white',
      })
        .then(function (blob) {
          window.saveAs(blob, `${new Date().getTime()}`);
          eve.classList.toggle('hidden')
          document.getElementById('save_loading').classList.toggle('hidden')

        });
    }

    function handleShareFormSubmit(eve) {
      document.getElementById('share_loading').classList.toggle('hidden')
      eve.preventDefault();

      domtoimage.toBlob(letter, {
        bgcolor: 'white'
      })
        .then(function (blob) {
          const file_name = 'letter.png'

          const file = new File([blob], file_name, {
            type: "image/png",
          }, 'utf-8')
          const container = new DataTransfer()
          container.items.add(file)
          eve.target.elements.letter_file.files = container.files
          document.getElementById('share_loading').classList.toggle('hidden')
          eve.target.submit()
        });

    }

    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('*[contenteditable=""]').forEach(ele => {
        ele.addEventListener('input', function (eve) {
          eve.target.textContent = ''
        }, { once: true })
      })
      document.getElementById('sender').addEventListener('input', updateIdenticon)
      document.getElementById('share-form').addEventListener('submit', handleShareFormSubmit)

    })

  </script>
</body>

</html>