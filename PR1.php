<?php

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $apiKey = 'AIzaSyDp8KYawOhF7cWSneuGNLTnO2D9mXCn2tY';
    $cx = '56a9d004278b942fa';
    $url = "https://www.googleapis.com/customsearch/v1?key={$apiKey}&cx={$cx}&q={$search}";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
<?php

// Function to sanitize user input
function sanitizeInput($input) {
  // Remove HTML tags and special characters
  $output = htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
  // Remove any potential SQL injection attempts
  $output = str_replace("'", "", $output);
  $output = str_replace("\"", "", $output);
  return $output;
}

// Function to format a date string
function formatDate($dateString) {
  $date = new DateTime($dateString);
  return $date->format('F j, Y');
}

if (isset($_GET['search'])) {
    // Sanitize the user input
    $search = sanitizeInput($_GET['search']);
    // Set API key and CX
    $apiKey = 'YOUR_API_KEY';
    $cx = 'YOUR_CX';
    // Construct the search URL
    $url = "https://www.googleapis.com/customsearch/v1?key={$apiKey}&cx={$cx}&q={$search}";
    // Send a cURL request to the Google Custom Search API
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    if ($response === false) {
        echo 'Error: ' . curl_error($curl);
    } else {
        // Decode the JSON response
        $data = json_decode($response, true);
        if (is_null($data)) {
            echo 'Error: Failed to decode JSON response';
            var_dump($response);
        } elseif (array_key_exists('items', $data)) {
            $items = $data['items'];
        } else {
            echo 'Error: No items found in response';
            var_dump($data);
        }
    }

    curl_close($curl);

    var_dump($response); // added for debugging

    if (!isset($data)) {
        $data = "";
    }

    if (is_array($data) && array_key_exists('items', $data)) {
        $items = $data['items'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<h2>My Browser</h2>
<form method="GET" action="index.php">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search" value=""><br><br>
    <input type="submit" value="Submit">
</form>

<?php

if (isset($items)) {
    foreach ($items as $item) {
        echo '<h3>' . $item['title'] . '</h3>';
        echo '<p>' . $item['snippet'] . '</p>';
        echo '<p>Published on ' . formatDate($item['displayLink']) . '</p>';
        echo '<a href="' . $item['link'] . '">Read more</a><br><br>';
    }
}

?>

</body>
</html>
