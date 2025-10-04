from config import *
from sensor_control import sensor_data_control
#from communication_control import send_sensor_data
import time



while(True):

    #Gathering sensor data
    sensorDataJsons = []
    for sensor in SENSORS:
        sensorDatas = sensor_data_control.CreateSensorData(sensor)
        for sensorData in sensorDatas:
            sensorDataJsons.append(sensorData.createJson())

    print(sensorDataJsons)

    #Sending HTTP post of sensors
    #session_control = send_sensor_data.SensorSessionControl()
    #for sensorDataJson in sensorDataJsons:
    #    session_control.postSensorMessage(sensorDataJson, SERVER_IP + SENSOR_API)
    #del session_control

    time.sleep(DATA_SEND_FRQ)