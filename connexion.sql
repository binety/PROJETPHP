CREATE TABLE regions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255)
);

CREATE TABLE departements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    region_id INT,
    FOREIGN KEY (region_id) REFERENCES regions(id)
);

CREATE TABLE communes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    departement_id INT,
    FOREIGN KEY (departement_id) REFERENCES departements(id)
);

CREATE TABLE centres_de_vote (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    commune_id INT,
    FOREIGN KEY (commune_id) REFERENCES communes(id)
);

CREATE TABLE bureaux_de_vote (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    centre_de_vote_id INT,
    FOREIGN KEY (centre_de_vote_id) REFERENCES centres_de_vote(id)
);

CREATE TABLE candidats (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    partie VARCHAR(255)
);

CREATE TABLE scores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bureau_de_vote_id INT,
    candidat_id INT,
    score INT,
    FOREIGN KEY (bureau_de_vote_id) REFERENCES bureaux_de_vote(id),
    FOREIGN KEY (candidat_id) REFERENCES candidats(id)
);
