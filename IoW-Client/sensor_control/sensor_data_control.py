class SensorData():
    def __init__(self, sensor_id, value_type):
        self.sensor_id = sensor_id
        self.value_type = value_type

    #Dummy read_data function
    def read_data(self):
        self.value = 0
        self.unit = "UNIT"
        self.error_message = "TEST MESSAGE"

    def createJson(self):
        json = {
            "sensor_id": self.sensor_id,
            "value":  self.value,
            "error_message": self.error_message,
            "value_type": self.value_type,
            "unit": self.unit,
        }

        return json
        

class SensorData_DHT11(SensorData):
    def read_data(self, value_type):
        match value_type:
            case "temperature":
                self.value = 0
                self.unit = "C"
                self.error_message = None
            
            case "humidity":
                self.value = 0
                self.unit = "%"
                self.error_message = None

            case _:
                self.value = 0
                self.unit = "ERROR"
                self.error_message = "There is no such value type for this sensor."

    def __init__(self, sensor_id, value_type):
        super().__init__(sensor_id, value_type)
        self.read_data(value_type)

class SensorData_GUVAS12SD(SensorData):
    def read_data(self, value_type):
        match value_type:
            case "UV":
                self.value = 0
                self.unit = "C"
                self.error_message = None

            case _:
                self.value = 0
                self.unit = "ERROR"
                self.error_message = "There is no such value type for this sensor."

    def __init__(self, sensor_id, value_type):
        super().__init__(sensor_id, value_type)
        self.read_data(value_type)     

def CreateSensorData(sensor):

    sensorDatas = []

    match sensor["name"]:
        case "DHT11":

            for value_type in sensor["value_type"]:
                sensorDatas.append(SensorData_DHT11(sensor["sensor_id"], value_type))

        case "GUVAS12SD":

            for value_type in sensor["value_type"]:
                sensorDatas.append(SensorData_GUVAS12SD(sensor["sensor_id"], value_type))

    return sensorDatas