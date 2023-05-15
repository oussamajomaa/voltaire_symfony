SELECT title, author.last_name,author.first_name, category,description FROM book_classification, book, book_translator, translator, book_author, author, classification
where classification.id = book_classification.classification_id  and book.id = book_classification.book_id
and  author.id = book_author.author_id and book.id = book_author.book_id
and book.id = book_translator.book_id and translator.id = book_translator.translator_id;


SELECT title, author.last_name,author.first_name, category,description FROM `book_classification` 
INNER JOIN book on book.id = book_classification.book_id 
INNER JOIN book_author on book_author.book_id = book.id 
INNER JOIN author on author.id = book_author.author_id 
INNER JOIN classification on classification.id = book_classification.classification_id;

(SELECT title, last_name,first_name,author.status, category,description FROM `book_classification` 
INNER JOIN book on book.id = book_classification.book_id 
INNER JOIN classification on classification.id = book_classification.classification_id
INNER JOIN book_author on book_author.book_id = book.id 
INNER JOIN author on author.id = book_author.author_id)
UNION ALL
(SELECT title, last_name,first_name,translator.status, category,description FROM `book_classification` 
INNER JOIN book on book.id = book_classification.book_id 
INNER JOIN classification on classification.id = book_classification.classification_id
INNER JOIN book_translator on book_translator.book_id = book.id 
INNER JOIN translator on translator.id = book_translator.translator_id)
UNION ALL
(SELECT title, last_name,first_name,copyst.status, category,description FROM `book_classification` 
INNER JOIN book on book.id = book_classification.book_id 
INNER JOIN classification on classification.id = book_classification.classification_id
INNER JOIN book_copyst on book_copyst.book_id = book.id 
INNER JOIN copyst on copyst.id = book_copyst.copyst_id)
UNION ALL
(SELECT title, last_name,first_name,editor.status, category,description FROM `book_classification` 
INNER JOIN book on book.id = book_classification.book_id 
INNER JOIN classification on classification.id = book_classification.classification_id
INNER JOIN book_editor on book_editor.book_id = book.id 
INNER JOIN editor on editor.id = book_editor.editor_id)  
ORDER BY `title` ASC;

SELECT DISTINCT title, last_name,first_name, book_contributor.status,description AS classification from classification
JOIN book on book.id = classification.book_id
JOIN book_contributor on book.id = book_contributor.book_id
join contributor on contributor.id = book_contributor.contributor_id

SELECT title, last_name,first_name,book_contributor.status FROM `book` INNER JOIN book_contributor on book_contributor.book_id = book.id INNER JOIN contributor on contributor.id = book_contributor.contributor_id INNER JOIN classification on classification.book_id = book.id;

insert into table from another database:
INSERT INTO `book`(`id`, `type_document`, `title`, `publication_place`, `publication_date`, `publisher`, `publisher_stated`, `publication_place_stated`, `publication_date_stated`, `multivolume`, `volume`, `source`, `marginalia`, `library`, `cote`, `provenance`, `ferney`, `digital_voltaire`, `external_resource`, `notes`, `update_date`, `pot_pourri`, `status`, `vol_number`) 
SELECT `id`, `type_document`, `title`, `publication_place`, `publication_date`, `publisher`, `publisher_stated`, `publication_place_stated`, `publication_date_stated`, `multivolume`, `volume`, `source`, `marginalia`, `library`, `cote`, `provenance`, `ferney`, `digital_voltaire`, `external_resource`, `notes`, `update_date`, `pot_pourri`, `status`, `vol_number` from voltaire.book

INSERT INTO `author`(`id`, `first_name`, `last_name`, `link_viaf`, `notes`) 
SELECT `id`, `first_name`, `last_name`, `link_viaf`, `notes` from voltaire.contributor;

UPDATE `author` SET `status`='author';

INSERT INTO `book_author`(`book_id`, `author_id`) 
SELECT `book_id`, `contributor_id` from voltaire.book_contributor WHERE status = "author"


INSERT INTO `book_classification`(`book_id`, `classification_id`)
SELECT book_id,id from voltaire.classification 
inner JOIN classification on voltaire.classification.description = db_voltaire.classification.description


SELECT `book_id`, description, classification.id, category FROM `book_classification` JOIN classification on classification.id = book_classification.classification_id ORDER BY `book_classification`.`book_id` ASC, `classification`.`description` ASC;

SELECT id FROM `book` 
JOIN voltaire.classification on book.id = voltaire.classification.book_id
where id = 18254;




DELETE FROM book
Insert into book 
select * from voltaire.book


remplacer:
Théologie polémique
Théologiens

Agriculture & Botanique, &c.
Agriculture

Droit civil, Droit de la Nature & des Gens, & droit public
Droit civil


delete 
Philosophes modernes
Vies des Saints
Droit étranger


UPDATE `classification` SET `description`='Théologiens' WHERE description = "Théologie polémique"

UPDATE `classification` SET `description`='Histoire naturelle des animaux' WHERE description = "Histoire naturelle des animaux, oiseaux, poissons, insectes, &c.";



4588 with classification
4499 with contributor

5426 books

[Unit]
Description=SUMMARY
After=network-online.target

[Service]
Type=simple
RemainAfterExit=yes
ExecStart=/usr/bin/python3 /home/osm/data/summary-api/main.py
User=osm
Restart=always

[Install]
WantedBy=multi-user.target

[Unit]
Description=summary
After=network.target

[Service]
User=osm
Group=www-data
WorkingDirectory=/home/osm/data/summary-api
Environment="PATH=/home/sammy/myproject/myprojectenv/bin"
ExecStart=/home/sammy/myproject/myprojectenv/bin/gunicorn --workers 3 --bind unix:myproject.sock -m 007 wsgi:app

[Install]
WantedBy=multi-user.target

[Unit]
Description=SUMMARY
After=network.target

[Service]
ExecStart=/home/osm/.local/bin/gunicorn -c /home/osm/data/summary-api/gunicorn_config.py main:app
WorkingDirectory=/home/osm/data/summary-api
User=osm
Group=www-data
Restart=always

[Install]
WantedBy=multi-user.target

[Unit]
Description=SUMMARY
After=network-online.target

[Service]
Type=simple
RemainAfterExit=yes
ExecStart=/usr/bin/python3 /home/osm/data/summary-api/main.py
User=osm
Restart=always

[Install]
WantedBy=multi-user.target


