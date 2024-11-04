<!DOCTYPE html>
<html>
<head>
    <title>Peys App</title>
    <style>
        .photo-container {
            margin-top: 20px;
            text-align: left;
        }
        .photo {
            border-style: solid;
            display: inline-block;
        }
    </style>
</head>
<body>

    <h1>Peys App</h1>
    <form id="settingsForm" method="POST" action="javascript:void(0);">
        <label for="photo_size">Select Photo Size:</label>
        <input type="range" id="photo_size" name="photo_size" min="10" max="100" step="10" value="60">
        <span id="size_label">60</span>px<br><br>

        <label for="border_color">Select Border Color:</label>
        <input type="color" id="border_color" name="border_color" value="#000000"><br><br>

        <button type="button" id="processButton">Process</button>
    </form>

    <div class="photo-container">
        <img src="images/Lawrence.JPG" alt="Photo" id="photo" class="photo" style="width: 60px; height: 60px; border-color: #000000; border-width: 2px;">
    </div>

    <script>
        // Select elements by ID
        const sizeInput = document.getElementById('photo_size');
        const colorInput = document.getElementById('border_color');
        const sizeLabel = document.getElementById('size_label');
        const photo = document.getElementById('photo');
        const processButton = document.getElementById('processButton');

        // Event listener for the button click to apply settings
        processButton.addEventListener('click', () => {
            const size = sizeInput.value;
            const color = colorInput.value;

            // Apply the chosen size and border color
            photo.style.width = `${size}px`;
            photo.style.height = `${size}px`;
            photo.style.borderColor = color;

            // Update the size label
            sizeLabel.textContent = size;
        });
    </script>

</body>
</html>
