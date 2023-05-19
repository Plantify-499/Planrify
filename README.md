# Plantify

## Description

This repository contains the source code for a comprehensive web application that combines plant analysis and care functionalities. The system enables users to register, log in, and upload images of plant leaves for analysis. Using TensorFlow model, the application accurately detects the type of plant leaf among mango, basil, and lemon varieties.

Once the analysis is complete, users can view the results on the intuitive `results.php` page. They have the option to download the analyzed results or remove the uploaded photo. Additionally, the application offers valuable advice and guidance for nurturing and growing the identified plants, which can be found on the dedicated `plant_care.php` page.

The system also includes an admin dashboard, providing administrators with privileged access to manage users, control their privileges, and create new accounts. Administrators can effortlessly modify plant care information, add new plants to the system, and effectively handle messages received from users through the `contact.php` page. Additionally, the dashboard provides real-time monitoring of environmental factors such as temperature, humidity, and soil moisture, obtained via an Arduino Uno device integrated into the plant. The sensor data is seamlessly retrieved through the ThingSpeak API.

## Installation and Setup

Please follow the steps below to set up the Plant Analysis and Care System:

1. Clone the repository to your local machine.
2. Set up XAMPP and ensure it is running properly.
3. Place the cloned repository in the `htdocs` directory of your XAMPP installation.
4. Create a MySQL database using the provided SQL file.
5. Configure the database connection in the appropriate files (e.g., `config.php`, `db.php`).
6. Install the required dependencies for the TensorFlow model and ensure it is properly set up.
7. Configure the ThingSpeak API for accessing sensor data from the Arduino Uno device.
8. Start the XAMPP web server.
9. Run `detect_from_images_website.py` on the server to continuously check the `uploads` folder for new images and perform the analysis. Make sure the script is running before any analysis is expected.
10. Access the application through a web browser by navigating to the local URL where it is hosted (e.g., `http://localhost/Plantify`).

## Usage

1. Sign up for a new account or log in if you already have one.
![Sign in page](relative_path_to_image)
2. Upload a photo of a plant leaf using the `upload.php` page.
![Alt Text](relative_path_to_image)
3. Wait for the server-side script (`detect_from_images_website.py`) to detect and analyze the uploaded photo.
![Python file is running](../Documents/detect_from_images_website.png)
4. Access the `results.php` page to view the analysis results for the uploaded photo.
![Results](relative_path_to_image)
5. Explore the admin dashboard to manage users, plant care information, messages, and sensor data.
![Admin Dashboard](relative_path_to_image)

## Contributing

If you'd like to contribute to Plantify, please follow these guidelines:
- Fork the repository
- Create a new branch for your feature or bug fix
- Make your changes and write tests to cover your changes
- Submit a pull request
