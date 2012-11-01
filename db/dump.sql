DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `path` varchar(150) NOT NULL,
  `t` int(11) NOT NULL,
  `f` int(11) NOT NULL,
  `cue` varchar(50) DEFAULT NULL,
  `discr` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000397 ;


INSERT INTO `images` (`id`, `path`, `t`, `f`, `cue`, `discr`) VALUES
(1000326, 'pics/L134_T12.jpg', 2, 3, NULL, NULL),
(1000327, 'pics/L134_T134.jpg', 3, 3, NULL, NULL),
(1000328, 'pics/L134_T234.jpg', 3, 3, NULL, NULL),
(1000329, 'pics/L134_T34.jpg', 2, 3, NULL, NULL),
(1000330, 'pics/L134_T3.jpg', 1, 3, NULL, NULL),
(1000331, 'pics/L13.jpg', 0, 2, NULL, NULL),
(1000332, 'pics/L13_T24.jpg', 2, 2, NULL, NULL),
(1000333, 'pics/L13_T34.jpg', 2, 2, NULL, NULL),
(1000334, 'pics/L14.jpg', 0, 2, NULL, NULL),
(1000335, 'pics/L14_T24.jpg', 2, 2, NULL, NULL),
(1000336, 'pics/L14_T2.jpg', 1, 2, NULL, NULL),
(1000337, 'pics/L1_T1234.jpg', 4, 1, NULL, NULL),
(1000338, 'pics/L1_T134.jpg', 3, 1, NULL, NULL),
(1000339, 'pics/L1_T1.jpg', 1, 1, NULL, NULL),
(1000340, 'pics/L1_T234.jpg', 3, 1, NULL, NULL),
(1000341, 'pics/L1_T23.jpg', 2, 1, NULL, NULL),
(1000342, 'pics/L1_T34.jpg', 2, 1, NULL, NULL),
(1000343, 'pics/L1_T3.jpg', 1, 1, NULL, NULL),
(1000344, 'pics/L1_T4.jpg', 1, 1, NULL, NULL),
(1000345, 'pics/L234.jpg', 0, 4, NULL, NULL),
(1000346, 'pics/L234_T1234.jpg', 4, 4, NULL, NULL),
(1000347, 'pics/L234_T124.jpg', 3, 4, NULL, NULL),
(1000348, 'pics/L234_T12.jpg', 2, 4, NULL, NULL),
(1000349, 'pics/L234_T1.jpg', 1, 4, NULL, NULL),
(1000350, 'pics/L234_T234.jpg', 3, 4, NULL, NULL),
(1000351, 'pics/L234_T2.jpg', 1, 4, NULL, NULL),
(1000352, 'pics/L234_T34.jpg', 2, 4, NULL, NULL),
(1000353, 'pics/L23.jpg', 0, 3, NULL, NULL),
(1000354, 'pics/L23_T1234.jpg', 4, 3, NULL, NULL),
(1000355, 'pics/L23_T123.jpg', 3, 3, NULL, NULL),
(1000356, 'pics/L23_T1.jpg', 1, 3, NULL, NULL),
(1000357, 'pics/L23_T234.jpg', 3, 3, NULL, NULL),
(1000358, 'pics/L23_T2.jpg', 1, 3, NULL, NULL),
(1000359, 'pics/L24.jpg', 0, 3, NULL, NULL),
(1000360, 'pics/L24_T1234.jpg', 4, 3, NULL, NULL),
(1000361, 'pics/L24_T123.jpg', 3, 3, NULL, NULL),
(1000362, 'pics/L24_T124.jpg', 3, 3, NULL, NULL),
(1000363, 'pics/L24_T14.jpg', 2, 3, NULL, NULL),
(1000364, 'pics/L24_T23.jpg', 2, 3, NULL, NULL),
(1000365, 'pics/L24_T3.jpg', 1, 3, NULL, NULL),
(1000366, 'pics/L2.jpg', 0, 1, NULL, NULL),
(1000367, 'pics/L2_T1234.jpg', 4, 2, NULL, NULL),
(1000368, 'pics/L2_T123.jpg', 3, 2, NULL, NULL),
(1000369, 'pics/L2_T12.jpg', 2, 2, NULL, NULL),
(1000370, 'pics/L2_T13.jpg', 2, 2, NULL, NULL),
(1000371, 'pics/L2_T1.jpg', 1, 2, NULL, NULL),
(1000372, 'pics/L2_T234.jpg', 3, 2, NULL, NULL),
(1000373, 'pics/L2_T3.jpg', 1, 2, NULL, NULL),
(1000374, 'pics/L34_T1234.jpg', 4, 2, NULL, NULL),
(1000375, 'pics/L34_T134.jpg', 3, 2, NULL, NULL),
(1000376, 'pics/L34_T14.jpg', 2, 2, NULL, NULL),
(1000377, 'pics/L34_T234.jpg', 3, 2, NULL, NULL),
(1000378, 'pics/L34_T3.jpg', 1, 2, NULL, NULL),
(1000379, 'pics/L3.jpg', 0, 1, NULL, NULL),
(1000380, 'pics/L3_T1234.jpg', 4, 1, NULL, NULL),
(1000381, 'pics/L3_T123.jpg', 3, 1, NULL, NULL),
(1000382, 'pics/L3_T12.jpg', 2, 1, NULL, NULL),
(1000383, 'pics/L3_T4.jpg', 1, 1, NULL, NULL),
(1000384, 'pics/L4_T124.jpg', 3, 1, NULL, NULL),
(1000385, 'pics/L4_T12.jpg', 2, 1, NULL, NULL),
(1000386, 'pics/L4_T1.jpg', 1, 1, NULL, NULL),
(1000387, 'pics/L4_T4.jpg', 1, 1, NULL, NULL),
(1000388, 'pics/neutral.jpg', 0, 0, NULL, NULL),
(1000389, 'pics/T1234.jpg', 4, 0, NULL, NULL),
(1000390, 'pics/T134.jpg', 3, 0, NULL, NULL),
(1000391, 'pics/T14.jpg', 2, 0, NULL, NULL),
(1000392, 'pics/T1.jpg', 1, 0, NULL, NULL),
(1000393, 'pics/T234.jpg', 3, 0, NULL, NULL),
(1000394, 'pics/T23.jpg', 2, 0, NULL, NULL),
(1000396, 'pics/T4.jpg', 1, 0, NULL, NULL);


DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) DEFAULT NULL,
  `lastname` varchar(20) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `org` varchar(20) DEFAULT NULL,
  `gaspar` varchar(10) DEFAULT NULL,
  `sciper` int(11) DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `education` int(11) DEFAULT NULL,
  `ocountry` varchar(50) DEFAULT NULL,
  `rcountry` varchar(50) DEFAULT NULL,
  `other` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `phase` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000345 ;


DROP TABLE IF EXISTS `answers`;
CREATE TABLE IF NOT EXISTS `answers` (
  `userid` bigint(20) NOT NULL,
  `imageid` bigint(20) NOT NULL,
  `number` bigint(20) NOT NULL AUTO_INCREMENT,
  `result` varchar(10) NOT NULL,
  `reaction` bigint(20) NOT NULL,
  PRIMARY KEY (`userid`,`imageid`,`number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
