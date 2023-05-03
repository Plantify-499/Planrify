# Plantify

## Description

Plantify is a machine learning project that uses TensorFlow to identify different species of plants (Basil-Lemon-Mango).

## Installation

To use Plantify, you will need to install TensorFlow. Here are the installation steps:

1. Install Anaconda: Visit the Anaconda website and download the version that is compatible with your operating system. Follow the installation instructions.

2. Create a new Anaconda environment: Open Anaconda Prompt or your terminal and type the following command to create a new environment named "tensorflow":

    `conda create --name tensorflow`

3. Activate the environment: Type the following command to activate the environment:

    `conda activate tensorflow`

4. Install TensorFlow: Type the following command to install TensorFlow:

    `pip install tensorflow`

5. Verify the installation: Type the following command to verify that TensorFlow is installed correctly:

    `python -c "import tensorflow as tf; print(tf.reduce_sum(tf.random.normal([1000, 1000])))"`

   If the installation was successful, this command should output a random number.

6. Set up TensorFlow Directory and Anaconda Virtual Environment:

    - Create a new directory: Create a new directory where you will store your TensorFlow projects.

    - Create a new Anaconda environment: Open Anaconda Prompt or your terminal and type the following command to create a new environment named "tensorflow_project":

        `conda create --name tensorflow_project`

    - Activate the environment: Type the following command to activate the environment:

        `conda activate tensorflow_project`

    - Install TensorFlow: Type the following command to install TensorFlow in the new environment:

        `pip install tensorflow`

    - Verify the installation: Type the following command to verify that TensorFlow is installed correctly:

        `python -c "import tensorflow as tf; print(tf.reduce_sum(tf.random.normal([1000, 1000])))"`

       If the installation was successful, this command should output a random number.

    - Change directory: Change your current directory to the new directory you created in step 1.

        `cd path/to/your/new/directory`

    - Create a new Python file: Create a new Python file in the new directory and start coding your TensorFlow project.

## Usage

python .\detect_from_images.py -m C:\path\to\the\model\content\inference_graph\saved_model\ -l .\labelmap.pbtxt -i C:\path/to/images/folder


## Contributing

If you'd like to contribute to Plantify, please follow these guidelines:
- Fork the repository
- Create a new branch for your feature or bug fix
- Make your changes and write tests to cover your changes
- Submit a pull request
