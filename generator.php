<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image to dot generator</title>
    <link rel="icon" href="favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&amp;display=swap" rel="stylesheet">
    <link href="src/styles/output.css" rel="stylesheet">

    <meta name="description" content="Generate some ASCII art from an uploaded image!">
    <meta name="author" content="Catpawz">
    <meta content="#A443D1" data-react-helmet="true" name="theme-color">
    <meta property="og:image" content="favicon.png">
    <style>
        .container {
            text-align: center;
            margin: 20px;
        }

        .description {
            margin-bottom: 20px;
            font-size: 14px;
            color: #A9B4CCFF;
        }

        .output {
            white-space: pre;
            font-size: 16px;
            font-family: 'Braille', monospace;
            margin-top: 20px;
            background-color: #0C111DFF;
            padding: 20px;
            border: 1px solid #323B4EFF;
            border-radius: 10px;
            max-width: 80vw;
            max-height: 50vh;
            overflow: auto;
            color: #f0f0f0;
        }

        button {
            background-color: #0C111DFF;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 15px;
            border: 1px solid #323B4EFF;
            transition: 0.5s;
        }

        button:hover {
            background-color: #323B4EFF;
            transition: 0.5s;
        }

        .slider-container {
            margin-top: 20px;
            width: 300px;
        }

        .slider-container label {
            display: block;
            margin-bottom: 5px;
        }

        .slider-container input {
            width: 100%;
            border-radius: 15px;
        }

        canvas {
            display: none;
        }

        .drop-zone {
            margin-top: 20px;
            padding: 20px;
            border: 2px dashed #323B4EFF;
            border-radius: 10px;
            text-align: center;
            font-size: 16px;
            color: #A9B4CCFF;
            cursor: pointer;
            transition: 0.5s;
        }

        .drop-zone:hover {
            background-color: #323B4EFF;
            transition: 0.5s;
        }

        h1,
        h2,
        h3 {
            color: #A9B4CCFF;
        }

        label {
            color: #A9B4CCFF;
        }
    </style>
</head>

