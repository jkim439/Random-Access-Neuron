from gensim.models.doc2vec import Doc2Vec, TaggedDocument
from nltk.tokenize import word_tokenize
from src.environment import RESUME_PATH
import os
from src.parser.text_extractor import extract_text_from_document
import nltk

nltk.download('stopwords')
nltk.download('punkt')
files = []
data = []
for resume in os.listdir(RESUME_PATH):

    file = os.path.join(RESUME_PATH, resume)
    text = extract_text_from_document(file)
    files.append(resume)
    data.append(text)


tagged_data = [TaggedDocument(words=word_tokenize(_d.lower()), tags=files) for i, _d in enumerate(data)]

print(files)
max_epochs = 100
vec_size = 100
alpha = 0.025

model = Doc2Vec(size=vec_size,
                window=20,
                alpha=alpha,
                min_alpha=0.00025,
                min_count=1,
                dm=1)

model.build_vocab(tagged_data)

for epoch in range(max_epochs):
    print('iteration {0}'.format(epoch))
    model.train(tagged_data,
                total_examples=model.corpus_count,
                epochs=model.iter)
    # decrease the learning rate
    model.alpha -= 0.0002
    # fix the learning rate, no decay
    model.min_alpha = model.alpha

model.save("d2v.model")
print("Model Saved")