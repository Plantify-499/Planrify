<?php
$title = "Plant Care";
require_once 'template/header.php';
 ?>
 <!DOCTYPE html>
 <html>
 <head>
     <style>
         table {
             width: 100%;
             border-collapse: collapse;
         }

         th, td {
             padding: 8px;
             text-align: left;
             border-bottom: 1px solid #ddd;
         }
     </style>
 </head>
 <body>
     <?php

     // Fetch plant care information from the database
     $sql = "SELECT * FROM plant_care";
     $result = $mysqli->query($sql);

     if ($result->num_rows > 0) {
         // Display the plant care information in a table
         echo '<table>';
         echo '<tr><th>Plant Name</th><th>Climate</th><th>Soil</th><th>Sunlight</th><th>Watering</th><th>Pruning</th><th>Fertilizer</th><th>Protection</th><th>Resources</th></tr>';
         while ($row = $result->fetch_assoc()) {
             echo '<tr>';
             echo '<td>'.$row['plant_name'].'</td>';
             echo '<td>'.$row['climate'].'</td>';
             echo '<td>'.$row['soil'].'</td>';
             echo '<td>'.$row['sunlight'].'</td>';
             echo '<td>'.$row['watering'].'</td>';
             echo '<td>'.$row['pruning'].'</td>';
             echo '<td>'.$row['fertilizer'].'</td>';
             echo '<td>'.$row['protection'].'</td>';
             echo '<td> <a href="'.$row['resource'].'" target=_blank > Link </a></td>';
             echo '</tr>';
         }
         echo '</table>';
     } else {
         echo "No plant care information found.";
     }

     ?>
 </body>
 </html>
