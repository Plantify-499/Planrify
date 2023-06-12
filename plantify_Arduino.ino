#include <DHT.h>         // Include Adafruit DHT11 Sensors Library
#define ledpin  12
#define waterpump   8
#define fan  2 
#define DHTPIN 4
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);
#define lm35  A1
#define soil  A2
#define waterLevel A0
#define light A4


void setup () {
  dht.begin();
  pinMode(ledpin, OUTPUT);
  pinMode(fan , OUTPUT);
  pinMode(waterpump , OUTPUT);
  digitalWrite(waterpump , HIGH);
  digitalWrite(fan , HIGH);

  Serial.begin(9600);
}

void loop () {

  float hum = dht11Humditiy();
  float temp = dht11temp();
  float LMtemp = LM35temp();
  float Soil = SoilMoisture();
  float lightINt = light_intensity();
  float waterlvl = WaterLEVEL();

  String dhtData = String(hum) + "," + String(temp) + "," + String(LMtemp) + "," + String (Soil) + "," + String(lightINt) + "," + String(waterlvl);
  Serial.println(dhtData);





  if (Soil < 15) {
    digitalWrite(waterpump, LOW);
    delay(3000);
        digitalWrite(waterpump, HIGH);
  delay(2000);
    if (Soil > 40) {
      digitalWrite(waterpump, HIGH);

    }
  }
  if (hum > 60 ) {
    digitalWrite(fan , LOW);
  }


  if (Serial.available() > 0) {
    Serial.println();
    char inputFromNodeRed = Serial.read();


    if (inputFromNodeRed == '4') {
      digitalWrite(ledpin, HIGH);
    } if (inputFromNodeRed == '5') {
      digitalWrite(ledpin, LOW);
    }

    if (inputFromNodeRed == '1') {
      digitalWrite(waterpump, LOW);

    } if ( inputFromNodeRed == '0') {
      digitalWrite(waterpump, HIGH);
    }
    if ( inputFromNodeRed == '2') {
      digitalWrite(fan , LOW);
    }
    if ( inputFromNodeRed == '3') {
      digitalWrite(fan , HIGH);
    }



  }
  delay(250);

}



float dht11Humditiy() {
  float H = dht.readHumidity();
  
  return H ;

}
float dht11temp() {
  float T = dht.readTemperature();

  
  return T ;

}

float LM35temp() {
  //Read Raw ADC Data
  int analog_data = analogRead(lm35);
  if(isnan(analog_data)){
      return -1 ;
  }
  // Convert that ADC Data into voltage
  float voltage = analog_data * (5.0 / 1024.0);

  // Convert the voltage into temperature
  float lm_temp = voltage * 100;

  return lm_temp;
}

float SoilMoisture() {

  int analog_data = analogRead(soil);
   if(isnan(analog_data)){
      return -1 ;
  }
  float moisture_percentage = ( 100 - ( (analog_data / 1023.00) * 100 ) );
  return moisture_percentage;

}

float WaterLEVEL() {
  int minWaterLevel = 56;
  int maxWaterLevel = 93;
  float analog_data = analogRead(waterLevel);
   if(isnan(analog_data)){
      return -1 ;
  }

  float percentage = map(analog_data, minWaterLevel, maxWaterLevel, 0, 100);

  return percentage ;
}

float  light_intensity() {
  int minLight = 0;
  int maxLight = 600;
  float analog_data = analogRead(light);
     if(isnan(analog_data)){
      return -1 ;
  }
  float Light_percentage = map(analog_data, minLight, maxLight, 0, 100);


  return Light_percentage ;
}
