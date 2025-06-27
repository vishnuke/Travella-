# model.py

import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

# Load data
data = pd.read_csv('City.csv')

# Prepare TF-IDF matrix
tfidf = TfidfVectorizer(stop_words='english')
tfidf_matrix = tfidf.fit_transform(data['City_desc'].fillna(""))

# Compute cosine similarity
cosine_sim = cosine_similarity(tfidf_matrix, tfidf_matrix)

# Mapping city names to index
indices = pd.Series(data.index, index=data['City'])

def get_recommendations(city_name):
    idx = indices[city_name]
    sim_scores = list(enumerate(cosine_sim[idx]))
    sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)[1:6]
    city_indices = [i[0] for i in sim_scores]
    return data['City'].iloc[city_indices].tolist()
