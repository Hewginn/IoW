import sys
import os
import json
import onnxruntime as ort
import numpy as np
import cv2

# Getting the path to the model and to the image
image_path = sys.argv[1]
full_image_path = os.path.join("/var/www/storage/app/private", image_path)
onnx_model_path = "/var/www/machine_vision/weights/best_18.onnx"


# Load ONNX model
session = ort.InferenceSession(onnx_model_path, providers=["CPUExecutionProvider"])

class_names = ["Black Rot", "Downy Mildew", "Esca", "Healthy", "Leaf Blight", "Powdery Mildew"]

# Load and preprocess image
img = cv2.imread(full_image_path)
img = cv2.resize(img, (608, 608))
img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
img = img.astype(np.float32) / 255.0
img = np.transpose(img, (2, 0, 1))  # HWC → CHW
img = np.expand_dims(img, 0)        # Add batch dimension

inputs = {session.get_inputs()[0].name: img}

# Run inference
outputs = session.run(None, inputs)
probs = outputs[0].squeeze()

results = {
    class_names[i]: float(probs[i])
    for i in range(len(probs))
}

if probs.max() < 0.7:
    results["result"] = "Can't make prediction"
else:
    results["result"] = class_names[np.argmax(probs)]

# Sending back result to php server
print(json.dumps(results))
