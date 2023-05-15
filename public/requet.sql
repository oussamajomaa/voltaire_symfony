-- copy book
INSERT INTO `book`(`id`, `type_document`, `title`, `publication_place`, `publication_date`, `publisher`, `publisher_stated`, `publication_place_stated`, `publication_date_stated`, `multivolume`, `volume`, `source`, `marginalia`, `library`, `cote`, `provenance`, `ferney`, `digital_voltaire`, `external_resource`, `notes`, `update_date`, `pot_pourri`, `status`, `vol_number`, `user_id`, `user_update`)
select `id`, `type_document`, `title`, `publication_place`, `publication_date`, `publisher`, `publisher_stated`, `publication_place_stated`, `publication_date_stated`, `multivolume`, `volume`, `source`, `marginalia`, `library`, `cote`, `provenance`, `ferney`, `digital_voltaire`, `external_resource`, `notes`, `update_date`, `pot_pourri`, `status`, `vol_number`, `user_id`, `user_update` 
from voltaire.book;

-- ***************************************************************

-- copy voltair.contributor to author:
INSERT INTO `author`(`id`, `first_name`, `last_name`, `link_viaf`, `notes`, `status`) 
SELECT `id`, `first_name`, `last_name`, `link_viaf`, `notes`, 'author'
from voltaire.contributor;

-- copy voltaire.book_contributor to book_author
INSERT INTO `book_author`(`book_id`, `author_id`) 
SELECT `book_id`, `contributor_id` from voltaire.book_contributor WHERE status = "author"

-- ****************************************************************

-- copy voltair.contributor to translator:
INSERT INTO `translator`(`id`, `first_name`, `last_name`, `link_viaf`, `notes`, `status`) 
SELECT `id`, `first_name`, `last_name`, `link_viaf`, `notes`, 'translator'
from voltaire.contributor;

-- copy voltaire.book_contributor to book_translator
INSERT INTO `book_translator`(`book_id`, `translator_id`) 
SELECT `book_id`, `contributor_id` from voltaire.book_contributor WHERE status = "translator"

-- ****************************************************************

-- copy voltair.contributor to editor:
INSERT INTO `editor`(`id`, `first_name`, `last_name`, `link_viaf`, `notes`, `status`) 
SELECT `id`, `first_name`, `last_name`, `link_viaf`, `notes`, 'editor'
from voltaire.contributor;

-- copy voltaire.book_contributor to book_editor
INSERT INTO `book_editor`(`book_id`, `editor_id`) 
SELECT `book_id`, `contributor_id` from voltaire.book_contributor WHERE status = "editor"

-- *************************************************************

-- copy voltair.contributor to copyst:
INSERT INTO `copyst`(`id`, `first_name`, `last_name`, `link_viaf`, `notes`, `status`) 
SELECT `id`, `first_name`, `last_name`, `link_viaf`, `notes`, 'copyst'
from voltaire.contributor;

-- copy voltaire.book_contributor to book_copyst
INSERT INTO `book_copyst`(`book_id`, `copyst_id`) 
SELECT `book_id`, `contributor_id` from voltaire.book_contributor WHERE status = "copyste"

-- ************************************************************

-- copy voltaire book_classification to book_classification 
INSERT INTO `book_classification`(`book_id`, `classification_id`)
SELECT book_id,id from voltaire.classification 
inner JOIN classification on voltaire.classification.description = db_voltaire.classification.description

-- **************************************************************



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