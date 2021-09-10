import nltk
import sys
nltk.download("stopwords")
from src.parser import extract_resume_info
from src.environment import RESUME_PATH
import os
import json

file = sys.argv[1]

if file.endswith(".pdf") or file.endswith(".docx"):
    print(json.dumps(extract_resume_info(os.path.join(RESUME_PATH,file))))