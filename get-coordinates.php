<?php
function getGpsCoordinates($imagePath) {
    // Check if the file exists
    if (!file_exists($imagePath)) {
        return "File does not exist.";
    }

    // Read EXIF data from the image
    $exif = exif_read_data($imagePath);
    
    echo "<pre>";
    print_r( $exif );

    // Check if EXIF data contains GPS information
    if (isset($exif['GPSLatitude']) && isset($exif['GPSLongitude'])) {
        $latitude  = $exif['GPSLatitude'];
        $longitude = $exif['GPSLongitude'];
        $latRef = isset($exif['GPSLatitudeRef']) ? $exif['GPSLatitudeRef'] : 'N';
        $lonRef = isset($exif['GPSLongitudeRef']) ? $exif['GPSLongitudeRef'] : 'E';

        // Convert coordinates to decimal format
        $latitude = convertToDecimal($latitude, $latRef);
        $longitude = convertToDecimal($longitude, $lonRef);

        return ['latitude' => $latitude, 'longitude' => $longitude];
    } else {
        return "No GPS data available.";
    }
}

function convertToDecimal($coordinate, $ref) {
    if (!is_array($coordinate) || count($coordinate) != 3) {
        return null;
    }

    // Convert coordinates from degrees, minutes, seconds to decimal format
    $degrees = $coordinate[0];
    $minutes = $coordinate[1];
    $seconds = $coordinate[2];

    $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);

    // Adjust for direction
    if ($ref == 'S' || $ref == 'W') {
        $decimal = -$decimal;
    }

    return $decimal;
}

// Example usage
$imagePath = 'images/pload-image.jpg'; // Update this path
$coordinates = getGpsCoordinates($imagePath);

if (is_array($coordinates)) {
    echo "Latitude: " . $coordinates['latitude'] . "<br>";
    echo "Longitude: " . $coordinates['longitude'] . "<br>";
} else {
    echo $coordinates;
}
?>
