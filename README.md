# Smart Farming Web Service
Smart Farming Web App
## Docs API

The following is the API documentation for using the Smart Farming Web App application.

The following is a brief guide on how to use the API:

- [Farmer Register](#1-farmer-register)
- [Farmer Login](#2-farmer-login)
- [Farmer Logout](#3-farmer-logout)
- [Get Farmer Group Data](#4-get-farmer-group-data)
- [On Off Lamp](#5-on-off-lamp)
- [Save Sensor Data to the Database](#6-save-sensor-data-to-the-database)
- [Get Lamp Status](#7-get-lamp-status)
- [Get Sensor History](#8-get-sensor-history)
- [Get Temperature and Humidity](#9-get-temperature-and-humidity)
- [Update Farmer Profile](#10-update-farmer-profile)
- [Update Password](#11-update-password)
- [Validation Format Result](#12-validation-format-result)

### 1. Farmer Register
Use the following url to register a farmer. Use the POST method
```
http://domain/api/register
```
#### Send Request
```
{
    "farmer_group_id": "FARMER GROUP ID",
    "name": "FARMER NAME",
    "username": "FARMER USERNAME",
    "password": FARMER PASSWORD,
    "phone": "FARMER PHONE",
    "email": "FARMER EMAIL",
    "land_area": "FARMER LAND AREA",
    "serial_number": "FARMER SERIAL NUMBER"
}
```
#### Result
```
{
    "messages": "Petani baru berhasil ditambahkan",
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
        "farmer_group_id": FARMER GROUP ID,
        "username": "USERNAME",
        "name": "FARMER NAME",
        "gender": "male/female",
        "phone": "PHONE NUMBER",
        "email": "FARMER EMAIL",
        "birthplace": "FARMER BIRTHPLACE",
        "birthday": "FARMER BIRTHDAY",
        "land_area": FARMER LAND AREA,
        "address": "FARMER ADDRESS",
        "serial_number": "FARNMER SERIAL NUMBER",
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
            "id": FARMER GROUP ID,
            "name": "FARMER GROUP NAME",
            "chairman": "CHAIRMAN",
            "year_formed": YEAR FORMED,
            "address": "FARMER GROUP ADDRESS",
            "latitude": "LATITUDE",
            "longitude": "LONGITUDE",
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
    "birthday": "BOIRTHDAY",
    "land_area": "LAND AREA",
    "address": "ADDRESS"
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

### 12. Validation Format Result
Here is the error validation format, this error will fail when the request fails.

#### Result
```
{
    "messages": {
        "farmer_group_id": [
            "The farmer group id field is required."
        ],
        "username": [
            "The username field is required."
        ],
        "password": [
            "The password field is required."
        ],
        "name": [
            "The name field is required."
        ],
        "phone": [
            "The phone field is required."
        ],
        "email": [
            "The email field is required."
        ],
        "land_area": [
            "The land area field is required."
        ],
        "serial_number": [
            "The serial number field is required."
        ]
    },
    "success": false
}
```
