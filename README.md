# Smart Farming Web Service
Smart Farming Web App
## Docs API

The following is the API documentation for using the Smart Farming Web App application.

### 1. Farmer Register
Use the following url to register a farmer. Use the POST method
```
http://domain/api/register
```
#### Send Request
```
```
#### Result
```
{
    "messages": " Petani baru berhasil ditambahkan",
    "success": true
}
```

### 2. Farmer Login
Use the following url to login a farmer. Use the POST method
```
http://domain/api/login
```
#### Send Request
```
{
    "username": "YOUR USERNAME",
    "password": "YOUR PASSWORD"
}
```
#### Result
```
{
    "success": true,
    "message": "Berhasil Login",
    "data": {
        "id": 1,
        "farmer_group_id": 1,
        "username": "ciko",
        "name": "Ciko Ciki Tita",
        "gender": "male",
        "phone": "085647823847",
        "email": "ciko@gmail.com",
        "birthplace": "Banyuwangi",
        "birthday": "2001-04-21",
        "land_area": 300,
        "address": "Banyuwangi",
        "serial_number": "088888888",
        "block": "N",
        "status": "approve",
        "created_at": "2021-05-28T07:06:03.000000Z",
        "updated_at": "2021-05-28T07:06:15.000000Z"
    },
    "_token": "2|nIPy9hsjutzMAyOQugHxvyKzPeuF8skdUgIez6Uz"
}
```

### 3. Farmer Logout
Use the following url to logout a farmer. Use the GET method
```
http://domain/api/logout
```
#### Result
```
{
    "messages": "Berhasil logout",
    "success": true,
    "token": null
}
```

### 4. Get Farmer Group Data
Use the following url to find all farmer groups. Use the GET method
```
http://domain/api/farmer-groups
```
#### Result
```
{
    "data": [
        {
            "id": 1,
            "name": "Kelompok Tani Ngundi Lestari",
            "chairman": "Supratman",
            "year_formed": 2020,
            "address": "Banyuwangi",
            "latitude": "-8.193727695708944",
            "longitude": "114.37659274261682",
            "created_at": "2021-05-28T07:05:26.000000Z",
            "updated_at": "2021-05-28T07:05:26.000000Z"
        }
    ],
    "success": true
}
```

### 5. On Off Lamp
Use the following url to update the light status (on / off). Use POST method.
You can use this feature when you are logged in.
```
http://domain/api/lamp-status-update
```
#### Send Request
```
{
    "serial_number": "YOUR SERIAL NUMBER"
}
```
#### Result
```
{
    "messages": "Control berhasil diperbarui",
    "success": true,
    "condition": 1
}
```

### 6. Save Sensor Data to the Database
Use the following url to save sensor data to the database. Use the POST method.
This URL is used on Arduino.
```
http://domain/api/sensor-store
```
#### Send Request
```
{
    "serial_number": "YOUR SERIAL NUMBER",
    "temperature": "TEMPERATURE DATA",
    "humidity": "HUMIDITY DATA",
    "voltage": "VOLTAGE DATA",
    "current": "CURRENT DATA",
    "power": "POWER DATA"
}
```
#### Result
```
{
    "messages": " Success",
    "success": true,
    "condition": 1
}
```

### 7. Get Lamp Status 
Use the following url to get the lamp status in the database. If condition is 1 then the lamp is on, if condition is 0 then the lamp is off. Use POST method.
This URL is used on Arduino.
```
http://domain/api/sensor-store
```
#### Send Request
```
{
    "serial_number": "YOUR SERIAL NUMBER"
}
```
#### Result
```
{
    "condition": 1,
    "success": true
}
```

### 8. Get Sensor History
Use the following url to get all sensor history based on the serial number you sent. Use GET method. You can use this feature when you are logged in.
```
http://domain/api/sensor-histories/YOUR_SERIAL_NUMBER/getSensorHistory
```
#### Result
```
{
    "data": [
        {
            "id": 1,
            "serial_number": "088888888",
            "temperature": "100.00",
            "humidity": "200.00",
            "voltage": "200.00",
            "current": "200.00",
            "power": "200.00",
            "created_at": "2021-05-28T07:07:04.000000Z",
            "updated_at": "2021-05-28T07:07:04.000000Z"
        },
        {
            "id": 2,
            "serial_number": "088888888",
            "temperature": "30.00",
            "humidity": "30.00",
            "voltage": "30.00",
            "current": "30.00",
            "power": "30.00",
            "created_at": "2021-05-28T07:07:51.000000Z",
            "updated_at": "2021-05-28T07:07:51.000000Z"
        }
    ],
    "success": true
}
```
### 9. Get Temperature and Humidity
Use the following url to get temperature and humidity based on the serial number you sent. Use GET method. You can use this feature when you are logged in.
```
http://domain/api/sensor/YOUR_SERIAL_NUMBER/getTemperatureHumidity
```
#### Result
```
{
    "data": {
        "id": 1,
        "serial_number": "088888888",
        "temperature": "30.00",
        "humidity": "30.00",
        "voltage": "30.00",
        "current": "30.00",
        "power": "30.00",
        "created_at": "2021-05-28T07:06:36.000000Z",
        "updated_at": "2021-05-28T09:30:27.000000Z"
    },
    "success": true
}
```

### 10. Update Farmer Profile
Use the following url to update farmer profile. You can use this feature when you are logged in. Use POST method.
```
http://domain/api/farmers/YOUR_ID_FARMER/update
```
#### Send Request
```
{
    "name": "YOUR NAME",
    "gender": "male/female",
    "phone": "YOUR PHONE NUMBER",
    "email": "YOUR EMAIL",
    "birthplace": "BIRTHPLACE",
    "birthday": "1987-09-",
    "land_area": "2000",
    "address": "Songgon, Banyuwangi"
}
```
#### Result
```
{
    "messages": " Petani baru berhasil diubah",
    "success": true
}
```

### 11. Update Password
Use the following url to change your password. You can use this feature when you are logged in. Use POST method.
```
http://domain/api/farmers/change-password
```
#### Send Request
```
{
    "current_password": "YOUR OLD PASSWORD",
    "new_password": "YOUR NEW PASSWORD",
    "confirm_password": "CONFIRMATION PASSWORD"
}
```
#### Result
```
{
    "messages": "Password berhasil diubah",
    "success": true
}
```
