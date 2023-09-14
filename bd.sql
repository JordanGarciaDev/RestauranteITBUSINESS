/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.25-MariaDB : Database - restaurant3
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`restaurant3` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `restaurant3`;

/*Table structure for table `categorias` */

DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `categorias` */

insert  into `categorias`(`id`,`name`) values 
(1,'Menu'),
(2,'Platos fuertes'),
(3,'Entradas'),
(4,'Sitting'),
(5,'Bebidas'),
(6,'Postres');

/*Table structure for table `items` */

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `precio` bigint(20) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `categoria` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`categoria`),
  CONSTRAINT `items_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

/*Data for the table `items` */

insert  into `items`(`id`,`name`,`descripcion`,`precio`,`imagen`,`categoria`) values 
(7,'MASAS DE CERDO FRITAS','Disfruta de nuestras masas de cerdos fritas',42400,'masas-de-cerdo-fritas-png.png',2),
(8,'Suprema de pollo a la plancha','Delicioso y saludable plato',44700,'Suprema-de-pollo-a-la-plancha.png',2),
(9,'Pescado grillÃ©','Pescado grillÃ© con torrejas de aguacate',52600,'pescado-grille.png',2),
(13,'Papas fritas','Papas fritas',16250,'s1.png',3),
(14,'Onion Rings','Aros de cebolla fritos',13400,'s2.png',3),
(15,'Nuggets','Nuggets de pollo frito',18000,'s3.png',3),
(16,'Nuggets de queso','Nuggets de queso frito',28999,'s4.png',3),
(17,'Alitas de pollo','Alitas De Pollo Barbacoa',37200,'s5.png',3),
(23,'Aguas nacionales','SUPER PROMOCION!',5000,'aguas.png',5),
(24,'Cervezas','Cristal, Bucanero o Presidente',12000,'cervezas.png',5),
(25,'Refrescos Nacionales','Gaseosas',15000,'refrescos.png',5),
(26,'Fanta','Vaso Personal de Fanta Naranja',7000,'bo4.png',5),
(27,'Sprite','Vaso Personal de Sprite',5000,'bo5.png',5),
(28,'Nestea','Vaso Personal de Nestea',7000,'bo6.png',5),
(29,'Fondant de chocolate','Chocolate blanco o con leche',12000,'d1.png',6),
(30,'Flan de caramelo','Dulce de leche Caramel',21000,'flan de caramelo.png',6),
(31,'Rosquilla (Donas)','Tu elecciÃ³n: Chocolate o vainilla',16000,'d3.png',6),
(32,'Batidos','ElecciÃ³n de: Fresa, Vainilla o Chocolate',12000,'d4.png',6),
(34,'Helados Sundae','ElecciÃ³n de: Fresa, Vainilla o Chocolate',25000,'d5.png',6),
(35,'Menu ejecutivo','12 Disponibles de 12:00m a 4:00 pm',44700,'Suprema-de-pollo-a-la-plancha.png',4),
(36,'Suprema de pollo + entrada + postre + gaseosa','Disfruta de suprema de pollo + entrada + postre + gaseosa',62000,'menu-suprema.png',1),
(37,'Pescado grillÃ© + entrada + postre + gaseosa','Disfruta del pescado grillÃ© + entrada + postre + gaseosa',74000,'menu-pescado.png',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
