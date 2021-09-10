from src.parser.text_extractor.docx import extract_text_from_doc
from src.parser.text_extractor.pdf import extract_text_from_pdf
import os


def extract_text_from_document(document_path):

    text_file = os.path.join(os.path.dirname(document_path) , document_path.split("/")[-1].split(".")[0] + ".txt")

    if os.path.exists(text_file):
        with open(document_path.split(".")[0] + ".txt", "r") as infile:
            data = infile.read()
        return data

    text = ""
    if document_path.endswith(".pdf"):
        for page in extract_text_from_pdf(document_path):
            text += ' ' + page
    elif document_path.endswith(".docx"):
        text = extract_text_from_doc(document_path)

    text = text.lower()
    with open(text_file, "w") as outfile:
        outfile.write(text)

    return text

