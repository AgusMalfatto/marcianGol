instructions = [
    'SET FOREIGN_KEY_CHECKS=0;',
    'DROP TABLE IF EXISTS user;',
    'DROP TABLE IF EXISTS foro',
    'DROP TABLE IF EXISTS comment',
    'DROP TABLE IF EXISTS league',
    'SET FOREIGN_KEY_CHECKS=1;',
    """
        CREATE TABLE users (
            IdUser INT PRIMARY KEY AUTO_INCREMENT,
            Name VARCHAR(50) UNIQUE NOT NULL,
            LastName VARCHAR(50) UNIQUE NOT NULL,
            Email VARCHAR(50) NOT NULL,
            Password VARCHAR(200),
            Admin BOOLEAN DEFAULT FALSE,
            Active BOOLEAN DEFAULT TRUE
        );
    """,
    """
        CREATE TABLE foro (
            IdForo INT PRIMARY KEY AUTO_INCREMENT,
            Photo LONGBLOB NOT NULL,
            Name VARCHAR(50) NOT NULL,
            Description VARCHAR(50) NOT NULL,
            Date DATE NOT NULL,
            Active BOOLEAN NOT NULL DEFAULT TRUE,
            IdLeague INT NOT NULL,
            IdUser INT NOT NULL,

            FOREIGN KEY (IdLeague) REFERENCES League(IdLeague),
            FOREIGN KEY (IdUser) REFERENCES user(IdUser)
        );
    """,
    """
        CREATE TABLE comment (
            IdComment INT PRIMARY KEY AUTO_INCREMENT,
            Description VARCHAR(150) NOT NULL,
            Date DATE NOT NULL,
            Likes INT NOT NULL DEFAULT 0,
            IdUser INT NOT NULL,
            IdForo INT NOT NULL,

            FOREIGN KEY (IdUser) REFERENCES user(IdUser),
            FOREIGN KEY (IdForo) REFERENCES foro(IdForo)
        )
    """,

    """
        CREATE TABLE league (
            IdLeague INT PRIMARY KEY AUTO_INCREMENT,
            Description VARCHAR(50) NOT NULL
        )
    """,

    """
        INSERT INTO League (IdLeague, Description) VALUES
            ()
    """,
    """
        INSERT INTO users (Name, LastName, Email, Password, Admin, Active) VALUES
            ()
    """
]