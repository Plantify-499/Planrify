from flask import Flask, jsonify, request
import logging
import requests



url_thingSpeak = "https://api.thingspeak.com/update?api_key=N3YCREGBVZ54GB0X"
api_key = "N3YCREGBVZ54GB0X"

app = Flask(_name_)

@app.route('/out', methods=['POST'])
def my_http_output_node():
    data = request.get_json()
    humidity = data['humidity']
    temperature = data['temperature']
    lm_temp = data['lm_temp']
    soil = data['Soil_moiustre']
    light = data['Light']
    waterLevel = data['Water_Level']
    print(f"Humidity: {humidity}, Temperature: {temperature}, lm_temp: {lm_temp}, Soil moiustre : {soil}, Light intensity: {light}, Water level: {waterLevel}")
    data_to_send = {"field1": humidity, "field2": temperature,"field3": lm_temp , "field4":soil , "field5":waterLevel,"field6":light}
    response11 = requests.post(url_thingSpeak, data=data_to_send)

    if response11.status_code == 200:
            print("Data sent successfully to ThingSpeak!")
    else:
            print("Error sending data to ThingSpeak")
    
    # Initialize the logger
    logging.basicConfig(filename='logFile.log', level=logging.INFO , format='%(asctime)s %(levelname)s %(message)s')

    # Log the received data
    logging.info(f"Humidity: {humidity}%, Temperature: {temperature}C, lm_temp: {lm_temp}C, Soil moiustre : {soil}%, Light intensity: {light}%, Water level: {waterLevel}%")
    return jsonify({'status': 'success'})


if _name_ == '_main_':
    app.run(port=8000)
