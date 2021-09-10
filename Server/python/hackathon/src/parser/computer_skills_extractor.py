import csv
import spacy
import os
from src.environment import DATA_PATH
import pickle

with open(os.path.join(DATA_PATH,"computer_skills.pkl"), 'rb') as f:
    list_computer_skills = pickle.load(f)

nlp = spacy.load('en_core_web_sm')



def extract_computer_skills_with_database_search(resume_text):


    computer_skills = []
    for computer_skill in list_computer_skills:
        index = resume_text.find(computer_skill)
        if(index != -1):
            computer_skills.append(computer_skill)


    return computer_skills
