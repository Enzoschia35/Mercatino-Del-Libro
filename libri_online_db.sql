-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 09, 2024 alle 12:54
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `libri_online_db`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `articoli_carrello`
--

CREATE TABLE `articoli_carrello` (
  `id` int(11) NOT NULL,
  `id_carrello` int(11) NOT NULL,
  `id_articolo` int(11) NOT NULL,
  `quantita` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `articoli_carrello`
--

INSERT INTO `articoli_carrello` (`id`, `id_carrello`, `id_articolo`, `quantita`) VALUES
(11, 7, 2, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `carrello`
--

CREATE TABLE `carrello` (
  `id` int(11) NOT NULL,
  `id_utente` bigint(255) NOT NULL,
  `data_creazione` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `carrello`
--

INSERT INTO `carrello` (`id`, `id_utente`, `data_creazione`) VALUES
(1, 3718212913, '2024-06-03'),
(2, 4, '2024-06-03'),
(3, 1, '2024-06-03'),
(4, 5504056697, '2024-06-03'),
(5, 7, '2024-06-03'),
(6, 8786379609, '2024-06-04'),
(7, 8, '2024-06-04'),
(8, 5210546838, '2024-06-05'),
(9, 5377801475, '2024-06-05'),
(10, 1981334956, '2024-06-06'),
(11, 2283681562, '2024-06-06'),
(12, 2889255803, '2024-06-07'),
(13, 9, '2024-06-07'),
(14, 2, '2024-06-07'),
(15, 5771567286, '2024-06-08'),
(16, 6872217563, '2024-06-09'),
(17, 2076273382, '2024-06-09');

-- --------------------------------------------------------

--
-- Struttura della tabella `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `img_path` text NOT NULL,
  `id_articolo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `images`
--

INSERT INTO `images` (`id`, `img_path`, `id_articolo`) VALUES
(6, 'images\\web\\Immagine WhatsApp 2024-06-03 ore 17.19.20_0a5f38ec.jpg', 68),
(7, 'images\\web\\Immagine WhatsApp 2024-06-03 ore 17.19.21_6e8606e3.jpg', 68),
(8, 'images\\web\\Immagine WhatsApp 2024-06-03 ore 17.19.53_dee7a168.jpg', 68),
(9, '\\images\\web\\Immagine WhatsApp 2024-06-03 ore 15.19.42_50436024.jpg', 69),
(10, '\\images\\web\\Immagine WhatsApp 2024-06-03 ore 15.19.47_830bfa14.jpg', 69),
(21, '\\images\\web\\download.jpg', 76);

-- --------------------------------------------------------

--
-- Struttura della tabella `libro`
--

CREATE TABLE `libro` (
  `id` int(11) NOT NULL,
  `titolo` varchar(100) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `prezzo` decimal(10,2) NOT NULL,
  `condizioni` enum('Nuovo','Come Nuovo','Ottime Condizioni','Buone Condizioni','Condizioni Scadenti') DEFAULT NULL COMMENT 'Indica lo stato fisico del libro',
  `descrizione` varchar(300) DEFAULT NULL,
  `data_public` date NOT NULL COMMENT 'mostra la data di pubblicazione dell''annuncio',
  `autore` varchar(200) DEFAULT 'Non definito',
  `editore` varchar(200) DEFAULT 'Non definito',
  `materia` varchar(200) NOT NULL,
  `id_utente` int(11) NOT NULL COMMENT 'id del venditore',
  `is_public` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'indica lo stato dell''annunncio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `libro`
--

INSERT INTO `libro` (`id`, `titolo`, `isbn`, `prezzo`, `condizioni`, `descrizione`, `data_public`, `autore`, `editore`, `materia`, `id_utente`, `is_public`) VALUES
(1, 'Il Signore degli Anelli: La Compagnia dell\'Anello', '9780261103573', 15.99, 'Come Nuovo', 'Epico romanzo fantasy di J.R.R. Tolkien', '1954-07-29', 'J.R.R. Tolkien', 'George Allen & Unwin', 'Fantasy', 1, 1),
(2, 'Il Signore degli Anelli: Le Due Torri', '9780261102361', 15.99, 'Ottime Condizioni', 'Secondo libro della trilogia Il Signore degli Anelli', '1954-11-11', 'J.R.R. Tolkien', 'George Allen & Unwin', 'Fantasy', 1, 1),
(3, 'Il Signore degli Anelli: Il Ritorno del Re', '9780261102378', 15.99, 'Buone Condizioni', 'Conclusione della trilogia Il Signore degli Anelli', '1955-10-20', 'J.R.R. Tolkien', 'George Allen & Unwin', 'Fantasy', 1, 1),
(4, 'Harry Potter e la Pietra Filosofale', '9780747532699', 12.99, 'Come Nuovo', 'Primo libro della serie Harry Potter', '1997-06-26', 'J.K. Rowling', 'Bloomsbury', 'Fantasy', 1, 1),
(5, 'Harry Potter e la Camera dei Segreti', '9780747538493', 12.99, 'Ottime Condizioni', 'Secondo libro della serie Harry Potter', '1998-07-02', 'J.K. Rowling', 'Bloomsbury', 'Fantasy', 1, 1),
(6, 'Harry Potter e il Prigioniero di Azkaban', '9780747542155', 12.99, 'Buone Condizioni', 'Terzo libro della serie Harry Potter', '1999-07-08', 'J.K. Rowling', 'Bloomsbury', 'Fantasy', 1, 1),
(7, 'Harry Potter e il Calice di Fuoco', '9780747546245', 12.99, '', 'Quarto libro della serie Harry Potter', '2000-07-08', 'J.K. Rowling', 'Bloomsbury', 'Fantasy', 1, 1),
(8, 'Harry Potter e l\'Ordine della Fenice', '9780747551003', 14.99, 'Come Nuovo', 'Quinto libro della serie Harry Potter', '2003-06-21', 'J.K. Rowling', 'Bloomsbury', 'Fantasy', 1, 1),
(9, 'Harry Potter e il Principe Mezzosangue', '9780747581086', 14.99, 'Ottime Condizioni', 'Sesto libro della serie Harry Potter', '2005-07-16', 'J.K. Rowling', 'Bloomsbury', 'Fantasy', 1, 1),
(10, 'Harry Potter e i Doni della Morte', '9780747591054', 14.99, 'Buone Condizioni', 'Settimo libro della serie Harry Potter', '2007-07-21', 'J.K. Rowling', 'Bloomsbury', 'Fantasy', 1, 1),
(11, 'Il Codice Da Vinci', '9780385504201', 10.99, 'Come Nuovo', 'Thriller avvincente di Dan Brown', '2003-03-18', 'Dan Brown', 'Doubleday', 'Thriller', 1, 1),
(12, 'Angeli e Demoni', '9780743493468', 10.99, 'Ottime Condizioni', 'Primo libro della serie Robert Langdon', '2000-05-01', 'Dan Brown', 'Pocket Books', 'Thriller', 1, 1),
(13, 'Inferno', '9780385537858', 10.99, 'Buone Condizioni', 'Quarto libro della serie Robert Langdon', '2013-05-14', 'Dan Brown', 'Doubleday', 'Thriller', 1, 1),
(14, 'Il Simbolo Perduto', '9780385504225', 10.99, '', 'Terzo libro della serie Robert Langdon', '2009-09-15', 'Dan Brown', 'Doubleday', 'Thriller', 1, 1),
(15, 'Il Grande Gatsby', '9780743273565', 8.99, 'Come Nuovo', 'Classico della letteratura americana di F. Scott Fitzgerald', '1925-04-10', 'F. Scott Fitzgerald', 'Charles Scribner\'s Sons', 'Narrativa', 1, 1),
(16, '1984', '9780451524935', 9.99, 'Ottime Condizioni', 'Distopia di George Orwell', '1949-06-08', 'George Orwell', 'Secker & Warburg', 'Narrativa', 1, 1),
(17, 'Il giovane Holden', '9780316769488', 10.99, 'Buone Condizioni', 'Romanzo di formazione di J.D. Salinger', '1951-07-16', 'J.D. Salinger', 'Little, Brown and Company', 'Narrativa', 1, 1),
(18, 'Orgoglio e pregiudizio', '9780141040349', 6.99, '', 'Classico della letteratura inglese di Jane Austen', '1813-01-28', 'Jane Austen', 'T. Egerton', 'Narrativa', 1, 1),
(19, 'To Kill a Mockingbird', '9780061120084', 12.99, 'Come Nuovo', 'Romanzo di Harper Lee', '1960-07-11', 'Harper Lee', 'J.B. Lippincott & Co.', 'Narrativa', 1, 1),
(20, 'Il piccolo principe', '9780156012195', 7.99, 'Ottime Condizioni', 'Favola di Antoine de Saint-Exupéry', '1943-04-06', 'Antoine de Saint-Exupéry', 'Reynal & Hitchcock', 'Narrativa', 1, 1),
(21, 'Il nome della rosa', '9780156001311', 14.99, 'Buone Condizioni', 'Romanzo storico di Umberto Eco', '1980-08-21', 'Umberto Eco', 'Bompiani', 'Narrativa', 1, 1),
(22, 'Cent\'anni di solitudine', '9780060883287', 13.99, '', 'Romanzo di Gabriel García Márquez', '1967-05-30', 'Gabriel García Márquez', 'Editorial Sudamericana', 'Narrativa', 1, 1),
(23, 'Moby Dick', '9780142437247', 11.99, 'Come Nuovo', 'Romanzo di Herman Melville', '1851-11-14', 'Herman Melville', 'Harper & Brothers', 'Narrativa', 1, 1),
(24, 'Don Chisciotte della Mancia', '9780142437230', 12.99, 'Ottime Condizioni', 'Romanzo di Miguel de Cervantes', '1605-01-16', 'Miguel de Cervantes', 'Francisco de Robles', 'Narrativa', 1, 1),
(25, 'Guerra e pace', '9781400079988', 18.99, 'Buone Condizioni', 'Romanzo epico di Lev Tolstoj', '1869-03-01', 'Lev Tolstoj', 'The Russian Messenger', 'Narrativa', 1, 1),
(26, 'Ulisse', '9780199535675', 16.99, '', 'Romanzo di James Joyce', '1922-02-02', 'James Joyce', 'Shakespeare and Company', 'Narrativa', 1, 1),
(27, 'Il Processo', '9780805209990', 11.99, 'Come Nuovo', 'Romanzo di Franz Kafka', '1925-04-26', 'Franz Kafka', 'Verlag Die Schmiede', 'Narrativa', 1, 1),
(28, 'Anna Karenina', '9780143035008', 14.99, 'Ottime Condizioni', 'Romanzo di Lev Tolstoj', '1877-01-01', 'Lev Tolstoj', 'The Russian Messenger', 'Narrativa', 1, 1),
(29, 'Il Conte di Montecristo', '9780140449266', 19.99, 'Buone Condizioni', 'Romanzo di Alexandre Dumas', '1844-08-28', 'Alexandre Dumas', 'Émile-Paul Frères', 'Narrativa', 1, 1),
(30, 'Cime tempestose', '9780141439556', 8.99, '', 'Romanzo di Emily Brontë', '1847-12-01', 'Emily Brontë', 'Thomas Cautley Newby', 'Narrativa', 1, 1),
(31, 'Frankenstein', '9780141439471', 9.99, 'Come Nuovo', 'Romanzo di Mary Shelley', '1818-01-01', 'Mary Shelley', 'Lackington, Hughes, Harding, Mavor & Jones', 'Narrativa', 1, 1),
(32, 'Dracula', '9780141439846', 10.99, 'Ottime Condizioni', 'Romanzo di Bram Stoker', '1897-05-26', 'Bram Stoker', 'Archibald Constable and Company', 'Narrativa', 1, 1),
(33, 'I Miserabili', '9780140444308', 17.99, 'Buone Condizioni', 'Romanzo di Victor Hugo', '1862-01-01', 'Victor Hugo', 'A. Lacroix, Verboeckhoven & Cie', 'Narrativa', 1, 1),
(34, 'Il ritratto di Dorian Gray', '9780141439570', 9.99, '', 'Romanzo di Oscar Wilde', '1890-06-20', 'Oscar Wilde', 'Lippincott\'s Monthly Magazine', 'Narrativa', 1, 1),
(35, 'I fratelli Karamazov', '9780374528379', 15.99, 'Come Nuovo', 'Romanzo di Fëdor Dostoevskij', '1880-11-01', 'Fëdor Dostoevskij', 'The Russian Messenger', 'Narrativa', 1, 1),
(36, 'Delitto e castigo', '9780140449136', 14.99, 'Ottime Condizioni', 'Romanzo di Fëdor Dostoevskij', '1866-01-01', 'Fëdor Dostoevskij', 'The Russian Messenger', 'Narrativa', 1, 1),
(37, 'Il Maestro e Margherita', '9780140455465', 13.99, 'Buone Condizioni', 'Romanzo di Michail Bulgakov', '1967-01-01', 'Michail Bulgakov', 'YMCA Press', 'Narrativa', 1, 1),
(38, 'Lolita', '9780679723165', 12.99, '', 'Romanzo di Vladimir Nabokov', '1955-09-15', 'Vladimir Nabokov', 'Olympia Press', 'Narrativa', 1, 1),
(39, 'Il vecchio e il mare', '9780684801223', 8.99, 'Come Nuovo', 'Romanzo di Ernest Hemingway', '1952-09-01', 'Ernest Hemingway', 'Charles Scribner\'s Sons', 'Narrativa', 1, 1),
(40, 'Fahrenheit 451', '9781451673319', 9.99, 'Ottime Condizioni', 'Romanzo di Ray Bradbury', '1953-10-19', 'Ray Bradbury', 'Ballantine Books', 'Narrativa', 1, 1),
(41, 'Il buio oltre la siepe', '9780060935467', 11.99, 'Buone Condizioni', 'Romanzo di Harper Lee', '1960-07-11', 'Harper Lee', 'J.B. Lippincott & Co.', 'Narrativa', 1, 1),
(42, 'Sulla strada', '9780140042597', 12.99, '', 'Romanzo di Jack Kerouac', '1957-09-05', 'Jack Kerouac', 'Viking Press', 'Narrativa', 1, 1),
(43, '1984', '9780451524935', 9.99, 'Come Nuovo', 'Romanzo di George Orwell', '1949-06-08', 'George Orwell', 'Secker & Warburg', 'Narrativa', 1, 1),
(44, 'Il Mago di Oz', '9780060293237', 7.99, 'Ottime Condizioni', 'Romanzo di L. Frank Baum', '1900-05-17', 'L. Frank Baum', 'George M. Hill Company', 'Narrativa', 1, 1),
(45, 'L\'Alchimista', '9780061122413', 8.99, 'Buone Condizioni', 'Romanzo di Paulo Coelho', '1988-05-01', 'Paulo Coelho', 'HarperCollins', 'Narrativa', 1, 1),
(46, 'Il Piccolo Principe', '9780156012195', 6.99, '', 'Romanzo di Antoine de Saint-Exupéry', '1943-04-06', 'Antoine de Saint-Exupéry', 'Reynal & Hitchcock', 'Narrativa', 1, 1),
(47, 'Memorie di una geisha', '9780679781585', 10.99, 'Come Nuovo', 'Romanzo di Arthur Golden', '1997-09-27', 'Arthur Golden', 'Alfred A. Knopf', 'Narrativa', 1, 1),
(48, 'La casa degli spiriti', '9780553383805', 13.99, 'Ottime Condizioni', 'Romanzo di Isabel Allende', '1982-01-01', 'Isabel Allende', 'Plaza & Janés', 'Narrativa', 1, 1),
(49, 'Il buio oltre la siepe', '9780061120084', 10.99, 'Buone Condizioni', 'Romanzo di Harper Lee', '1960-07-11', 'Harper Lee', 'J.B. Lippincott & Co.', 'Narrativa', 1, 1),
(50, 'Il signore delle mosche', '9780399501487', 8.99, '', 'Romanzo di William Golding', '1954-09-17', 'William Golding', 'Faber and Faber', 'Narrativa', 1, 1),
(51, 'Il diario di Anna Frank', '9780553296983', 7.99, 'Come Nuovo', 'Diario di Anna Frank', '1947-06-25', 'Anna Frank', 'Contact Publishing', 'Biografia', 1, 1),
(52, 'Il cacciatore di aquiloni', '9781594631931', 11.99, 'Ottime Condizioni', 'Romanzo di Khaled Hosseini', '2003-05-29', 'Khaled Hosseini', 'Riverhead Books', 'Narrativa', 1, 1),
(53, 'La solitudine dei numeri primi', '9788811681881', 12.99, 'Buone Condizioni', 'Romanzo di Paolo Giordano', '2008-03-20', 'Paolo Giordano', 'Mondadori', 'Narrativa', 1, 1),
(54, 'Il nome della rosa', '9780156001311', 14.99, '', 'Romanzo storico di Umberto Eco', '1980-08-21', 'Umberto Eco', 'Bompiani', 'Narrativa', 1, 1),
(55, 'Orgoglio e pregiudizio', '9780141040349', 6.99, 'Come Nuovo', 'Classico della letteratura inglese di Jane Austen', '1813-01-28', 'Jane Austen', 'T. Egerton', 'Narrativa', 1, 1),
(68, 'Nuovo Tecnologie e progettazione di sistemi informatici e di telecomunicazioni', '9788836003365', 13.45, 'Come Nuovo', 'libro come nuovo', '2024-06-03', 'Paolo Camagni, Riccardo Nikolassy', 'Hoepli', 'Tpsit', 4, 1),
(69, 'aaa', 'aaaa', 90.00, '', 'aaaa', '2024-06-03', 'aaa', 'aaa', 'aaaa', 4, 0),
(76, 'I PROMESSI SPOSI', '9788809950672', 44.00, 'Nuovo', '', '2024-06-07', 'MANZONI', 'Hoepli', 'Letteratura', 9, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `psw` varchar(20) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `prefisso` varchar(5) NOT NULL,
  `numero_di_telefono` varchar(10) NOT NULL,
  `data_creazione` date NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `username`, `email`, `psw`, `nome`, `cognome`, `prefisso`, `numero_di_telefono`, `data_creazione`, `is_admin`) VALUES
(1, 'Admin_Principale', 'admin@email.com', 'password', 'adriano', 'celentano', '', '+1 (555) 1', '2024-04-17', 1),
(2, 'Enzoschia', 'esnex@email.com', '12345', 'Vincenzo', 'Schiavone', '', '3914001441', '2024-06-01', 1),
(4, 'Enzos33', 'Schiavonevincenzo37@gmail.com', '12345', 'Onofrio Vincenzo', 'Schiavone', '+39', '3914001441', '2024-06-01', 0),
(5, 'ssaree12', 'saraviti@gmail.com', 'saras1998', 'Sara', 'Viti', '+39', '3249935977', '2024-06-02', 0),
(6, 'Matteo337', 'marottam328@gmail.com', 'sampei2.0', 'matteo', 'marotta', '+39', '3273558442', '2024-06-02', 0),
(7, 'rosmur', 'eden1980@gmail.com', '123456', 'Rosa', 'Murano', '+39', '333333333', '2024-06-03', 0),
(8, 'saraz', 'sarasviti@gmail.com', '12345', 'Sara', 'Viti', '+39', '3249935977', '2024-06-04', 0),
(9, 'dddee', 'svincenzo773@gmail.com', '12345', 'Onofrio Vincenzo', 'Schiavone', '+39', '3914001441', '2024-06-07', 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `articoli_carrello`
--
ALTER TABLE `articoli_carrello`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_carrello` (`id_carrello`),
  ADD KEY `id_articolo` (`id_articolo`);

--
-- Indici per le tabelle `carrello`
--
ALTER TABLE `carrello`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_utente` (`id_utente`);

--
-- Indici per le tabelle `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `img_path` (`img_path`) USING HASH,
  ADD KEY `id_articolo` (`id_articolo`);

--
-- Indici per le tabelle `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `articoli_carrello`
--
ALTER TABLE `articoli_carrello`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT per la tabella `carrello`
--
ALTER TABLE `carrello`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT per la tabella `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT per la tabella `libro`
--
ALTER TABLE `libro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `articoli_carrello`
--
ALTER TABLE `articoli_carrello`
  ADD CONSTRAINT `articoli_carrello_ibfk_1` FOREIGN KEY (`id_carrello`) REFERENCES `carrello` (`id`),
  ADD CONSTRAINT `articoli_carrello_ibfk_2` FOREIGN KEY (`id_articolo`) REFERENCES `libro` (`id`);

--
-- Limiti per la tabella `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`id_articolo`) REFERENCES `libro` (`id`);

--
-- Limiti per la tabella `libro`
--
ALTER TABLE `libro`
  ADD CONSTRAINT `libro_ibfk_3` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
