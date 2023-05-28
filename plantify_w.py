import logging
import tkinter as tk
from flask import Flask, request
import requests
from tkinter import messagebox
import mysql.connector




url_led = "http://127.0.0.1:1880/led"
url_waterPump = "http://127.0.0.1:1880/water_pump"
url_fan = "http://127.0.0.1:1880/fan"

#thingSpeak

url_thingSpeak = "https://api.thingspeak.com/update?api_key=N3YCREGBVZ54GB0X"
api_key = "N3YCREGBVZ54GB0X"

# MySQL database configuration
config = {
  'user': 'root',
  'password': '', # Replace with your MySQL password
  'host': 'localhost',
  'database': 'plantify',
  'raise_on_warnings': True
}

# Connect to MySQL database
try:
    cnx = mysql.connector.connect(**config)
    print("Connected to MySQL database.")
except mysql.connector.Error as err:
    print("Error connecting to MySQL database: ", err)
    exit()

# Query the database and retrieve the data
def query_database():
    cursor = cnx.cursor()
    query = "SELECT * FROM cpit499 ORDER BY id DESC LIMIT 10"
    cursor.execute(query)
    data = cursor.fetchall()
    cursor.close()
    return data


app = Flask(__name__)

class App(tk.Frame):
    def __init__(self, master=None):
        super().__init__(master)
        self.master = master
        self.master.title("Plantify")
    
        self.create_widgets()
        
    def send_data(self,url, message):
        data = {"message": message}
        response = requests.post(url, json=data)

        if response.status_code == 200:
            print("Data sent successfully to Node-RED!")
        else:
            print("Error sending data to Node-RED")
  
   
    def toggle_led(self):
        led_state = self.led_var.get()
        new_led_state = not led_state
        self.led_var.set(new_led_state)

        if new_led_state:
            self.led.config(text="Led ON", bg="#00ff00")
            self.send_data(url_led, 'A')

        else:
            self.led.config(text="Led OFF", bg="#ff0000")
            self.send_data(url_led, 'B')
   
    def toggle_waterPump(self):
        waterPump_state = self.waterpump_var.get()
        new_waterPump_state = not waterPump_state
        self.waterpump_var.set(new_waterPump_state)  
            
        if new_waterPump_state:
            self.water_pump.config(text="Water Pump ON", bg="#00ff00")
            self.send_data(url_waterPump, 'C')
        else:
            self.water_pump.config(text="Water Pump OFF",  bg="#ff0000")
            self.send_data(url_waterPump, 'D')
        self.water_pump.config(state=tk.NORMAL)

    def disable_water_pump_button(self):
        self.water_pump.config(state=tk.DISABLED)
        messagebox.showinfo("Water pump disabled", "Water pump disabled due to high soil moisture")
        
        
    def toggle_fan(self):
        fan_state = self.fan_var.get()
        new_fan_state = not fan_state
        self.fan_var.set(new_fan_state)

        if new_fan_state:
            self.fan.config(text="Fan ON", bg="#00ff00")
            self.send_data(url_fan, "E")
        else:
            self.fan.config(text="Fan OFF", bg="#ff0000")
            self.send_data(url_fan, "F")
    
    
    def create_widgets(self):
        
        self.hum_label = tk.Label(self.master, text="Humidity: ", font=("Arial", 14))
        self.hum_label.pack(pady=20)
        self.hum_label.place(x=750 , y=15)
        
        self.temp_label = tk.Label(self.master, text="Temperature: ", font=("Arial", 14))
        self.temp_label.pack(pady=20)
        self.temp_label.place(x=950 ,y=15)
        
        self.lm_label = tk.Label(self.master, text="LM_temp: ", font=("Arial", 14))
        self.lm_label.pack(pady=20)
        self.lm_label.place(x=1150 , y=15)
        
        self.soil_label = tk.Label(self.master, text="Soil Moiustre: ", font=("Arial", 14))
        self.soil_label.pack(pady=20)
        self.soil_label.place(x=750 , y=80)
        
        self.light_label = tk.Label(self.master, text="Light Intensity: ", font=("Arial", 14))
        self.light_label.pack(pady=20)
        self.light_label.place(x=950 , y=80)
        
        self.water_lvl_label = tk.Label(self.master, text="Water Level: ", font=("Arial", 14))
        self.water_lvl_label.pack(pady=20)
        self.water_lvl_label.place(x=1150 ,y=80)
        
        self.led_var = tk.BooleanVar()
        self.led = tk.Button(self.master , text="led OFF", command=self.toggle_led ,font=("Ariel",16),bg="#ff0000")
        self.led.pack(padx= 20)
        self.led.place(x=800 , y=150)
        
        self.waterpump_var =tk.BooleanVar()
        self.water_pump = tk.Button(self.master , text="Water pump OFF", command=self.toggle_waterPump,font=("Ariel",16),bg="#ff0000")
        self.water_pump.pack(padx=20)
        self.water_pump.place(x=950 , y=150)
        
        self.fan_var= tk.BooleanVar()
        self.fan = tk.Button(self.master , text="Fan OFF", command=self.toggle_fan,font=("Ariel",16), bg="#ff0000" )
        self.fan.pack(padx=20)
        self.fan.place(x=1190 , y=150)
        
        button = tk.Button(self.master, text="Farm History", command=display_data, font=("Arial",16), bg="#cccccc")
        button.pack(pady=20)
        button.place(x=950 , y=400)
    
    def update_values(self, humidity=None,temperature=None , lm_temp = None , soil = None , light = None ,waterLevel =None ):
        
        if humidity is not None:
            self.hum_label.config(text="Humidity: {}%".format(humidity))
        
        if temperature is not None:
            self.temp_label.config(text="Temperature: {}C".format(temperature))
        
        if lm_temp is not None:
            self.lm_label.config(text="LM_temp: {}C".format(lm_temp),)
        
        if soil is not None:
            self.soil_label.config(text="Soil Moiustre: {}%".format(soil))
        
        if light is not None:
            self.light_label.config(text="Light intensty: {}%".format(light))
        
        if waterLevel is not None:
            self.water_lvl_label.config(text="Water Level: {}".format(waterLevel))
 
 
