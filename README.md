# ESP32 DHT22 IoT Dashboard

A beginner-friendly tutorial to connect an **ESP32** with a **DHT22 sensor** to measure temperature and humidity, store data in a **MySQL database** via a **REST API**, and display it on a **web dashboard**. This project is part of a hands-on learning series by **Yarana IoT Guru** on YouTube.

📺 **Tutorial Video (Hindi):**  
[ESP32 DHT22 + MySQL + Dashboard](https://youtu.be/EnGpFsDIons?si=d_i4WjDrf0Cq8Abw)  
![YouTube Thumbnail](https://img.youtube.com/vi/EnGpFsDIons/0.jpg)

🌐 **Live Dashboard:**  
[https://yaranaiotguru.in/tutorial/DHT/dht_sensor.php](https://yaranaiotguru.in/tutorial/DHT/dht_sensor.php)  
![Dashboard Screenshot](https://yaranaiotguru.in/tutorial/DHT/dashboard_screenshot.png)

🌐 **API Endpoint:**  
[https://yaranaiotguru.in/tutorial/DHT/](https://yaranaiotguru.in/tutorial/DHT/)

---

## 📌 Project Overview

This project builds an **IoT system** where an **ESP32** and **DHT22 sensor**:
- Collect temperature and humidity data.
- Send data to a **MySQL database** using a **PHP REST API** (HTTP POST).
- Display data on a **web dashboard** (HTTP GET).

Ideal for **beginners**, it covers hardware (ESP32 and DHT22) and software (PHP API, MySQL, and dashboard).

### 🎯 What You’ll Learn
- Interface a **DHT22 sensor** with an **ESP32**.
- Connect ESP32 to Wi-Fi and send **HTTP POST** requests.
- Create a **PHP REST API** for database operations.
- Set up a **MySQL database** for sensor data.
- Build a **web dashboard** for data visualization.

### 💡 Applications
- **Environmental Monitoring**: Track temperature/humidity in greenhouses or server rooms.
- **Smart Homes**: Control HVAC or humidifiers.
- **Data Logging**: Store data for analytics in agriculture or industry.

---

## 🛠️ Features
- **DHT22 Sensor**: Accurate temperature and humidity readings.
- **ESP32 Communication**: HTTP POST to MySQL database.
- **Web Dashboard**: Real-time and historical data visualization.
- **REST API**: PHP-based endpoints for DHT22 data.
- **Beginner-Friendly**: Clear video guide in Hindi.
- **Open-Source**: Free for educational use.

---

## 🧰 Tech Stack
| Component            | Description                                      |
|---------------------|--------------------------------------------------|
| **Microcontroller** | ESP32 (NodeMCU, DevKit, or any variant)          |
| **Sensor**          | DHT22 (temperature and humidity)                 |
| **Programming**     | Arduino IDE with C++                             |
| **Backend**         | PHP for REST API                                 |
| **Database**        | MySQL for data storage                           |
| **Frontend**        | Web dashboard (HTML, CSS, JavaScript, PHP)       |
| **Network**         | Wi-Fi for ESP32 connectivity                     |
| **Tools**           | XAMPP/WAMP for local PHP/MySQL testing           |

---

## 📂 Repository Contents
| Folder/File         | Description                                           |
|---------------------|-------------------------------------------------------|
| `/ESP32/`           | Arduino sketch for ESP32 with DHT22                   |
| `/api/`             | PHP scripts for API (e.g., `insert_data.php`)         |
| `/dashboard/`       | Dashboard files (e.g., `dht_sensor.php`)              |
| `/db/`              | SQL file (`database.sql`) for MySQL database          |
| `README.md`         | This documentation                                   |
| `LICENSE`           | MIT License for open-source usage                    |

---

## 🔗 API Endpoints
Hosted at [https://yaranaiotguru.in/tutorial/DHT/](https://yaranaiotguru.in/tutorial/DHT/).

| Method | Endpoint                        | Description                                  |
|--------|---------------------------------|----------------------------------------------|
| POST   | `/tutorial/DHT/insert_data.php` | Inserts temperature/humidity data to database |
| GET    | `/tutorial/DHT/dht_sensor.php`  | Displays data on web dashboard               |

### Example API Usage
1. **Insert Data (POST)**  
   ```http
   POST https://yaranaiotguru.in/tutorial/DHT/insert_data.php
   Content-Type: application/x-www-form-urlencoded
   Body: temperature=25.5&humidity=60.2
   ```
   **Response:**  
   ```json
   {"status": "success", "message": "Data inserted successfully"}
   ```

2. **View Dashboard (GET)**  
   ```http
   GET https://yaranaiotguru.in/tutorial/DHT/dht_sensor.php
   ```
   **Response:** Web dashboard with temperature/humidity data.

> ⚠️ **Note**: Hosted API/dashboard is for **educational use only**. Deploy locally or on a cloud server for production.

---

## 🛠️ Setup Instructions

### 📋 Prerequisites
- **Hardware**:
  - ESP32 board (e.g., NodeMCU ESP32)
  - DHT22 sensor (or DHT11, adjust `DHTTYPE`)
  - USB cable
  - Jumper wires, optional 4.7k–10k pull-up resistor
- **Software**:
  - [Arduino IDE](https://www.arduino.cc/en/software) (2.x+)
  - [XAMPP](https://www.apachefriends.org/) or [WAMP](http://www.wampserver.com/en/)
  - Web browser or [Postman](https://www.postman.com/)
- **Libraries** (Arduino IDE Library Manager):
  - `WiFi.h` (included with ESP32)
  - `HTTPClient.h` (included with ESP32)
  - `DHT.h` (Adafruit DHT sensor library)
- **Internet**:
  - Stable Wi-Fi
  - Local/cloud server (optional)

### 🚀 Steps
1. **MySQL Database Setup**:
   - Install XAMPP/WAMP, start Apache/MySQL.
   - Open phpMyAdmin (`http://localhost/phpmyadmin`).
   - Create database `iot_data`.
   - Import `/db/database.sql`:
     ```sql
     CREATE TABLE sensor_data (
         id INT AUTO_INCREMENT PRIMARY KEY,
         temperature FLOAT NOT NULL,
         humidity FLOAT NOT NULL,
         timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
     );
     ```
   - Update `/api/config.php`:
     ```php
     <?php
     $host = "localhost";
     $user = "root";
     $password = "";
     $database = "iot_data";
     $conn = mysqli_connect($host, $user, $password, $database);
     if (!$conn) {
         die("Connection failed: " . mysqli_connect_error());
     }
     ?>
     ```

2. **Deploy API and Dashboard**:
   - Copy `/api/` and `/dashboard/` to XAMPP/WAMP `htdocs` (e.g., `C:\xampp\htdocs\tutorial`).
   - Test:
     - API: `http://localhost/tutorial/DHT/insert_data.php` (POST in Postman).
     - Dashboard: `http://localhost/tutorial/DHT/dht_sensor.php`.
   - For cloud hosting, upload to server’s web root (e.g., `/var/www/html/`) and update ESP32 code URLs.

3. **Program ESP32 with DHT22**:
   - Install ESP32 board in Arduino IDE:
     - Add to **Preferences > Additional Boards Manager URLs**:
       ```
       https://raw.githubusercontent.com/espressif/arduino-esp32/master/package_esp32_index.json
       ```
     - Install `esp32` in **Boards Manager**.
   - Install `DHT.h` library (Adafruit).
   - Use this Arduino code:
     ```cpp
     #include <WiFi.h>
     #include <HTTPClient.h>
     #include "DHT.h"

     #define DHTPIN 4       // DHT sensor pin
     #define DHTTYPE DHT22  // or DHT11 if using DHT11

     const char* ssid = "your_wifi_ssid";
     const char* password = "your_wifi_password";
     const char* serverName = "https://yaranaiotguru.in/tutorial/DHT/insert_data.php";

     DHT dht(DHTPIN, DHTTYPE);

     void setup() {
       Serial.begin(115200);
       WiFi.begin(ssid, password);
       dht.begin();

       while (WiFi.status() != WL_CONNECTED) {
         delay(1000);
         Serial.println("Connecting to WiFi...");
       }
       Serial.println("Connected to WiFi");
     }

     void loop() {
       float temp = dht.readTemperature();
       float hum = dht.readHumidity();

       if (isnan(temp) || isnan(hum)) {
         Serial.println("Failed to read from DHT sensor!");
         return;
       }

       if (WiFi.status() == WL_CONNECTED) {
         HTTPClient http;
         http.begin(serverName);
         http.addHeader("Content-Type", "application/x-www-form-urlencoded");

         String postData = "temperature=" + String(temp) + "&humidity=" + String(hum);
         int httpResponseCode = http.POST(postData);

         Serial.print("HTTP Response code: ");
         Serial.println(httpResponseCode);
         Serial.println("Server response: " + http.getString());

         http.end();
       } else {
         Serial.println("WiFi disconnected");
       }
       delay(5000);
     }
     ```
   - Update `ssid`, `password`, and `serverName`.
   - Connect DHT22:
     - VCC → ESP32 3.3V
     - GND → ESP32 GND
     - DATA → ESP32 GPIO 4
     - Optional: 4.7k–10k resistor (VCC to DATA).
   - Select **ESP32 Dev Module** and port in Arduino IDE, then upload.

4. **Test System**:
   - Open Serial Monitor (115200 baud).
   - Check for `Connected to WiFi`, `HTTP Response code: 200`, or `Server response: {"status": "success"}`.
   - Verify data in phpMyAdmin (`sensor_data` table).
   - View dashboard at `http://localhost/tutorial/DHT/dht_sensor.php` or hosted URL.

### 📷 Circuit Diagram
```
ESP32         DHT22
3.3V  ----    VCC
GND   ----    GND
GPIO4 ----    DATA
      ----    4.7kΩ resistor (VCC to DATA)
```

---

## 📸 Screenshots
1. **Serial Monitor**:
   ```
   Connecting to WiFi...
   Connected to WiFi
   Temperature: 25.5°C, Humidity: 60.2%
   HTTP Response code: 200
   Server response: {"status": "success", "message": "Data inserted successfully"}
   ```

2. **MySQL Database (phpMyAdmin)**:
   - Table: `sensor_data`
   - Columns: `id` (auto-increment), `temperature` (float), `humidity` (float), `timestamp` (datetime)

3. **Dashboard**:
   - URL: [https://yaranaiotguru.in/tutorial/DHT/dht_sensor.php](https://yaranaiotguru.in/tutorial/DHT/dht_sensor.php)
   - Shows temperature/humidity in a table or graph.
   - ![Dashboard Screenshot](https://yaranaiotguru.in/tutorial/DHT/dashboard_screenshot.png)

4. **YouTube Thumbnail**:
   - ![YouTube Thumbnail](https://img.youtube.com/vi/EnGpFsDIons/0.jpg)

---

## 🛠️ Troubleshooting
| Issue                        | Solution                                                                 |
|------------------------------|--------------------------------------------------------------------------|
| ESP32 Wi-Fi failure          | Check SSID/password; ensure ESP32 is in Wi-Fi range; restart router.     |
| DHT22 reading failure        | Verify wiring; add pull-up resistor; check `DHTTYPE` in code.            |
| HTTP request failure         | Confirm API URL; ensure server is running; check ESP32 connectivity.     |
| MySQL connection error       | Verify `config.php` credentials; ensure MySQL is running.                |
| No data in database          | Check POST payload; verify table structure; test API in Postman.         |
| Dashboard not updating       | Ensure `dht_sensor.php` fetches data; check database connection.         |
| Arduino upload error         | Select correct board/port; install ESP32 package; check USB cable.       |

For more help, watch the [YouTube video](https://youtu.be/EnGpFsDIons?si=d_i4WjDrf0Cq8Abw) or comment there.

---

## 🙋‍♂️ About the Author
**Mr. Abhishek Maurya**  
Creator of **Yarana IoT Guru**, passionate about teaching IoT and electronics through hands-on projects.

- **YouTube**: [Yarana IoT Guru](https://www.youtube.com/@YaranaIoTGuru)
- **Website**: [https://yaranaiotguru.in](https://yaranaiotguru.in)
- **Email**: Contact via website

🔗 **Subscribe** for more IoT projects!

---

## 📃 License
Licensed under the **MIT License**. Free for educational/non-commercial use. See `LICENSE` file.

---

## 💬 Feedback & Contribution
- **Issues**: Report bugs or suggest improvements on the repository.
- **Pull Requests**: Contribute features or fixes.
- **Questions**: Comment on the [YouTube video](https://youtu.be/EnGpFsDIons?si=d_i4WjDrf0Cq8Abw).
- **Community**: Join the Yarana IoT Guru YouTube community.

✅ **Star ⭐ this repo** if it helped you!
