from gensim.models.doc2vec import Doc2Vec
from nltk.tokenize import word_tokenize
import sys
import os
pdf = sys.argv[1]


model= Doc2Vec.load(os.path.join("/Library/WebServer/Documents/python/hackathon/src/document_similarity","d2v.model"))
#to find the vector of a document which is not in training data
test_data = word_tokenize("building".lower())
v1 = model.infer_vector(test_data)

# to find most similar doc using tags
similar_doc = model.docvecs.most_similar(pdf)

only_name = []

for name in similar_doc:
    only_name.append(name[0])

print(only_name)


# to find vector of doc in training data using tags or in other words, printing the vector of document at index 1 in training data
#print(model.docvecs["Eliza Jones Resume.pdf"])