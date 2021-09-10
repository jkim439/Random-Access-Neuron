import pyresparser

def extract_experiences_from_sentence_analyzer(file):

    data = pyresparser.ResumeParser(file).get_extracted_data()
    return data["experience"]