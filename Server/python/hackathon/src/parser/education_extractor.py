import csv
import spacy
import os
from src.environment import DATA_PATH
import pickle

with open(os.path.join(DATA_PATH,"institutions.pkl"), 'rb') as f:
    list_institutions = pickle.load(f)

nlp = spacy.load('en_core_web_sm')



def extract_education_with_database_search(resume_text):


    educations = []
    for institution in list_institutions:
        index = resume_text.find(institution)
        if(index != -1):
            educations.append(institution)


    return educations[0:1]
