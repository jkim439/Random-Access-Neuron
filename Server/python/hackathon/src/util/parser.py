from pyresparser import ResumeParser
import os
import json
from src.environment import RESUME_PATH
from src.database import runsql

resume_path = os.path.join(DATA_PATH,"resume")

id = 0

for file in os.listdir(resume_path):
    filePath = os.path.join(resume_path,file)
    data = ResumeParser(filePath,skills_file=os.path.join(DATA_PATH,"skills.csv")).get_extracted_data()

    statement = """insert into student values(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"""

    values = list(data.values())

    values.insert(0,id)

    tmp = []
    for val in values:
        if isinstance(val,list):
            tmp.append(json.dumps(val))
        else:
            tmp.append(val)


    print(tuple(tmp))

    for each in tuple(values):
        print(type(each),end='')

    runsql(statement,tuple(tmp))
    id += 1