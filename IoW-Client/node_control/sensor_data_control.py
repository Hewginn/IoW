class Sensor():
    def __init__(self, sensor):
        self.is_online = sensor["is_online"]
        self.sensor_id = sensor["sensor_id"]
        self.values = sensor["value_type"]

    def createOfflineMessage(self):
        #Setting sensor status on server side in post
        pass
        
    def turnOff(self):
        #In case of error use this
        self.is_online = False

    def turnOnline(self):
        #Turn on sensor
        self.is_online = True

    def createMessages(self):
        if self.is_online:
            json = {
                "sensor_id": self.sensor_id,
                "value":  0,
                "error_message": "NOT DEFINED SENSOR",
                "value_type": "ERROR",
                "unit": "ERROR",
            }
            return [json]

class DHT11(Sensor):

    def __init__(self, sensor):
        super().__init__(sensor)
        self.name = "DHT11"

    def readData(self):
        self.humidity = 40
        self.temperature = 24

    def createMessages(self):
        self.readData()    

        temperature_message = {
            "sensor_id": self.sensor_id,
            "value":  self.temperature,
            "error_message": None,
            "value_type": "temperature",
            "unit": "C",
        }

        humidity_message = {
            "sensor_id": self.sensor_id,
            "value":  self.temperature,
            "error_message": None,
            "value_type": "humidity",
            "unit": "%",
        }

        return [temperature_message, humidity_message]
    
class GUVAS12SD(Sensor):

    def __init__(self, sensor):
        super().__init__(sensor)
        self.name = "GUVAS12SD"

    def readData(self):
        self.uv = 30

    def createMessages(self):
        self.readData()    

        uv_message = {
            "sensor_id": self.sensor_id,
            "value":  self.uv,
            "error_message": None,
            "value_type": "UV",
            "unit": "UV",
        }

        return [uv_message]



        
