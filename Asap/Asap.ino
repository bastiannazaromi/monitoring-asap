#include <Arduino.h> // Library arduino

// Servo
#include <Servo.h>
Servo servo;

// Library Wifi
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>

#define USE_SERIAL Serial
ESP8266WiFiMulti WiFiMulti;
HTTPClient http;

// Sensor MQ-2
#include <MQ2.h>

#define sensorMQ2 A0
int lpg, co, asap;
MQ2 mq2(sensorMQ2);

// Sensor DHT
#include <DHT.h>

#define DHTPIN D4
#define DHTTYPE DHT22

DHT dht(DHTPIN, DHTTYPE);

int before_suhu = 25;
int before_kelembapan = 70;

// Relay
#define relay_ionizer D3
#define relay_off HIGH
#define relay_on LOW

boolean pewangi = false;
int loop_pewangi = 0, counter = 0;

// Alamat pengiriman data
String simpan = "http://192.168.43.239/monitoring-asap/Data/save?suhu=";

String respon;

void setup() {
  Serial.begin(115200);
  USE_SERIAL.begin(115200);
  USE_SERIAL.setDebugOutput(false);
  
  for(uint8_t t = 3; t > 0; t--) {
      USE_SERIAL.printf("[SETUP] Tunggu %d...\n", t);
      USE_SERIAL.flush();
      delay(1000);
  }

  WiFi.mode(WIFI_STA);
  WiFiMulti.addAP("Project", "12345678");

  for (int u = 1; u <= 5; u++)
  {
    if ((WiFiMulti.run() == WL_CONNECTED))
    {
      USE_SERIAL.println("Wifi conected");
      USE_SERIAL.flush();
      delay(1000);
    }
    else
    {
      Serial.println("Wifi disconected");
      delay(1000);
    }
  }

  Serial.print("IP address : ");
  Serial.println(WiFi.localIP());

  servo.attach(D5);
  servo.write(0);

  pinMode(relay_ionizer, OUTPUT);
  digitalWrite(relay_ionizer, relay_off);
  
  mq2.begin();
  dht.begin();
  
}
void loop() {
  float* values = mq2.read(true);
  lpg = mq2.readLPG();
  co = mq2.readCO();
  asap = mq2.readSmoke();

  lpg = lpg / 50;
  co = co / 70;
  asap = asap / 50;

  if (lpg < 0 || co < 0 || asap < 0)
  {
    lpg = 0; co = 0; asap = 0;
  }
  if (lpg > 100 || co > 100 || asap > 100)
  {
    lpg = 100; co = 100; asap = 100;
  }

  // baca sensor suhu
  int suhu = dht.readTemperature();
  int kelembapan = dht.readHumidity();
  if (suhu > 50)
  {
    suhu = before_suhu;  
  }
  else
  {
    before_suhu = suhu;
  }
  if (kelembapan < 0 || kelembapan > 100)
  {
    kelembapan = before_kelembapan;
  }
  else
  {
    before_kelembapan = kelembapan;
  }

  Serial.print("Suhu : ");
  Serial.println(suhu);
  Serial.print("Kelembapan : ");
  Serial.println(kelembapan);
  Serial.print("LPG : ");
  Serial.println(lpg);
  Serial.print("CO : ");
  Serial.println(co);
  Serial.print("Asap : ");
  Serial.println(asap);

  // kirim ke database
  if ((WiFiMulti.run() == WL_CONNECTED))
  {
    http.begin( simpan + (String) suhu + "&kelembapan=" + (String) kelembapan + "&asap=" + (String) asap );
    
    USE_SERIAL.print("[HTTP] Menyimpan data ke database ...\n");
    int httpCode = http.GET();

    if(httpCode > 0)
    {
      USE_SERIAL.printf("[HTTP] kode response GET : %d\n", httpCode);

      if (httpCode == HTTP_CODE_OK)
      {
        respon = http.getString();
        USE_SERIAL.println("Respon : " + respon);
        
        delay(200);
      }
    }
    else
    {
      USE_SERIAL.printf("[HTTP] GET data gagal, error: %s\n", http.errorToString(httpCode).c_str());
    }
    http.end();
  }

  if (asap > 20)
  {
    digitalWrite(relay_ionizer, relay_on);
    Serial.println("Ionizer Menyala");

    counter = 1;
    pewangi = true;
  }
  else
  {
    digitalWrite(relay_ionizer, relay_off);
    Serial.println("Ionizer Mati");

    if (counter == 1)
    {
      if (pewangi == true)
      {
        Serial.println("Pewangi menyemprot");
        servo.write(90);
        delay(1500);
        servo.write(0);

        pewangi = false;
      }
    }
    
  }
  
  delay(1000);
}
