import requests
import json
import time

from config import SERVER_IP, SERVER_PORT, SENSOR_API

url = 'http://' + SERVER_IP + SERVER_PORT + SENSOR_API

data = {
    "sensor_id": 3,
    "value":  10.03,
    "error_message": None,
    "value_type": "Nm"
}

response = requests.post(url, data=json.dumps(data))