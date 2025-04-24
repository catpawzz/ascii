<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASCII Generator</title>
    <link rel="icon" href="favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&amp;display=swap" rel="stylesheet">
    <link href="src/styles/output.css" rel="stylesheet">

    <meta name="description" content="Generate some ASCII art from an uploaded image or an image url!">
    <meta name="author" content="Catpawz">
    <meta content="#A443D1" data-react-helmet="true" name="theme-color">
    <meta property="og:image" content="https://ascii.catpawz.net/favicon.png">
    <style>
        .output {
            white-space: pre;
            font-family: 'Braille', monospace;
            background-color: #0C111DFF;
            border: 1px solid #323B4EFF;
            color: #f0f0f0;
            text-align: center;
            overflow: auto;
        }

        canvas {
            display: none;
        }
    </style>
</head>

<body class="bg-gray-900 text-gray-200" data-scroll-container>

    <!-- Notifications -->
    <div id="notificationSuccess" class="hidden fixed bottom-20 left-5 bg-green-900 border border-green-600 text-green-200 px-4 py-2 rounded-lg shadow-lg opacity-0 transition-opacity duration-500 z-50">
        This is a notification!
    </div>

    <div id="notificationError" class="hidden fixed bottom-20 left-5 bg-red-900 border border-red-600 text-red-200 px-4 py-2 rounded-lg shadow-lg opacity-0 transition-opacity duration-500 z-50">
        This is a notification!
    </div>

    <!-- Header with animated background -->
    <div class="relative isolate overflow-hidden bg-gray-900">
        <svg class="absolute inset-0 -z-10 h-full w-full stroke-white/10 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)] animate-fade-down" aria-hidden="true">
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
        <div class="absolute left-[calc(50%-4rem)] top-10 -z-10 transform-gpu blur-3xl sm:left-[calc(50%-18rem)] lg:left-48 lg:top-[calc(50%-30rem)] xl:left-[calc(50%-24rem)] animate-fade animate-duration-[3000ms]" aria-hidden="true">
            <div class="aspect-[1108/632] w-[69.25rem] bg-gradient-to-r from-[#d18843] to-[#6f00ff] opacity-20" style="clip-path: polygon(73.6% 51.7%, 91.7% 11.8%, 100% 46.4%, 97.4% 82.2%, 92.5% 84.9%, 75.7% 64%, 55.3% 47.5%, 46.5% 49.4%, 45% 62.9%, 50.3% 87.2%, 21.3% 64.1%, 0.1% 100%, 5.4% 51.1%, 21.4% 63.9%, 58.9% 0.2%, 73.6% 51.7%)"></div>
        </div>
        <div class="mx-auto max-w-7xl px-6 py-12 sm:py-16 lg:flex lg:px-8">
            <div class="mx-auto max-w-2xl flex-shrink-0 lg:mx-0 lg:max-w-xl lg:pt-8">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl flex items-center animate-fade animate-delay-250">
                    Image to ASCII Art Generator
                </h1>
                <p class="mt-4 text-lg leading-8 text-gray-300 animate-fade animate-delay-500">Transform your images into beautiful dot patterns! All processing happens in your browser - no uploads needed.</p>
                <p class="mt-2 text-purple-200 animate-fade animate-delay-500">v0.0.7 (24/04/2025)</p>
                <div class="mt-6 flex items-center gap-x-6 animate-fade animate-delay-750">
                    <a href="/" class="rounded-md bg-purple-700 hover:bg-purple-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors duration-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-400">
                        Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Input Controls -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Image Upload Card -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                    <h2 class="text-xl font-semibold text-purple-300 mb-4">1. Upload Image</h2>
                    
                    <!-- Drag & Drop Zone -->
                    <div id="dropZone" onclick="document.getElementById('imageInput').click()" 
                        class="border-2 border-dashed border-gray-600 rounded-lg p-8 text-center cursor-pointer hover:bg-gray-700 transition-colors duration-200 mb-4 flex flex-col items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="text-gray-300">Drag & drop an image here</p>
                        <span class="text-sm text-gray-400 mt-1">or click to browse files</span>
                    </div>
                    <input type="file" id="imageInput" accept="image/*" class="hidden" onchange="generateArt()">
                    
                    <!-- OR Separator -->
                    <div class="flex items-center my-4">
                        <div class="flex-grow h-px bg-gray-600"></div>
                        <span class="px-3 text-sm text-gray-400">OR</span>
                        <div class="flex-grow h-px bg-gray-600"></div>
                    </div>
                    
                    <!-- URL Input -->
                    <div class="space-y-2 mb-4">
                        <label for="imageUrlInput" class="block text-sm font-medium text-gray-300">Image URL:</label>
                        <div class="flex gap-2">
                            <input type="text" id="imageUrlInput" placeholder="https://example.com/image.jpg" 
                                class="flex-grow bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <button onclick="loadImageFromUrl()" 
                                class="bg-purple-700 hover:bg-purple-600 text-white px-3 py-2 rounded-lg text-sm whitespace-nowrap transition-colors duration-200">
                                Load URL
                            </button>
                        </div>
                    </div>
                    
                    <!-- Preview Image (hidden until loaded) -->
                    <div id="imagePreview" class="hidden mt-4 border border-gray-700 rounded-lg overflow-hidden">
                        <img id="previewImg" class="max-w-full h-auto" alt="Preview">
                    </div>
                </div>
                
                <!-- Settings Card -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                    <h2 class="text-xl font-semibold text-purple-300 mb-4">2. Adjust Settings</h2>
                    
                    <!-- Scale Slider -->
                    <div class="mb-5">
                        <div class="flex justify-between items-center mb-2">
                            <label for="sizeSlider" class="text-sm font-medium text-gray-300">Scale:</label>
                            <span id="sizeValue" class="text-sm bg-gray-700 px-2 py-1 rounded text-white">12</span>
                        </div>
                        <input type="range" id="sizeSlider" min="1" max="30" value="12" step="1" 
                            class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer accent-purple-500"
                            oninput="updateSizeValue(this.value)">
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>Small</span>
                            <span>Large</span>
                        </div>
                    </div>
                    
                    <!-- Threshold Slider -->
                    <div class="mb-5">
                        <div class="flex justify-between items-center mb-2">
                            <label for="intensitySlider" class="text-sm font-medium text-gray-300">Threshold:</label>
                            <span id="intensityValue" class="text-sm bg-gray-700 px-2 py-1 rounded text-white">128</span>
                        </div>
                        <input type="range" id="intensitySlider" min="0" max="255" value="128" 
                            class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer accent-purple-500"
                            oninput="updateIntensityValue(this.value)">
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>More dots</span>
                            <span>Less dots</span>
                        </div>
                    </div>
                    
                    <!-- Generate Button -->
                    <button id="regenerateBTN" onclick="generateArt()" 
                        class="w-full py-3 bg-purple-700 hover:bg-purple-600 text-white rounded-lg font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                        </svg>
                        Generate ASCII Art
                    </button>
                    
                    <p class="text-red-300 text-sm mt-3">⚠️ Large scales may cause your browser to freeze</p>
                </div>
            </div>
            
            <!-- Right Column: Result & Copy Options -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Output Card -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                    <h2 class="text-xl font-semibold text-purple-300 mb-4">3. Result</h2>
                    
                    <div id="outputWrapper" class="relative min-h-[400px]">
                        <!-- Loading Indicator (hidden by default) -->
                        <div id="loadingIndicator" class="hidden absolute inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 rounded-lg">
                            <div class="flex flex-col items-center">
                                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-purple-500"></div>
                                <p class="mt-4 text-purple-300">Generating ASCII art...</p>
                            </div>
                        </div>
                        
                        <!-- Output Container -->
                        <div id="output" class="output text-sm md:text-base bg-gray-900 rounded-lg p-4 min-h-[400px] max-h-[600px] overflow-auto"></div>
                    </div>
                </div>
                
                <!-- Copy Options Card -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                    <h2 class="text-xl font-semibold text-purple-300 mb-4">4. Copy & Share</h2>
                    
                    <!-- Code Comment Copy Buttons -->
                    <div class="mb-5">
                        <h3 class="text-gray-300 text-sm font-medium mb-3">Copy as code comment:</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                            <button id="copyBtnCSS" onclick="copyToClipboardCSS()" 
                                class="bg-gray-700 hover:bg-gray-600 text-sm text-gray-200 py-2 px-3 rounded transition-colors duration-200">
                                CSS/TS
                            </button>
                            <button id="copyBtnHTML" onclick="copyToClipboardHTML()" 
                                class="bg-gray-700 hover:bg-gray-600 text-sm text-gray-200 py-2 px-3 rounded transition-colors duration-200">
                                HTML
                            </button>
                            <button id="copyBtnDART" onclick="copyToClipboardDART()" 
                                class="bg-gray-700 hover:bg-gray-600 text-sm text-gray-200 py-2 px-3 rounded transition-colors duration-200">
                                Dart
                            </button>
                            <button id="copyBtnPYTHON" onclick="copyToClipboardPYTHON()" 
                                class="bg-gray-700 hover:bg-gray-600 text-sm text-gray-200 py-2 px-3 rounded transition-colors duration-200">
                                Python
                            </button>
                            <button id="copyBtnLUA" onclick="copyToClipboardLUA()" 
                                class="bg-gray-700 hover:bg-gray-600 text-sm text-gray-200 py-2 px-3 rounded transition-colors duration-200">
                                Lua
                            </button>
                        </div>
                    </div>
                    
                    <!-- Other Copy Options -->
                    <div>
                        <h3 class="text-gray-300 text-sm font-medium mb-3">Other options:</h3>
                        <div class="flex flex-wrap gap-3">
                            <button id="copyBtnRAW" onclick="copyToClipboardRAW()" 
                                class="bg-gray-700 hover:bg-gray-600 text-sm text-gray-200 py-2 px-4 rounded transition-colors duration-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Copy Raw Text
                            </button>
                            <button id="copyBtnURL" onclick="copyCurrentUrl()" 
                                class="bg-gray-700 hover:bg-gray-600 text-sm text-gray-200 py-2 px-4 rounded transition-colors duration-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                Copy Shareable URL
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <canvas id="canvas"></canvas>

    <?php include 'inc/footer.php'; ?>
    <script nomodule src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.6.0/polyfill.min.js" crossorigin="anonymous"></script>
    <script nomodule src="https://cdnjs.cloudflare.com/polyfill/v3/polyfill.min.js?features=Object.assign%2CElement.prototype.append%2CNodeList.prototype.forEach%2CCustomEvent%2Csmoothscroll" crossorigin="anonymous"></script>
    <script>
        let img = null;

        // Check URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const sizeParam = urlParams.get('size');
        const thresholdParam = urlParams.get('threshold');
        const imageUrlParam = urlParams.get('url');

        // Initialize UI from URL params if available
        if (sizeParam) {
            document.getElementById('sizeSlider').value = sizeParam;
            updateSizeValue(sizeParam);
        }

        if (thresholdParam) {
            document.getElementById('intensitySlider').value = thresholdParam;
            updateIntensityValue(thresholdParam);
        }

        if (imageUrlParam) {
            document.getElementById('imageUrlInput').value = imageUrlParam;
            loadImageFromUrl();
            showNotificationS("Loaded image from URL parameters!");
        }

        // Copy URL with current parameters
        function copyCurrentUrl() {
            const size = document.getElementById('sizeSlider').value;
            const threshold = document.getElementById('intensitySlider').value;
            const imageUrl = document.getElementById('imageUrlInput').value;

            if (!imageUrl) {
                showNotificationE("You can only share the URL if you loaded an image from a URL!");
                return;
            }

            const currentUrl = `${window.location.origin}${window.location.pathname}?size=${size}&threshold=${threshold}&url=${encodeURIComponent(imageUrl)}`;
            navigator.clipboard.writeText(currentUrl)
                .then(() => showNotificationS("Shareable URL copied to clipboard!"))
                .catch(() => {
                    // Fallback for browsers that don't support clipboard API
                    const tempTextarea = document.createElement("textarea");
                    tempTextarea.value = currentUrl;
                    document.body.appendChild(tempTextarea);
                    tempTextarea.select();
                    document.execCommand("copy");
                    document.body.removeChild(tempTextarea);
                    showNotificationS("Shareable URL copied to clipboard!");
                });
        }

        // Load image from URL
        function loadImageFromUrl() {
            const imageUrl = document.getElementById('imageUrlInput').value;
            if (!imageUrl) {
                showNotificationE("Please enter a valid image URL!");
                return;
            }

            // Show loading indicator
            document.getElementById('loadingIndicator').classList.remove('hidden');
            
            img = new Image();
            img.crossOrigin = "Anonymous"; // Handle CORS issues
            
            img.onload = () => {
                // Show preview
                const previewImg = document.getElementById('previewImg');
                previewImg.src = img.src;
                document.getElementById('imagePreview').classList.remove('hidden');
                
                // Generate art
                renderArt(parseInt(document.getElementById('sizeSlider').value), parseInt(document.getElementById('intensitySlider').value));
                document.getElementById('loadingIndicator').classList.add('hidden');
            };
            
            img.onerror = () => {
                showNotificationE("Failed to load image! Check the URL or try another image.");
                document.getElementById('loadingIndicator').classList.add('hidden');
            };
            
            img.src = imageUrl;
        }

        // Generate ASCII art from uploaded file or existing image
        function generateArt() {
            const fileInput = document.getElementById('imageInput');
            const sizeScale = parseInt(document.getElementById('sizeSlider').value);
            const intensityThreshold = parseInt(document.getElementById('intensitySlider').value);

            // Show loading indicator
            document.getElementById('loadingIndicator').classList.remove('hidden');

            if (fileInput.files.length === 0 && !img) {
                showNotificationE("Please upload an image or provide a URL first!");
                document.getElementById('loadingIndicator').classList.add('hidden');
                return;
            }

            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const reader = new FileReader();

                reader.onload = function(event) {
                    img = new Image();
                    img.onload = () => {
                        // Show preview
                        const previewImg = document.getElementById('previewImg');
                        previewImg.src = img.src;
                        document.getElementById('imagePreview').classList.remove('hidden');
                        
                        // Generate art
                        renderArt(sizeScale, intensityThreshold);
                        document.getElementById('loadingIndicator').classList.add('hidden');
                    };
                    img.src = event.target.result;
                };

                reader.readAsDataURL(file);
            } else if (img) {
                renderArt(sizeScale, intensityThreshold);
                document.getElementById('loadingIndicator').classList.add('hidden');
            }
        }

        // Process image and generate ASCII art
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

        // Convert dot pattern to braille character
        function brailleFromPattern(pattern) {
            if (pattern === 0) {
                return " ";
            }
            return String.fromCharCode(0x2800 + pattern);
        }

        // Copy functions for different formats
        function copyToClipboardCSS() {
            const art = document.getElementById("output").innerText;
            const commentArt = "/*\n" + art + "\n*/";
            copyText(commentArt, "CSS comment");
        }

        function copyToClipboardHTML() {
            const art = document.getElementById("output").innerText;
            const commentArt = "<!--\n" + art + "\n-->";
            copyText(commentArt, "HTML comment");
        }

        function copyToClipboardLUA() {
            const art = document.getElementById("output").innerText;
            const commentArt = "--[[\n" + art + "\n]]--";
            copyText(commentArt, "Lua comment");
        }

        function copyToClipboardDART() {
            const art = document.getElementById("output").innerText;
            const commentArt = art.split('\n').map(line => '//   ' + line).join('\n');
            copyText(commentArt, "Dart comment");
        }

        function copyToClipboardPYTHON() {
            const art = document.getElementById("output").innerText;
            const commentArt = art.split('\n').map(line => '#   ' + line).join('\n');
            copyText(commentArt, "Python comment");
        }

        function copyToClipboardRAW() {
            const art = document.getElementById("output").innerText;
            copyText(art, "raw text");
        }

        // Helper function for copying text
        function copyText(text, type) {
            navigator.clipboard.writeText(text)
                .then(() => showNotificationS(`ASCII art copied as ${type}!`))
                .catch(() => {
                    // Fallback for browsers that don't support clipboard API
                    const tempTextarea = document.createElement("textarea");
                    tempTextarea.value = text;
                    document.body.appendChild(tempTextarea);
                    tempTextarea.select();
                    document.execCommand("copy");
                    document.body.removeChild(tempTextarea);
                    showNotificationS(`ASCII art copied as ${type}!`);
                });
        }

        // Handle file drop events
        const dropZone = document.getElementById('dropZone');
        
        dropZone.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropZone.classList.add('bg-gray-700');
            dropZone.classList.add('border-purple-500');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('bg-gray-700');
            dropZone.classList.remove('border-purple-500');
        });

        dropZone.addEventListener('drop', (event) => {
            event.preventDefault();
            dropZone.classList.remove('bg-gray-700');
            dropZone.classList.remove('border-purple-500');
            
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                document.getElementById('imageInput').files = event.dataTransfer.files;
                generateArt();
            } else {
                showNotificationE("Please drop a valid image file!");
            }
        });

        // Update slider value displays
        function updateSizeValue(value) {
            document.getElementById('sizeValue').innerText = value;
        }

        function updateIntensityValue(value) {
            document.getElementById('intensityValue').innerText = value;
        }

        // Success notification
        function showNotificationS(message) {
            const notification = document.getElementById('notificationSuccess');
            notification.innerText = message;
            // Remove 'hidden' and fade in by changing the opacity to 100%
            notification.classList.remove('hidden');
            notification.classList.remove('opacity-0');
            notification.classList.add('opacity-100');

            // After 3 seconds, fade out
            setTimeout(() => {
                notification.classList.remove('opacity-100');
                notification.classList.add('opacity-0');

                // Hide the notification after the fade out completes (500ms)
                setTimeout(() => {
                    notification.classList.add('hidden');
                }, 500);
            }, 3000); // Notification stays for 3 seconds
        }

        // Error notification
        function showNotificationE(message) {
            const notification = document.getElementById('notificationError');
            notification.innerText = message;
            // Remove 'hidden' and fade in by changing the opacity to 100%
            notification.classList.remove('hidden');
            notification.classList.remove('opacity-0');
            notification.classList.add('opacity-100');

            // After 3 seconds, fade out
            setTimeout(() => {
                notification.classList.remove('opacity-100');
                notification.classList.add('opacity-0');

                // Hide the notification after the fade out completes (500ms)
                setTimeout(() => {
                    notification.classList.add('hidden');
                }, 500);
            }, 3000); 
        }
    </script>

    <script src='https://storage.ko-fi.com/cdn/scripts/overlay-widget.js'></script>
    <script>
        kofiWidgetOverlay.draw('catpawzzz', {
            'type': 'floating-chat',
            'floating-chat.donateButton.text': 'Support me',
            'floating-chat.donateButton.background-color': '#794bc4',
            'floating-chat.donateButton.text-color': '#fff'
        });
    </script>
</body>

</html>