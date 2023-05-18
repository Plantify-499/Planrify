<?php

// Set maximum execution time to 5 minutes
ini_set('max_execution_time', 0);

// MySQL database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your MySQL password
$dbname = "plantify";

// ThingSpeak channel details
$channel_id = "2090610";
$field_hum = "1"; // Replace with the ID of the field you want to retrieve data for
$field_temp = "2";
$field_LM_temp = "3";
$field_Soil = "4";
$field_WaterLevel = "5";
$field_Light = "6";


$read_key = "MXCE7L7HZA5MAOJR";

// Function to fetch data from ThingSpeak and store it in MySQL database
function fetchDataAndStore() {
    // Fetch data from ThingSpeak
    global $channel_id, $field_hum, $field_temp , $field_LM_temp , $field_Soil ,  $field_WaterLevel ,$field_Light,$read_key;
    $url_hum = "https://api.thingspeak.com/channels/{$channel_id}/fields/{$field_hum}/last.json?api_key={$read_key}";
    $url_temp = "https://api.thingspeak.com/channels/{$channel_id}/fields/{$field_temp}/last.json?api_key={$read_key}";
    $url_LM_temp = "https://api.thingspeak.com/channels/{$channel_id}/fields/{$field_LM_temp}/last.json?api_key={$read_key}";
    $url_Soil = "https://api.thingspeak.com/channels/{$channel_id}/fields/{$field_Soil}/last.json?api_key={$read_key}";
    $url_WaterLevel = "https://api.thingspeak.com/channels/{$channel_id}/fields/{$field_WaterLevel}/last.json?api_key={$read_key}";
    $url_Light = "https://api.thingspeak.com/channels/{$channel_id}/fields/{$field_Light}/last.json?api_key={$read_key}";

    $data_hum = file_get_contents($url_hum);
    $data_hum = json_decode($data_hum, true);

    $data_temp = file_get_contents($url_temp);
    $data_temp = json_decode($data_temp , true);

    $data_LM_temp = file_get_contents($url_LM_temp);
    $data_LM_temp = json_decode($data_LM_temp , true);

    $data_Soil = file_get_contents($url_Soil);
    $data_Soil = json_decode($data_Soil , true);

    $data_WaterLevel = file_get_contents($url_WaterLevel);
    $data_WaterLevel = json_decode($data_WaterLevel , true);

    $data_Light = file_get_contents($url_Light);
    $data_Light = json_decode($data_Light , true);

    // Connect to MySQL database
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Store data in MySQL database
    $field_value_hum = $data_hum["field{$field_hum}"];
    $field_value_temp = $data_temp["field{$field_temp}"];
    $field_value_LM_temp = $data_LM_temp["field{$field_LM_temp}"];
    $field_value_Soil = $data_Soil["field{$field_Soil}"];
    $field_value_WaterLevel = $data_WaterLevel["field{$field_WaterLevel}"];
    $field_value_Light = $data_Light["field{$field_Light}"];


    $sql = "INSERT INTO monitoring_data (hum ,temp, lm , soil , water , light) VALUES ('$field_value_hum', '$field_value_temp' , '$field_value_LM_temp' , '$field_value_Soil' ,'$field_value_WaterLevel' ,'$field_value_Light' )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close MySQL connection
    $conn->close();
}

// Set the interval for fetching and storing data (in seconds)
$interval = 25; //every 10 second

// Loop indefinitely to fetch and store data at the specified interval
while (true) {
    fetchDataAndStore();
    sleep($interval);
}
