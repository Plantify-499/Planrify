import time
import uuid

import numpy as np
import argparse
import os
import tensorflow as tf
from PIL import Image
from io import BytesIO
import glob
import matplotlib.pyplot as plt

from object_detection.utils import ops as utils_ops
from object_detection.utils import label_map_util
from object_detection.utils import visualization_utils as vis_util

import mysql.connector
# create connection object
mysqlCon = mysql.connector.connect(
    host="localhost", user="root",
    password="", database="plantify")

# create cursor object
mysqlObj = mysqlCon.cursor()

# patch tf1 into `utils.ops`
utils_ops.tf = tf.compat.v1

# Patch the location of gfile
tf.gfile = tf.io.gfile


def load_model(model_path):
    model = tf.saved_model.load(model_path)
    return model


def load_image_into_numpy_array(path):
    """Load an image from file into a numpy array.

    Puts image into numpy array to feed into tensorflow graph.
    Note that by convention we put it into a numpy array with shape
    (height, width, channels), where channels=3 for RGB.

    Args:
      path: a file path (this can be local or on colossus)

    Returns:
      uint8 numpy array with shape (img_height, img_width, 3)
    """
    img_data = tf.io.gfile.GFile(path, 'rb').read()
    image = Image.open(BytesIO(img_data))
    (im_width, im_height) = image.size
    return np.array(image.getdata()).reshape(
        (im_height, im_width, 3)).astype(np.uint8)


def run_inference_for_single_image(model, image):
    # The input needs to be a tensor, convert it using `tf.convert_to_tensor`.
    input_tensor = tf.convert_to_tensor(image)
    # The model expects a batch of images, so add an axis with `tf.newaxis`.
    input_tensor = input_tensor[tf.newaxis, ...]

    # Run inference
    output_dict = model(input_tensor)

    # All outputs are batches tensors.
    # Convert to numpy arrays, and take index [0] to remove the batch dimension.
    # We're only interested in the first num_detections.
    num_detections = int(output_dict.pop('num_detections'))
    output_dict = {key: value[0, :num_detections].numpy()
                   for key, value in output_dict.items()}
    output_dict['num_detections'] = num_detections

    # detection_classes should be ints.
    output_dict['detection_classes'] = output_dict['detection_classes'].astype(np.int64)

    # Handle models with masks:
    if 'detection_masks' in output_dict:
        # Reframe the the bbox mask to the image size.
        detection_masks_reframed = utils_ops.reframe_box_masks_to_image_masks(
            output_dict['detection_masks'], output_dict['detection_boxes'],
            image.shape[0], image.shape[1])
        detection_masks_reframed = tf.cast(detection_masks_reframed > 0.5, tf.uint8)
        output_dict['detection_masks_reframed'] = detection_masks_reframed.numpy()

    return output_dict


def run_inference(model, category_index, image_path):

    if os.path.isdir(image_path):
        image_paths = []
        for file_extension in ('*.png', '*jpg'):
            image_paths.extend(glob.glob(os.path.join(image_path, file_extension)))
        for i_path in image_paths:
            #### Extract the user_id through the name of file (the number before)
            # Find the index of "uploads\" and "_"
            start_index = i_path.find("uploads\\") + len("uploads\\")
            end_index = i_path.find("_")
            # Extract the substring
            user_id = i_path[start_index:end_index]
            ####
            image_np = load_image_into_numpy_array(i_path)
            # Actual detection.
            output_dict = run_inference_for_single_image(model, image_np)
            # Visualization of the results of a detection.
            image_np,detected_classes = vis_util.visualize_boxes_and_labels_on_image_array(
                image_np,
                output_dict['detection_boxes'],
                output_dict['detection_classes'],
                output_dict['detection_scores'],
                category_index,
                instance_masks=output_dict.get('detection_masks_reframed', None),
                use_normalized_coordinates=True,
                line_thickness=8)


            """The existing plt lines do not work on local pc as they are not setup for GUI
                Use plt.savefig() to save the results instead and view them in a folder"""
            #str(list)
            TextForDetectedClasses = "".join(str(detected_classes))
            # Remove single quotes
            TextForDetectedClasses = TextForDetectedClasses.replace("'", "")
            # Remove square brackets
            TextForDetectedClasses = TextForDetectedClasses.replace("[", "").replace("]", "")
            plt.imshow(image_np)
            # plt.show()
            if not os.path.exists('C:/xamppP/htdocs/Plantify/proccessed_images'):
                os.makedirs('proccessed_images')
            file_name = 'proccessed_images/'+str(uuid.uuid4())+'.png'
            plt.savefig("C:/xamppP/htdocs/Plantify/"+file_name)  # make sure to make an outputs folder
            # assign data query
            query1 = """INSERT INTO proceeded_images (user_id, image_path, detected_classes) VALUES (%d,'%s','%s')""" % (int((user_id)),file_name,TextForDetectedClasses)

            # executing cursor
            mysqlObj.execute(query1)
            mysqlCon.commit()


if __name__ == '__main__':
    parser = argparse.ArgumentParser(description='Detect objects inside webcam videostream')
    parser.add_argument('-m', '--model', type=str, required=True, help='Model Path')
    parser.add_argument('-l', '--labelmap', type=str, required=True, help='Path to Labelmap')
    parser.add_argument('-i', '--image_path', type=str, required=True, help='Path to image (or folder)')
    args = parser.parse_args()

    detection_model = load_model(args.model)
    category_index = label_map_util.create_category_index_from_labelmap(args.labelmap, use_display_name=True)
    input_folder_path = "C:\\xamppP\\htdocs\\Plantify\\uploads\\"
    output_folder_path = "C:\\xamppP\\htdocs\\Plantify\\proccessed_images\\"


    while True:
        # Get the list of files in the folder
        input_initial_count = os.listdir(input_folder_path)
        output_initial_count = os.listdir(output_folder_path)

        # Check if the number of files has increased
        if len(input_initial_count) > 0:
            print("New file added!")
            # Update the initial count to the current count
            run_inference(detection_model, category_index, args.image_path)
            #Will enter the loop before complition of run_inference
            while True:
                # Get the updated list of files in the folder
                input_files = os.listdir(input_folder_path)
                output_files = os.listdir(output_folder_path)

                # it length of proceeded images's folder == length of itself before analysis + length of uploaded images :
                if(len(output_files) == len(output_initial_count)+len(input_files)):
                    # Delete files on the folder after detection
                    for file_name in input_files:
                        file_path = os.path.join(input_folder_path, file_name)
                        try:
                            if os.path.isfile(file_path):
                                os.unlink(file_path)
                                print(f"{file_path} deleted successfully")
                            else:
                                print(f"{file_path} is not a file")
                        except Exception as e:
                            print(f"Error: {e}")
                    output_initial_count = len(output_files)
                    break


        # Wait for 1 second before checking again
        time.sleep(1)

    # closing cursor connection
    mysqlObj.close()

    # closing connection object
    mysqlCon.close()



# Command to start script
#  python .\detect_from_images_website.py -m C:\Users\nawwa\Desktop\BasilLemonMango_Model\new_model\content\inference_graph\saved_model\ -l .\labelmap.pbtxt -i C:\xamppP\htdocs\Plantify\uploads
