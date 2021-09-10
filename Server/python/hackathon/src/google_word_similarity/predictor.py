import gensim.downloader as api

model = api.load("word2vec-google-news-300")
#model = api.load("glove-twitter-25")
#model = api.load("glove-wiki-gigaword-100")
print(model.most_similar(positive=["aws","python"], negative=["man"], topn=100))

