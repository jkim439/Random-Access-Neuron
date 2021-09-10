import gensim, logging
from gensim.models import Word2Vec
import os
import pickle
from src.environment import RESUME_PATH,DATA_PATH
from nltk.tokenize import sent_tokenize,word_tokenize
from src.parser.text_extractor import extract_text_from_document
from src.parser.wikipedia_extractor import extract_wikipedia_with_noun_tokenization
import threading
from src.environment import RESUME_DATASET_PATH
from textblob import TextBlob

RESUME_PATH = RESUME_DATASET_PATH

make_dataset = True
store_dataset = True


if make_dataset:
    sentences = []
    for i,resume in enumerate(os.listdir(RESUME_PATH)):
        print(i,"/",len(os.listdir(RESUME_PATH)))
        if resume.endswith(".pdf") or resume.endswith(".docx"):
            file = os.path.join(RESUME_PATH, resume)
            text = extract_text_from_document(file).lower()
            lines = text.split("\n")

            for each_line in lines:
                each_line_in_token = word_tokenize(each_line)
                each_line_in_token = [x for x in each_line_in_token if '\\' not in x]
                sentences.append(each_line_in_token)

    sentences = [x for x in sentences if x]
    if store_dataset:
        with open("stored_dataset.pickle", 'wb') as f:
            pickle.dump(sentences, f)
else:
    with open("stored_dataset.pickle", 'rb') as f:
        sentences = pickle.load(f)


model = gensim.models.Word2Vec(iter=1)
model.build_vocab(sentences)

model = gensim.models.Word2Vec(
    sentences,
    size=300,
    window=300,
    min_count=2,
    workers=4,
    iter=100,)


with open(os.path.join(DATA_PATH,"word_list.pickle"), 'wb') as f:
    pickle.dump(list(model.wv.vocab), f)


model.save('mymodel')