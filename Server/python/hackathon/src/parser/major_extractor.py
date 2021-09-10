import spacy
import os
from src.environment import DATA_PATH
import pickle

with open(os.path.join(DATA_PATH,"majors.pkl"), 'rb') as f:
    list_major = pickle.load(f)

nlp = spacy.load('en_core_web_sm')


def extract_major_with_database_search(resume_text):


    majors = []
    for major in list_major:
        index = resume_text.find(major)
        if(index != -1):
            majors.append(major)


    return majors
