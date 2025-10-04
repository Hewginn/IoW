import requests
import json

class SensorSessionControl():
    def __init__(self):

        #Setting up session
        self.session = requests.Session()
        self.session.headers.update({
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        })


    def postSensorMessage(self, payload, url):

        #Sending HTTP post
        response = self.session.post(url, json=payload)

        # Print response
        print(response.status_code)
        print(response.json())