<body class="bg-gray-900">
    <div class="relative isolate overflow-hidden bg-gray-900">
        <svg class="absolute inset-0 -z-10 h-full w-full stroke-white/10 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]" aria-hidden="true">
            <defs>
                <pattern id="983e3e4c-de6d-4c3f-8d64-b9761d1534cc" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                    <path d="M.5 200V.5H200" fill="none" />
                </pattern>
            </defs>
            <svg x="50%" y="-1" class="overflow-visible fill-gray-800/20">
                <path d="M-200 0h201v201h-201Z M600 0h201v201h-201Z M-400 600h201v201h-201Z M200 800h201v201h-201Z" stroke-width="0" />
            </svg>
            <rect width="100%" height="100%" stroke-width="0" fill="url(#983e3e4c-de6d-4c3f-8d64-b9761d1534cc)" />
        </svg>
        <div class="absolute left-[calc(50%-4rem)] top-10 -z-10 transform-gpu blur-3xl sm:left-[calc(50%-18rem)] lg:left-48 lg:top-[calc(50%-30rem)] xl:left-[calc(50%-24rem)]" aria-hidden="true">
            <div class="aspect-[1108/632] w-[69.25rem] bg-gradient-to-r from-[#d18843] to-[#46dae5] opacity-20" style="clip-path: polygon(73.6% 51.7%, 91.7% 11.8%, 100% 46.4%, 97.4% 82.2%, 92.5% 84.9%, 75.7% 64%, 55.3% 47.5%, 46.5% 49.4%, 45% 62.9%, 50.3% 87.2%, 21.3% 64.1%, 0.1% 100%, 5.4% 51.1%, 21.4% 63.9%, 58.9% 0.2%, 73.6% 51.7%)"></div>
        </div>
        <div class="mx-auto max-w-7xl px-6 pb-24 pt-10 sm:pb-32 lg:flex lg:px-8 lg:py-40">
            <div class="mx-auto max-w-2xl flex-shrink-0 lg:mx-0 lg:max-w-xl lg:pt-8">
                <h1 class="mt-10 text-4xl font-bold tracking-tight text-white sm:text-6xl flex items-center">
                    Image to dot generator
                </h1>
                <p class="mt-6 text-lg leading-8 text-gray-300">Generate ASCII art from your own images!</p>
                <div class="mt-10 flex items-center gap-x-6">
                    <a href="https://fembois.eu" class="rounded-md bg-purple-900 px-3.5 py-2.5 text-sm font-semibold text-purple-300 shadow-sm hover:bg-purple-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-400">Home</a>
                    <a href="/" class="rounded-md bg-purple-900 px-3.5 py-2.5 text-sm font-semibold text-purple-300 shadow-sm hover:bg-purple-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-400">Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-10 text-center">

        <div class="drop-zone" id="dropZone" onclick="document.getElementById('imageInput').click()">
            Drag & drop an image here or click to upload!
        </div>

        <input type="file" id="imageInput" accept="image/*" style="display:none" onchange="generateArt()">
        <button id="regenerateBTN" onclick="generateArt()">Regenerate (be careful!)</button>
        <p class="description">If you selected a size that's too big, the page might freeze! Don't say I didn't warn you >:3</p>

        <div class="slider-container">
            <label for="sizeSlider">Output Size (Scale): <span id="sizeValue">12</span></label>
            <input type="range" id="sizeSlider" min="1" max="30" value="12" step="1" oninput="updateSizeValue(this.value)">
        </div>

        <div class="slider-container">
            <label for="intensitySlider">Dot Intensity (Threshold): <span id="intensityValue">128</span></label>
            <input type="range" id="intensitySlider" min="0" max="255" value="128" oninput="updateIntensityValue(this.value)">
        </div>

        <div id="output" class="output"></div>

        <h3 style="margin: 0; padding: 0;padding-top: 30px;">Copy as code comment:</h3>
        <button id="copyBtnCSS" onclick="copyToClipboardCSS()">CSS/ C++/ Rust/ TypeScript</button>
        <button id="copyBtnHTML" onclick="copyToClipboardHTML()">HTML</button>
        <button id="copyBtnDART" onclick="copyToClipboardDART()">DART</button>
        <button id="copyBtnPYTHON" onclick="copyToClipboardDART()">PYTHON</button>

        <h3 style="margin: 0; padding: 0;padding-top: 30px;">Copy as other:</h3>
        <button id="copyBtnRAW" onclick="copyToClipboardRAW()">RAW</button>
    </div>

    <canvas id="canvas"></canvas>

    <?php include 'inc/footer.php'; ?>

    <script>
    let img = null;

    const urlParams = new URLSearchParams(window.location.search);
    const sizeParam = urlParams.get('size');
    const thresholdParam = urlParams.get('threshold');

    if (sizeParam) {
        document.getElementById('sizeSlider').value = sizeParam;
        updateSizeValue(sizeParam);
    }

    if (thresholdParam) {
        document.getElementById('intensitySlider').value = thresholdParam;
        updateIntensityValue(thresholdParam);
    }

    const imageUrlParam = urlParams.get('imageUrl');

    if (imageUrlParam) {
        img = new Image();
        img.crossOrigin = "*"; // Handle CORS if needed
        img.onload = () => {
            renderArt(
                parseInt(document.getElementById('sizeSlider').value),
                parseInt(document.getElementById('intensitySlider').value)
            );
        };
        img.src = imageUrlParam; // Directly using the image URL from the parameter
    }

    function generateArt() {
        const fileInput = document.getElementById('imageInput');
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        const sizeScale = parseInt(document.getElementById('sizeSlider').value);
        const intensityThreshold = parseInt(document.getElementById('intensitySlider').value);

        if (fileInput.files.length === 0) {
            alert("Please select an image first.");
            return;
        }

        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.onload = function(event) {
            img = new Image();
            img.onload = () => renderArt(sizeScale, intensityThreshold);
            img.src = event.target.result;
        };

        reader.readAsDataURL(file);
    }

    function renderArt(sizeScale, intensityThreshold) {
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');

        canvas.width = img.width;
        canvas.height = img.height;

        ctx.drawImage(img, 0, 0);

        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const data = imageData.data;
        let art = "";

        for (let y = 0; y < img.height; y += 4 * (21 - sizeScale)) {
            for (let x = 0; x < img.width; x += 2 * (21 - sizeScale)) {
                let dotPattern = 0;
                for (let row = 0; row < 4; row++) {
                    for (let col = 0; col < 2; col++) {
                        const pixelX = x + col * (21 - sizeScale);
                        const pixelY = y + row * (21 - sizeScale);

                        if (pixelX >= img.width || pixelY >= img.height) continue;

                        const index = (pixelY * img.width + pixelX) * 4;
                        const grayscale = (data[index] + data[index + 1] + data[index + 2]) / 3;
                        const isDot = grayscale < intensityThreshold;

                        if (isDot) {
                            const bitIndex = row * 2 + col;
                            dotPattern |= (1 << bitIndex);
                        }
                    }
                }

                art += brailleFromPattern(dotPattern);
            }
            art += "\n";
        }

        document.getElementById("output").innerText = art;
    }

    function brailleFromPattern(pattern) {
        return String.fromCharCode(0x2800 + pattern);
    }

    function copyToClipboardCSS() {
        const art = document.getElementById("output").innerText;
        const commentArt = "/*\n" + art + "\n*/";

        const tempTextarea = document.createElement("textarea");
        tempTextarea.value = commentArt;
        document.body.appendChild(tempTextarea);
        tempTextarea.select();
        document.execCommand("copy");
        document.body.removeChild(tempTextarea);

        alert("Dot Art copied as comment!");
    }

    function copyToClipboardHTML() {
        const art = document.getElementById("output").innerText;
        const commentArt = "<!--\n" + art + "\n-->";

        const tempTextarea = document.createElement("textarea");
        tempTextarea.value = commentArt;
        document.body.appendChild(tempTextarea);
        tempTextarea.select();
        document.execCommand("copy");
        document.body.removeChild(tempTextarea);

        alert("Dot Art copied as comment!");
    }

    function copyToClipboardDART() {
        const art = document.getElementById("output").innerText;
        const commentArt = art.split('\n').map(line => '//   ' + line).join('\n');

        const tempTextarea = document.createElement("textarea");
        tempTextarea.value = commentArt;
        document.body.appendChild(tempTextarea);
        tempTextarea.select();
        document.execCommand("copy");
        document.body.removeChild(tempTextarea);

        alert("Dot Art copied as comment!");
    }

    function copyToClipboardPYTHON() {
        const art = document.getElementById("output").innerText;
        const commentArt = art.split('\n').map(line => '#   ' + line).join('\n');

        const tempTextarea = document.createElement("textarea");
        tempTextarea.value = commentArt;
        document.body.appendChild(tempTextarea);
        tempTextarea.select();
        document.execCommand("copy");
        document.body.removeChild(tempTextarea);

        alert("Dot Art copied as comment!");
    }

    function copyToClipboardRAW() {
        const art = document.getElementById("output").innerText;

        const tempTextarea = document.createElement("textarea");
        tempTextarea.value = art;
        document.body.appendChild(tempTextarea);
        tempTextarea.select();
        document.execCommand("copy");
        document.body.removeChild(tempTextarea);

        alert("Dot Art copied as raw!");
    }

    // Handle file drop
    const dropZone = document.getElementById('dropZone');
    dropZone.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropZone.style.backgroundColor = '#4f375e';
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.style.backgroundColor = '';
    });

    dropZone.addEventListener('drop', (event) => {
        event.preventDefault();
        dropZone.style.backgroundColor = '';
        const file = event.dataTransfer.files[0];
        if (file) {
            document.getElementById('imageInput').files = event.dataTransfer.files;
            generateArt();
        }
    });

    function updateSizeValue(value) {
        document.getElementById('sizeValue').innerText = value;
    }

    function updateIntensityValue(value) {
        document.getElementById('intensityValue').innerText = value;
    }
</script>

    <script src='https://storage.ko-fi.com/cdn/scripts/overlay-widget.js'></script>
    <script>
        kofiWidgetOverlay.draw('french_femboi', {
            'type': 'floating-chat',
            'floating-chat.donateButton.text': 'Support me',
            'floating-chat.donateButton.background-color': '#794bc4',
            'floating-chat.donateButton.text-color': '#fff'
        });
    </script>
</body>

</html>