# Display farm data
def display_data():
    data = query_database()

    # Create a new window to display the data
    history_window = tk.Toplevel()
    history_window.title("Farm History")

    # Create a text box to display the data
    text_box = tk.Text(history_window , width=200 , height=30)
    text_box.pack()

    # Insert the data into the text box
    for row in data:
        row_str = "ID: {}, Humidity: {}%, Temperature: {}°C, LM_temp: {}°C, Soil Moisture: {}%, Water Level: {}%, Light Intensity: {}%, Date: {}\n\n".format(row[0], row[1], row[2], row[3], row[4], row[5], row[6], row[7])
        text_box.insert(tk.END, row_str)


    # Disable editing in the text box
    text_box.config(state=tk.DISABLED)           
                
            
app_gui = None

@app.route('/out', methods=['POST'])
def my_http_output_node():
    global app_gui

    data = request.get_json()
    humidity = data['humidity']
    temperature = data['temperature']
    lm_temp = data['lm_temp']
    soil = data['Soil_moiustre']
    light = data['Light']
    waterLevel = data['Water_Level']
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
   
    if app_gui is None:
        root = tk.Tk()
        root.geometry("1500x1500")
        app_gui = App(master=root)
        app_gui.pack()
        
        # Call the update() method before the mainloop() method
        app_gui.update()
        app_gui.mainloop()
    else:
        app_gui.update()
    # Call the update_values() method with the data values
    app_gui.update_values(humidity=humidity , temperature = temperature ,lm_temp=lm_temp , soil=soil , light=light , waterLevel=waterLevel)
    return 'Humidity data received!'


if __name__ == '__main__':
    app.run(port=8000)
