#This file contains the device specific configurations. Should be modified when adding a new device.

#Addresses for the server
SERVER_IP = '192.168.0.157:29083'
SENSOR_API = '/api/send_data'

#ID of the node
NODE_ID = 1

#The implemented sensors
#In case of implementing a new sensors the following files should be updated:
#   sensor_data_control.py
#   sensor_specs.py
SENSORS = [
    {
        "sensor_id": 1,
        "name": "DHT11",
        "type" : "temperature and humidity",
        "value_type": [
            "humidity",
            "temperature",
        ]
    },
    {
        "sensor_id": 2,
        "name": "GUVAS12SD",
        "type": "UV",
        "value_type": [
            "UV",
        ],
    },
]

#The frequency of sending HTTP posts
DATA_SEND_FRQ = 60 