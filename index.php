<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
            background-color: #f4f4f4;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }
        .gallery img {
            width: 100%;
            max-width: 300px;
            height: auto;
            margin: 10px;
            border: 3px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
        }
        .button-container {
            margin: 20px 0;
        }
        .button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Image Gallery</h1>

    <div class="gallery">
        <img src="https://picsum.photos/seed/picsum/536/354" alt="Image 1" data-id="1">
        <img src="https://picsum.photos/seed/picsum/536/354" alt="Image 2" data-id="2">
        <img src="https://picsum.photos/seed/picsum/536/354" alt="Image 3" data-id="3">
        <img src="https://picsum.photos/seed/picsum/536/354" alt="Image 4" data-id="4">
    </div>

    <div class="button-container">
        <button id="detailsButton" class="button">Details</button>
        <button id="locateButton" class="button">Locate on Google Map</button>
    </div>

    <script>
        $(document).ready(function() {
            var selectedImageId = null;

            // Click event for gallery images
            $('.gallery img').on('click', function() {
                selectedImageId = $(this).data('id');
                $('.gallery img').removeClass('selected');
                $(this).addClass('selected');
            });

            // Click event for Details button
            $('#detailsButton').on('click', function() {
                if (selectedImageId !== null) {
                    $.ajax({
                        url: 'get_coordinates.php',
                        type: 'POST',
                        data: { id: selectedImageId },
                        success: function(response) {
                            $('#response').html('Coordinates: ' + response);
                        },
                        error: function() {
                            $('#response').html('Failed to get details.');
                        }
                    });
                } else {
                    $('#response').html('Please select an image first.');
                }
            });

            // Click event for Locate on Google Map button
            $('#locateButton').on('click', function() {
                if (selectedImageId !== null) {
                    $.ajax({
                        url: 'get_coordinates.php',
                        type: 'POST',
                        data: { id: selectedImageId },
                        success: function(response) {
                            var coords = response.split(',');
                            if (coords.length === 2) {
                                var latitude = coords[0];
                                var longitude = coords[1];
                                window.open(`https://www.google.com/maps?q=${latitude},${longitude}`, '_blank');
                            } else {
                                $('#response').html('Invalid coordinates.');
                            }
                        },
                        error: function() {
                            $('#response').html('Failed to get coordinates.');
                        }
                    });
                } else {
                    $('#response').html('Please select an image first.');
                }
            });
        });
    </script>
</body>
</html>
