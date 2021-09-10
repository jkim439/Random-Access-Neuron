import requests
import json

URL = "https://a9ggu5sjge.execute-api.us-east-2.amazonaws.com/first_deploy/student/parsed-info"
response = requests.get(URL)

print(response.status_code)
print(response.text)

dictionary = json.loads(response.text)


result_list = list(json.loads(dictionary['body']))

print(result_list[0])
print(result_list[0][0])
print(result_list[0][1])