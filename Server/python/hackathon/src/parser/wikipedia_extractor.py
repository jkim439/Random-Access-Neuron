import spacy
import nltk
import wikipedia
nlp = spacy.load('en_core_web_sm')
nltk.download('brown')

def wiki_pager(page):
    try:
        result = wikipedia.page(page)
    except wikipedia.DisambiguationError as e:
        first_selected = e.options[0]
        result = wiki_pager(first_selected)
    except wikipedia.PageError as e:
        return None
    return result


def extract_wikipedia_with_noun_tokenization(vocab):

    search_result = wikipedia.search(vocab)
    if len(search_result) != 0:
        result = wiki_pager(search_result[0])

        return result.content
    else:
        return None