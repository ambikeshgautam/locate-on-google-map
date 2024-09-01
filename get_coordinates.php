<?php
// Dummy data for demonstration; replace with actual data source
$coordinates = [
    1 => ['lat' => '37.7749', 'lng' => '-122.4194'], // Example coordinates for image ID 1
    2 => ['lat' => '34.0522', 'lng' => '-118.2437'], // Example coordinates for image ID 2
    3 => ['lat' => '40.7128', 'lng' => '-74.0060'],  // Example coordinates for image ID 3
    4 => ['lat' => '41.8781', 'lng' => '-87.6298'],  // Example coordinates for image ID 4
];

// Retrieve the image ID from the request
$imageId = $_POST['id'] ?? null;

// Check if the image ID exists in the coordinates array
if ($imageId !== null && isset($coordinates[$imageId])) {
    $lat = $coordinates[$imageId]['lat'];
    $lng = $coordinates[$imageId]['lng'];
    echo $lat . ',' . $lng; // Return coordinates as a comma-separated string
} else {
    echo 'Coordinates not found.';
}
?>
