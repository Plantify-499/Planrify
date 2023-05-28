#include <DHT.h>         // Include Adafruit DHT11 Sensors Library
int ledpin = 12;
int waterpump =  8;
int fan = 2 ;
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

  analogRead(A0);
  String dhtData = String(hum) + "," + String(temp) + "," + String(LMtemp) + "," + String (Soil) + "," + String(lightINt) + "," + String(waterlvl);
  Serial.println(dhtData);




//
//  if (Soil < 15) {
//    digitalWrite(waterpump, LOW);
//    delay(5000);
//        digitalWrite(waterpump, HIGH);
//
//    if (Soil > 40) {
//      digitalWrite(waterpump, HIGH);
//
//    }
//  }
  if (hum > 60 ) {
    digitalWrite(fan , LOW);
  }


  if (Serial.available() > 0) {
    Serial.println();
    char inputFromPython = Serial.read();


    if (inputFromPython == 'A' || inputFromPython == '5') {
      digitalWrite(ledpin, HIGH);
    } if (inputFromPython == 'B' || inputFromPython == '4') {
      digitalWrite(ledpin, LOW);
    }

    if (inputFromPython == 'C' || inputFromPython == '1') {
      digitalWrite(waterpump, LOW);

    } if (inputFromPython == 'D' || inputFromPython == '0') {
      digitalWrite(waterpump, HIGH);
    }
    if (inputFromPython == 'E' || inputFromPython == '2') {
      digitalWrite(fan , LOW);
    }
    if (inputFromPython == 'F' || inputFromPython == '3') {
      digitalWrite(fan , HIGH);
    }



  }
  delay(250);

}



float dht11Humditiy() {
  float H = dht.readHumidity();
  String Hum = String (H) ;
  return H ;

}
float dht11temp() {
  float T = dht.readTemperature();
  String temp = String (T) ;
  return T ;

}

float LM35temp() {
  //Read Raw ADC Data
  int adcData = analogRead(lm35);
  // Convert that ADC Data into voltage
  float voltage = adcData * (5.0 / 1024.0);

  // Convert the voltage into temperature
  float tt = voltage * 100;

  // String Lmtemp = String(tt);
  return tt;
}

float SoilMoisture() {

  int sensor_analog = analogRead(soil);
  float moisture_percentage = ( 100 - ( (sensor_analog / 1023.00) * 100 ) );
  String s = String(moisture_percentage);
  return moisture_percentage;

}

float WaterLEVEL() {
  int minWaterLevel = 0;
  int maxWaterLevel = 1023;
  float waterlevel = analogRead(waterLevel);

  float percentage = map(waterLevel, minWaterLevel, 510, 0, 100);

  return waterlevel ;
}

float  light_intensity() {
  int minLight = 0;
  int maxLight = 1023;

  float lightread = analogRead(light);
  float Light_percentage = map(lightread, minLight, maxLight, 0, 100);


  return Light_percentage ;
}
