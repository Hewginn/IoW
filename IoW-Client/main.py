from config import *
from node_control import sensor_data_control
from communication_control import send_sensor_data
import time

#Initiating Node: Check in db, update, authenticate...

#Initiating Sensors: Check in db, update
sensors = [
    sensor_data_control.DHT11(SENSORS["DHT11"]),
    sensor_data_control.GUVAS12SD(SENSORS["GUVAS12SD"])
]

while(True):

    #Gathering sensor data
    sensorMessages = []
    for sensor in sensors:
        sensorMessages += sensor.createMessages()

    print(sensorMessages)

    #Sending HTTP post of sensors
    session_control = send_sensor_data.SensorSessionControl()
    for sensorMessage in sensorMessages:
        session_control.postSensorMessage(sensorMessage, "http://" + SERVER_IP + SENSOR_API)
    del session_control

    time.sleep(DATA_SEND_FRQ)