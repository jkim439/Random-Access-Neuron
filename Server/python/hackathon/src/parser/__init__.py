from src.parser.name_extractor import extract_name_with_rules
from src.parser.text_extractor import extract_text_from_document
from src.parser.phone_number_extractor import extract_phone_number_with_multiple_expressions
from src.parser.email_extractor import extract_email_with_regular_expression_v1
from src.parser.skills_extractor import extract_skills_with_word_tokenization
from src.parser.education_extractor import extract_education_with_database_search
from src.parser.experience_extractor import extract_experiences_from_sentence_analyzer
from src.parser.major_extractor import extract_major_with_database_search

def extract_resume_info(file):

    text = extract_text_from_document(file)

    name = extract_name_with_rules(text)
    phone = extract_phone_number_with_multiple_expressions(text)
    email = extract_email_with_regular_expression_v1(text)
    skills = extract_skills_with_word_tokenization(text)
    majors = extract_major_with_database_search(text)
    #computer_skills = extract_computer_skills_with_database_search(text)
    educations = extract_education_with_database_search(text)
    experiences = extract_experiences_from_sentence_analyzer(file)

    data = {
            "name":name,
            "phone":phone,
            "email":email,
            "skills":skills,
            "majors":majors,
            #"computer_skills":computer_skills,
            "educations":educations,
            "experiences":experiences
            }

    # print("NAME: " ,name)
    # print("PHONE: ", phone)
    # print("EMAIL: ", email)
    # print("SKILLS", skills)
    # print("MAJORS",majors)
    # #print("COMPUTER SKILLS",computer_skills)
    # print("EDUCATIONS",educations)
    # print("EXPERIENCES",experiences)
    return data

