-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mer 25 Juillet 2018 à 15:54
-- Version du serveur :  5.7.22-0ubuntu18.04.1
-- Version de PHP :  7.2.7-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `my_ecommerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `userid` int(11) NOT NULL,
  `prodid` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Developer'),
(2, 'Lead Developer'),
(3, 'DevOps'),
(4, 'CTO'),
(5, 'Marketing'),
(6, 'Project chief'),
(7, 'Secretary');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `prodid` int(11) NOT NULL,
  `categid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `orders`
--

INSERT INTO `orders` (`id`, `prodid`, `categid`, `userid`, `status`, `date`, `company`) VALUES
(1, 1, 1, 1, 1, '2018-07-17 12:15:06', 'Google Inc'),
(2, 29, 2, 1, 1, '2018-07-18 07:44:56', 'Apple Inc');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` float NOT NULL,
  `categid` int(11) NOT NULL,
  `description` text NOT NULL,
  `img` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `categid`, `description`, `img`) VALUES
(1, 'Jean François', 30000, 1, 'test@example.org', 'https://media.licdn.com/dms/image/C4D03AQHppdRKgaHnfw/profile-displayphoto-shrink_200_200/0?e=1536796800&v=beta&t=8oDpebz7QEaAsM_CYJ6BQJ68rEyOAG0OVGvSzN7qeVo'),
(2, 'Ms. Loren Welch', 67460, 4, 'kstroman@romaguera.biz', NULL),
(3, 'Mr. Alexis Fisher', 24987, 5, 'esmeralda.satterfield@gmail.com', NULL),
(4, 'Dr. Johnson Jenkins', 35658, 1, 'wgaylord@gmail.com', 'https://www.aceshowbiz.com/images/photo/dev_patel.jpg'),
(5, 'Dr. Freeman Block V', 103485, 5, 'rbuckridge@hotmail.com', NULL),
(6, 'Mr. Vernon Goldner I', 53158, 4, 'tiana.rau@considine.com', NULL),
(7, 'Wade Auer', 86475, 5, 'kschowalter@dare.com', NULL),
(8, 'Emmalee Howe', 83301, 5, 'klein.daron@volkman.com', NULL),
(9, 'Abigayle Feest Sr.', 91685, 2, 'raegan30@jast.com', NULL),
(10, 'Kallie Ledner', 41887, 2, 'sokon@wisozk.org', NULL),
(11, 'Vena Luettgen MD', 40746, 5, 'kay.zboncak@kuphal.com', NULL),
(12, 'Misty Blanda', 63556, 3, 'rempel.aracely@yahoo.com', NULL),
(13, 'Prof. Julie Morar DVM', 84982, 1, 'candace.pfeffer@gmail.com', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSmjOxUUdd-mc4uJGtbmPr4bmvOXWa_iqzVpZcRkRkvC0xIcinQSA'),
(14, 'Miss Eugenia Roberts', 114772, 3, 'frida17@yahoo.com', NULL),
(15, 'Linwood Blanda', 102228, 2, 'rebekah54@gmail.com', NULL),
(16, 'Roslyn Padberg', 52545, 1, 'doyle.ernest@yahoo.com', NULL),
(17, 'Gertrude Jakubowski', 47903, 2, 'rosella.lueilwitz@brekke.com', NULL),
(18, 'Gustave Carter', 20210, 5, 'cswift@gmail.com', NULL),
(19, 'Juston Jaskolski', 113726, 2, 'considine.dimitri@yahoo.com', NULL),
(20, 'Deron Kuhn', 22455, 1, 'buck15@hotmail.com', NULL),
(21, 'Norris Schiller', 122291, 2, 'wgorczany@gmail.com', NULL),
(22, 'Miss Lindsay Beahan Sr.', 95509, 4, 'willms.isadore@yahoo.com', NULL),
(23, 'Saige Altenwerth', 39995, 2, 'kwintheiser@gmail.com', NULL),
(24, 'Jettie Bradtke', 79566, 4, 'fjacobs@gmail.com', NULL),
(25, 'Kurtis Bernier', 35494, 4, 'chase75@wyman.com', NULL),
(26, 'Kieran Jast', 91535, 3, 'ivory34@hotmail.com', NULL),
(27, 'Myrtice Padberg', 23417, 3, 'nkozey@hammes.com', NULL),
(28, 'Retta Dach', 93843, 3, 'bradtke.derek@hotmail.com', NULL),
(29, 'Flavie Schmeler', 101657, 2, 'ehyatt@effertz.net', NULL),
(30, 'Izabella Ziemann', 77168, 2, 'lspencer@nikolaus.com', NULL),
(31, 'Boyd Hessel', 124524, 2, 'mclaughlin.ashley@runte.info', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `roles` text NOT NULL,
  `surname` text NOT NULL,
  `name` text NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `roles`, `surname`, `name`, `created`, `company`) VALUES
(1, 'michel.dubois', '$2y$10$ACsDFtFpuLsDJG.XEZZ5aOFSOE1zWrBpCiodwIzcwLhqWfSpq2RQK', 'micheldubois@example.com', 'ROLE_CLIENT', 'Michel', 'Dubois', '2018-07-20 15:41:24', 'Google Inc'),
(2, 'jean.onche', '$2y$10$H699gqQlBL2s2FMqixLamOs1Pz.C4QRk6QZzgEFz2tN2FbTKXYx2W', 'jean.onche@example.org', 'ROLE_ADMIN', 'Jean', 'Onche', '2018-07-20 15:41:24', NULL),
(4, 'john.fitz', '$2y$13$W273yVc.qUOUpqlvpl9RgOWzDEJTLdbqnnJIJTrV.dV/BdK.wXXs.', 'john.fitz@google.com', 'ROLE_CLIENT', 'John', 'Fitz', '2018-07-23 14:20:33', 'Google Inc');

-- --------------------------------------------------------

--
-- Structure de la table `web_config`
--

CREATE TABLE `web_config` (
  `id` int(11) NOT NULL,
  `web_title` text NOT NULL,
  `tags` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `web_config`
--

INSERT INTO `web_config` (`id`, `web_title`, `tags`, `email`, `phone`, `address`) VALUES
(1, 'Hired', 'ecommerce, randomtag, cloclo', 'admin@uppler.com', '+33 1 23 45 67 89', '38 Rue Stanislas, 54000 Nancy');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`userid`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `web_config`
--
ALTER TABLE `web_config`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `web_config`
--
ALTER TABLE `web_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
