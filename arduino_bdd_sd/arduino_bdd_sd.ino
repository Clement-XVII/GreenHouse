#include <SPI.h>
#include <Ethernet.h>
#include <DHT.h>
#include <OneWire.h>
#include <DallasTemperature.h>
#include <SD.h>  
#include <Wire.h>
#include <rgb_lcd.h>

//****************************************************************//
#define DHTPIN A12
#define DHTTYPE DHT22
DHT dht(DHTPIN, DHTTYPE);
//****************************************************************//
#define ONE_WIRE_BUS A0
OneWire oneWire(ONE_WIRE_BUS);            //<--- sonde
DallasTemperature sensors(&oneWire);
//****************************************************************//
rgb_lcd lcd;
//****************************************************************//
int moistPin = A6;
int moistValue;                     //<--- humsol
int moistVal = 0;
int humsol = 0;
//****************************************************************//
const int chipSelect = 4;
const float VRefer = 3.3;       //<--- O2
const int pinAdc   = A2;
//****************************************************************//
#define         MG_PIN                       (A4)     //define which analog input channel you are going to use
#define         BOOL_PIN                     (2)
#define         DC_GAIN                      (8.5)   //define the DC gain of amplifier
#define         READ_SAMPLE_INTERVAL         (50)    //define how many samples you are going to take in normal operation
#define         READ_SAMPLE_TIMES            (5)     //define the time interval(in milisecond) between each samples in
#define         ZERO_POINT_VOLTAGE           (0.220) //define the output of the sensor in volts when the concentration of CO2 is 400PPM
#define         REACTION_VOLTGAE             (0.030) //define the voltage drop of the sensor when move the sensor from air into 1000ppm CO2
float           CO2Curve[3]  =  {2.602,ZERO_POINT_VOLTAGE,(REACTION_VOLTGAE/(2.602-3))};
//****************************************************************//
byte mac[] = {
  0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
  
IPAddress ip(192,168,1,201);
//IPAddress ip(xxx,xxx,xxx,xxx); //-> Ip de l'arduino

char server[] = "83.193.161.228";                                     //->Ip du serveur
//char server[] = "xxx.xxx.xxx.xxx";

EthernetClient client;

void setup() {
 
  // Serial.begin lance la connexion série entre l'ordinateur et l'Arduino.
  Serial.begin(9600);
  lcd.begin(16, 2);
  dht.begin();
  sensors.begin();
  pinMode(4, OUTPUT); // broche d'alimentation de la sonde
  digitalWrite(4, LOW);
  pinMode(A14,INPUT);

Serial.print("Initializing SD card...");
if (!SD.begin(chipSelect)) {
Serial.println("Card failed, or not present");
return;
}
  pinMode(BOOL_PIN, INPUT);                        //set pin to input
    digitalWrite(BOOL_PIN, HIGH);                    //turn on pullup resistors    //<--- CO2
 
  // start the Ethernet connection
  Ethernet.begin(mac, ip);
    
}

void loop() {
 
  
  float h = dht.readHumidity();
  float t = dht.readTemperature();
  float f = dht.readTemperature(true);
  float hi = dht.computeHeatIndex(f, h);
  float hc = dht.convertFtoC(hi);
  //****************************************************************//
  float sondetemp = sensors.getTempCByIndex(0);
  sensors.requestTemperatures();
//****************************************************************//
  digitalWrite(4, LOW);
  for(int temporisation = 0; temporisation <= 0 ; temporisation = temporisation+1) // mettre 86400 !
  {
    delay(500); // cette boucle for protège la sonde car ne fait qu'une mesure par 24h
  }

  digitalWrite(4, HIGH); // met la sonde sous tension
  moistVal = analogRead(moistPin);
  humsol = Conversion(moistVal);
//****************************************************************//
float Vout =0;
    Vout = readO2Vout();
//****************************************************************//
int gas;
    float volts;

    volts = MGRead(MG_PIN);

    gas = MGGetPercentage(volts,CO2Curve);

//****************************************************************//
int ldr=analogRead(A14);  //<-----LDR
//****************************************************************//
  Serial.print("DHT22 : ");
  Serial.println(t); //<---dht22
  Serial.println(h); //<---dht22
  Serial.println(hc); //<---dht22
  Serial.print("humsol : ");
  Serial.println(humsol); //<--- humidite sol
  Serial.print("sonde temp : ");
  Serial.println(sondetemp); //<---sonde
  Serial.print("CO2 : ");
  Serial.println(gas);  //<----- CO2
  Serial.print("O2 : "); 
  Serial.println(gaso()); //<----- O2
  Serial.print("LDR : ");
  Serial.println(ldr);
  Serial.println("OK");

  File sdcard_file = SD.open("data.txt", FILE_WRITE);
    if (sdcard_file) {
    sdcard_file.print("Temperature en Celsius: ");
    sdcard_file.print(t);sdcard_file.println(" C;");
    sdcard_file.print("Humidite: ");
    sdcard_file.print(h);sdcard_file.println(" %;");
    sdcard_file.print("Indice de chaleur: ");
    sdcard_file.print(hc);sdcard_file.println(" C;");
    sdcard_file.print("Humidite du sol: ");
    sdcard_file.print(humsol);sdcard_file.println(" %;");
    sdcard_file.print("Sonde temperature: ");
    sdcard_file.print(sondetemp);sdcard_file.println(" C;");
    sdcard_file.print("CO2: ");
    sdcard_file.print(gas);sdcard_file.println(" ppm;");
    sdcard_file.print("O2: ");
    sdcard_file.print(gaso());sdcard_file.println(" %;");
    sdcard_file.print("LDR: ");
    sdcard_file.print(ldr);sdcard_file.println(" LUX;");
    sdcard_file.println();
    sdcard_file.println();
    sdcard_file.close();
    }  
    else {
    Serial.println("error opening data.txt");
    } 
  

  
 
  // Connect to the server (your computer or web page)  
  if (client.connect(server, 31320)) {
    client.print("GET /writedata2.php?"); // This
    client.print("temp="); // This
    client.print(t); //print de la variable dans la requête GET
    client.print("&hum=");
    client.print(h); //print de la variable dans la requête GET
    client.print("&hc=");
    client.print(hc);
    client.print("&humsol=");
    client.print(humsol);
    client.print("&sondetemp=");
    client.print(sondetemp);
    client.print("&gas=");
    client.print(gas);
    client.print("&gas2=");
    client.print(gaso());
    client.print("&ldr=");
    client.print(ldr);
    client.println(" HTTP/1.1"); // Partie de la demande GET
    client.println("Host: 83.193.161.228");   //->Ip du serveur
    //client.println("Host: xxx.xxx.xxx.xxx");   //->Ip du serveur
    client.println("Connection: close"); // Partie de la demande GET indiquant au serveur que nous avons terminé de transmettre le message
    client.println(); 
    client.println(); 
    client.stop();    // Fermeture de la connexion au serveur

  }

  else {
    // Si l'Arduino ne peut pas se connecter au serveur
    Serial.println("--> connection failed\n");
  }
  
  lcd.setCursor(5, 0);
  lcd.print("DHT 22");
  delay(3000); 
  lcd.clear();

  lcd.setCursor(0, 0);
  lcd.print("Humidity: ");
  lcd.print(h);
  lcd.print("%");
  lcd.setCursor(0,1);
  lcd.print("TempAir: "); 
  lcd.print(t);
  lcd.write( (char)223);
  lcd.print("C");
  delay(5000);
  lcd.clear();
  
  lcd.setCursor(3,0);
  lcd.print("HeatIndex:");
  lcd.setCursor(4,1);
  lcd.print(hc);
  lcd.write( (char)223);
  lcd.print("C");
  delay(5000);
  lcd.clear();

  lcd.setCursor(2,0);
  lcd.print("Temperature");
  lcd.setCursor(2,1);
  lcd.print("Sensor Probe");
  delay(3000);
  lcd.clear();
  lcd.print("Temp: ");
  lcd.print(sondetemp);
  lcd.write((char)223);
  lcd.print("C");
  delay(5000);
  lcd.clear();

  lcd.setCursor(7,0);
  lcd.print("O2");
  lcd.setCursor(3,1);
  lcd.print("Gas Sensor");
  delay(3000);
  lcd.clear();
  lcd.print("O2: ");
  lcd.print(gaso());
  lcd.print("%");
  delay(5000);
  lcd.clear();

  lcd.setCursor(1,0);
  lcd.print("CO2 Gas Sensor");
  lcd.setCursor(5,1);
  lcd.print("SEN0159");
  delay(3000);
  lcd.clear();
  lcd.print("CO2: ");
  lcd.print(gas);
  lcd.print("ppm");
  delay(5000);
  lcd.clear();

  lcd.setCursor(6,0);
  lcd.print("LDR");
  lcd.setCursor(1,1);
  lcd.print("Photoresistor");
  delay(3000);
  lcd.clear();
  lcd.print("LDR: ");
  lcd.print(ldr);
  lcd.print(" lux");
  delay(10000);
  lcd.clear();
  //delay(1800000);
}
int Conversion(int value){
 int ValeurPorcentage = 0;
 ValeurPorcentage = map(moistVal, 1023, 0, 0, 100); //map (valeur, valeurbasse, valeurhaute, valeurbasse%, valeurhaute%)
 return ValeurPorcentage;
}



//***************************************************************//
float readO2Vout()
{
    long sum = 0;
    for(int i=0; i<32; i++)
    {
        sum += analogRead(pinAdc);
    }
 
    sum >>= 5;
 
    float MeasuredVout = sum * (VRefer / 1023.0);
    return MeasuredVout;
}
 
float gaso()
{
    // Vout samples are with reference to 3.3V
    float MeasuredVout = readO2Vout();
 
    //float Concentration = FmultiMap(MeasuredVout, VoutArray,O2ConArray, 6);
    //when its output voltage is 2.0V,
    float Concentration = MeasuredVout * 0.21 / 2.0;
    float Concentration_Percentage=Concentration*100;
    return Concentration_Percentage;
}

//******************************************************************//
float MGRead(int mg_pin)
{
    int i;
    float v=0;

    for (i=0;i<READ_SAMPLE_TIMES;i++) {
        v += analogRead(mg_pin);
        delay(READ_SAMPLE_INTERVAL);
    }
    v = (v/READ_SAMPLE_TIMES) *5/1024 ;
    return v;
}
int  MGGetPercentage(float volts, float *pcurve)
{
   if ((volts/DC_GAIN )>=ZERO_POINT_VOLTAGE) {
      return -1;
   } else {
      return pow(10, ((volts/DC_GAIN)-pcurve[1])/pcurve[2]+pcurve[0]);
   }
}
//******************************************************************//
