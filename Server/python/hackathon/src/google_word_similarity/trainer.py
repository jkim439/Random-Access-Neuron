from gensim.models import Word2Vec

sentences = [
                ['this', 'is', 'a',   'good',      'product'],
                ['it',   'is', 'a',   'excellent', 'product'],
                ['it',   'is', 'a',   'bad',       'product'],
                ['that', 'is', 'the', 'worst',     'product']
            ]

# 문장을 이용하여 단어와 벡터를 생성한다.
model = Word2Vec(sentences, size=300, window=3, min_count=1, workers=1)




file_name = 'GoogleNews-vectors-negative300.bin'
model.intersect_word2vec_format(fname=file_name, binary=True)

# 단어벡터를 구한다.
word_vectors = model.wv

vocabs = word_vectors.vocab.keys()
word_vectors_list = [word_vectors[v] for v in vocabs]

# 단어간 유사도를 확인하다
print(word_vectors.similarity(w1='it', w2='this'))

from sklearn.decomposition import PCA
pca = PCA(n_components=2)
xys = pca.fit_transform(word_vectors_list)
xs = xys[:,0]
ys = xys[:,1]


# 최종 모델을 저장한다.
model.save('word2vec.model')

# 저장한 모델을 읽어서 이용한다.
model = Word2Vec.load('word2vec.model')