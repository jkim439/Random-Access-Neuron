import sys
import pickle

import os
with open(os.path.join("/Library/WebServer/Documents/python/hackathon/data","word_list.pickle"), 'rb') as f:
    word_list = pickle.load(f)
print(sys.argv[1].lower() in word_list)