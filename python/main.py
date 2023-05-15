# import mysql.connector



# connection_params = {
#     'host': "localhost",
#     'user': "osm",
#     'password': "osm",
#     'database': "db_voltaire",
# }

# request = """
#     (SELECT title, last_name,first_name,author.status, category,description FROM `book_classification` 
#     INNER JOIN book on book.id = book_classification.book_id 
#     INNER JOIN classification on classification.id = book_classification.classification_id
#     INNER JOIN book_author on book_author.book_id = book.id 
#     INNER JOIN author on author.id = book_author.author_id)
#     UNION ALL
#     (SELECT title, last_name,first_name,translator.status, category,description FROM `book_classification` 
#     INNER JOIN book on book.id = book_classification.book_id 
#     INNER JOIN classification on classification.id = book_classification.classification_id
#     INNER JOIN book_translator on book_translator.book_id = book.id 
#     INNER JOIN translator on translator.id = book_translator.translator_id)
#     UNION ALL
#     (SELECT title, last_name,first_name,copyst.status, category,description FROM `book_classification` 
#     INNER JOIN book on book.id = book_classification.book_id 
#     INNER JOIN classification on classification.id = book_classification.classification_id
#     INNER JOIN book_copyst on book_copyst.book_id = book.id 
#     INNER JOIN copyst on copyst.id = book_copyst.copyst_id)
#     UNION ALL
#     (SELECT title, last_name,first_name,editor.status, category,description FROM `book_classification` 
#     INNER JOIN book on book.id = book_classification.book_id 
#     INNER JOIN classification on classification.id = book_classification.classification_id
#     INNER JOIN book_editor on book_editor.book_id = book.id 
#     INNER JOIN editor on editor.id = book_editor.editor_id)  
#     ORDER BY `title` ASC;
# """
# with mysql.connector.connect(**connection_params) as db :
#     with db.cursor() as c:
#         c.execute(request)
#         columns = c.description
#         # list= [list[0] for list in c.fetchall()]
#         # resultats = c.fetchall()
#         resultats = c.fetchall()
#         print(columns)
#         # resultats = list(resultats)
#         # for res in list:
#         #     print(res)
#         row = c.column_names
#         row = list(row)
#         print(row)
        
#     pass

import json
import urllib.request
url = "http://localhost:8000/api/book"
# with urllib.request.urlopen(url) as response:
#     books = json.loads(response.read())
#     print(books)
#     data = []
#     with open("sample.json", "w") as f:
#         f.write(books)
    # for book in books:

# with urllib.request.Request('http://localhost:8000/api/book') as response:
#     data = response
#     print(data)
#    html = response.read()
#    html = json.dumps(html,indent=4)
# #    print(html)
#    with open("sample.json", "w") as f:
#     f.write(html)


import requests
r = requests.get(url)
with open("sample.json", "w") as f:
    f.write(json.dumps(r.json(),ensure_ascii=False))
print (r.json()) # if response type was set to JSON, then you'll automatically have a JSON response here...