-- Données communes aux 4 versions
CREATE TABLE IF NOT EXISTS formations (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    titre       TEXT    NOT NULL,
    description TEXT    NOT NULL,
    niveau      TEXT    NOT NULL
);

INSERT INTO formations (titre, description, niveau) VALUES
 ('Algorithmique',        'Structures de contrôle, tableaux, complexité.',        'L1'),
 ('Bases de données',     'Modèle relationnel, SQL, normalisation.',              'L1'),
 ('Développement web',    'HTML, CSS, PHP et échanges client-serveur.',           'L2'),
 ('Réseaux',              'Modèle TCP/IP, adressage, services réseau.',           'L2'),
 ('Développement mobile', 'Applications Android, consommation d''API.',           'L3'),
 ('Architecture logicielle', 'Couches, API REST, séparation front / back.',      'L3');
