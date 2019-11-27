#include <DHT.h>
#include <DHT_U.h>

/* CREATED BY Chris Wycoff see chriswycoff.com for more details on the author */

//IMPORTANT MODIFY lines 25, 26, 29, 95, 96 (and possibly more) to fit your specific credentials

/* Credit to for much of the connectivity logic:
 * HTTP Client GET Request
 * Copyright (c) 2018, circuits4you.com
 * All rights reserved.
 * https://circuits4you.com 
 * Connects to WiFi HotSpot. */

#define DHTPIN D6 
#define DHTTYPE DHT11
#include <ESP8266WiFi.h>
#include <WiFiClient.h> 
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>

//initialize DHT
DHT dht(DHTPIN, DHTTYPE);
 
/* Set these to your desired credentials. */
const char *ssid = "NAME OF WIFI HERE";  //ENTER YOUR WIFI NETWORK NAME
const char *password = "password HERE"; //WIFI PASSWORD SPOT
 
//Web/Server address to read/write from 
const char *host = "yourwebsite.site";   //website or IP address of server MODIFY TO YOUR SPECS
char fan;
char heat;
char water;
char door;
const char on_off = '1';
char to_do_list[1000];
 
//=======================================================================
//                    Power on setup
//=======================================================================
 
void setup() {
  // pins to use D1(fan), D2(heat), D4(water), D5(door)
  delay(1000);
  Serial.begin(9600);
  pinMode(D6,INPUT); // begin pin input mode
  
  pinMode(D1,OUTPUT);// begin pin output mode   (fan)
  pinMode(D2,OUTPUT); // begin pin output mode (heat)
  pinMode(D4,OUTPUT); // begin pin output mode (water)
  pinMode(D5,OUTPUT); // begin pin output mode (door)
  
  WiFi.mode(WIFI_OFF);        //Prevents reconnection issue (taking too long to connect)
  delay(1000);
  WiFi.mode(WIFI_STA);        //This line hides the viewing of ESP as wifi hotspot
  
  WiFi.begin(ssid, password);     //Connect to your WiFi router
  Serial.println("");
 
  Serial.print("Connecting");
  // Wait for connection
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
 
  //If connection successful show IP address in serial monitor
  Serial.println("");
  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());  //IP address assigned to your ESP
}
 
//=======================================================================
//                    Main Program Loop
//=======================================================================
void loop() {
  //dht stuff
  //update temp and hum
  float hum = dht.readHumidity();
  float far = dht.readTemperature(true); //gets fahrenheit
  Serial.print("temp =");
  Serial.println(far);
  Serial.print("humidity =");
  Serial.println(hum);
  String far_string = String(far,2);
  String hum_string = String(hum,2);
  
  HTTPClient http;    //Declare object of class HTTPClient
 
  String ADCData, station, getData, Link;
  

  //GET Data // under the password section enter your password here to provide some level of security
  getData = "?unit=1&pass=ENTER_A_PASSWORD_HERE&hum=" + hum_string + "&temp=" + far_string ;  //Note "?" added at front
  Link = "http://yourwebsite.site/green_house/real_greenhouse/device_interact.php" + getData;
  

  //
  http.begin(Link);     //Specify request destination
  //http.addHeader("Content-Type", "text/plain");
  //int http
  
  int httpCode = http.GET();            //Send the request
  String payload = http.getString();    //Get the response payload
  
  payload.toCharArray(to_do_list, 1000);
  
  Serial.println(httpCode);   //Print HTTP return code
  Serial.println(payload);    //Print request response payload

  fan = to_do_list[4];
  heat = to_do_list[11];
  water = to_do_list[19];
  door = to_do_list[26];
  
  // pins to use D1(fan), D2(heat, D4(water), D5(door)
  
  if (fan == '1'){
  digitalWrite(D1,1);
 
  Serial.println("fan on");
  }else{
       
       digitalWrite(D1,0);
       
       }


  if (heat == '1'){
  
  digitalWrite(D2,1);
  Serial.println("heat on");
  }else{
       
       digitalWrite(D2,0);
       
       }

  if (water == '1'){
  
  digitalWrite(D4,1);
  Serial.println("water on");
  }else{
       
       digitalWrite(D4,0);
       
       }
       
  if (door == '1'){
  
  digitalWrite(D5,1);
  Serial.println("door open");
  }else{
       
       digitalWrite(D5,0);
       
       }


  
  http.end();  //Close connection

 
  delay(5000);  //GET Data at every 5 seconds
}
