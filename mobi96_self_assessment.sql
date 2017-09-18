-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2017 at 04:53 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `eqreasearchpanel`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL DEFAULT '0',
  `message` varchar(255) NOT NULL DEFAULT '0',
  `mobile` varchar(20) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `subject`, `message`, `mobile`, `datetime`) VALUES
(1, 'pawan sen', 'pawan@gmail.com', 'sdfsdfsd', 'vdf', '', '2017-09-14 18:39:10'),
(2, 'pawan sen', 'pawan@gmail.com', 'rwer', 'werwer', '', '2017-09-14 18:40:09'),
(3, 'pawan sen', 'pawan@gmail.com', 'rwer', 'werwer', '', '2017-09-14 18:42:16'),
(4, 'pawan sen', 'pawan@gmail.com', 'ert', 'ertert', '', '2017-09-14 18:42:41'),
(5, 'pawan sen', 'pawan@gmail.com', 'ert', 'dfgdf', '', '2017-09-14 18:44:18'),
(6, 'pawan sen', 'pawan@gmail.com', 'rwer', 'sdfsdf', '', '2017-09-14 18:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(30) NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=247 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `code`, `name`) VALUES
(1, 'AF', 'Afghanistan'),
(2, 'AL', 'Albania'),
(3, 'DZ', 'Algeria'),
(4, 'AS', 'American Samoa'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antarctica'),
(9, 'AG', 'Antigua And Barbuda'),
(10, 'AR', 'Argentina'),
(11, 'AM', 'Armenia'),
(12, 'AW', 'Aruba'),
(13, 'AU', 'Australia'),
(14, 'AT', 'Austria'),
(15, 'AZ', 'Azerbaijan'),
(16, 'BS', 'Bahamas The'),
(17, 'BH', 'Bahrain'),
(18, 'BD', 'Bangladesh'),
(19, 'BB', 'Barbados'),
(20, 'BY', 'Belarus'),
(21, 'BE', 'Belgium'),
(22, 'BZ', 'Belize'),
(23, 'BJ', 'Benin'),
(24, 'BM', 'Bermuda'),
(25, 'BT', 'Bhutan'),
(26, 'BO', 'Bolivia'),
(27, 'BA', 'Bosnia and Herzegovina'),
(28, 'BW', 'Botswana'),
(29, 'BV', 'Bouvet Island'),
(30, 'BR', 'Brazil'),
(31, 'IO', 'British Indian Ocean Territory'),
(32, 'BN', 'Brunei'),
(33, 'BG', 'Bulgaria'),
(34, 'BF', 'Burkina Faso'),
(35, 'BI', 'Burundi'),
(36, 'KH', 'Cambodia'),
(37, 'CM', 'Cameroon'),
(38, 'CA', 'Canada'),
(39, 'CV', 'Cape Verde'),
(40, 'KY', 'Cayman Islands'),
(41, 'CF', 'Central African Republic'),
(42, 'TD', 'Chad'),
(43, 'CL', 'Chile'),
(44, 'CN', 'China'),
(45, 'CX', 'Christmas Island'),
(46, 'CC', 'Cocos (Keeling) Islands'),
(47, 'CO', 'Colombia'),
(48, 'KM', 'Comoros'),
(49, 'CG', 'Congo'),
(50, 'CD', 'Congo The Democratic Republic Of The'),
(51, 'CK', 'Cook Islands'),
(52, 'CR', 'Costa Rica'),
(53, 'CI', 'Cote D''Ivoire (Ivory Coast)'),
(54, 'HR', 'Croatia (Hrvatska)'),
(55, 'CU', 'Cuba'),
(56, 'CY', 'Cyprus'),
(57, 'CZ', 'Czech Republic'),
(58, 'DK', 'Denmark'),
(59, 'DJ', 'Djibouti'),
(60, 'DM', 'Dominica'),
(61, 'DO', 'Dominican Republic'),
(62, 'TP', 'East Timor'),
(63, 'EC', 'Ecuador'),
(64, 'EG', 'Egypt'),
(65, 'SV', 'El Salvador'),
(66, 'GQ', 'Equatorial Guinea'),
(67, 'ER', 'Eritrea'),
(68, 'EE', 'Estonia'),
(69, 'ET', 'Ethiopia'),
(70, 'XA', 'External Territories of Australia'),
(71, 'FK', 'Falkland Islands'),
(72, 'FO', 'Faroe Islands'),
(73, 'FJ', 'Fiji Islands'),
(74, 'FI', 'Finland'),
(75, 'FR', 'France'),
(76, 'GF', 'French Guiana'),
(77, 'PF', 'French Polynesia'),
(78, 'TF', 'French Southern Territories'),
(79, 'GA', 'Gabon'),
(80, 'GM', 'Gambia The'),
(81, 'GE', 'Georgia'),
(82, 'DE', 'Germany'),
(83, 'GH', 'Ghana'),
(84, 'GI', 'Gibraltar'),
(85, 'GR', 'Greece'),
(86, 'GL', 'Greenland'),
(87, 'GD', 'Grenada'),
(88, 'GP', 'Guadeloupe'),
(89, 'GU', 'Guam'),
(90, 'GT', 'Guatemala'),
(91, 'XU', 'Guernsey and Alderney'),
(92, 'GN', 'Guinea'),
(93, 'GW', 'Guinea-Bissau'),
(94, 'GY', 'Guyana'),
(95, 'HT', 'Haiti'),
(96, 'HM', 'Heard and McDonald Islands'),
(97, 'HN', 'Honduras'),
(98, 'HK', 'Hong Kong S.A.R.'),
(99, 'HU', 'Hungary'),
(100, 'IS', 'Iceland'),
(101, 'IN', 'India'),
(102, 'ID', 'Indonesia'),
(103, 'IR', 'Iran'),
(104, 'IQ', 'Iraq'),
(105, 'IE', 'Ireland'),
(106, 'IL', 'Israel'),
(107, 'IT', 'Italy'),
(108, 'JM', 'Jamaica'),
(109, 'JP', 'Japan'),
(110, 'XJ', 'Jersey'),
(111, 'JO', 'Jordan'),
(112, 'KZ', 'Kazakhstan'),
(113, 'KE', 'Kenya'),
(114, 'KI', 'Kiribati'),
(115, 'KP', 'Korea North'),
(116, 'KR', 'Korea South'),
(117, 'KW', 'Kuwait'),
(118, 'KG', 'Kyrgyzstan'),
(119, 'LA', 'Laos'),
(120, 'LV', 'Latvia'),
(121, 'LB', 'Lebanon'),
(122, 'LS', 'Lesotho'),
(123, 'LR', 'Liberia'),
(124, 'LY', 'Libya'),
(125, 'LI', 'Liechtenstein'),
(126, 'LT', 'Lithuania'),
(127, 'LU', 'Luxembourg'),
(128, 'MO', 'Macau S.A.R.'),
(129, 'MK', 'Macedonia'),
(130, 'MG', 'Madagascar'),
(131, 'MW', 'Malawi'),
(132, 'MY', 'Malaysia'),
(133, 'MV', 'Maldives'),
(134, 'ML', 'Mali'),
(135, 'MT', 'Malta'),
(136, 'XM', 'Man (Isle of)'),
(137, 'MH', 'Marshall Islands'),
(138, 'MQ', 'Martinique'),
(139, 'MR', 'Mauritania'),
(140, 'MU', 'Mauritius'),
(141, 'YT', 'Mayotte'),
(142, 'MX', 'Mexico'),
(143, 'FM', 'Micronesia'),
(144, 'MD', 'Moldova'),
(145, 'MC', 'Monaco'),
(146, 'MN', 'Mongolia'),
(147, 'MS', 'Montserrat'),
(148, 'MA', 'Morocco'),
(149, 'MZ', 'Mozambique'),
(150, 'MM', 'Myanmar'),
(151, 'NA', 'Namibia'),
(152, 'NR', 'Nauru'),
(153, 'NP', 'Nepal'),
(154, 'AN', 'Netherlands Antilles'),
(155, 'NL', 'Netherlands The'),
(156, 'NC', 'New Caledonia'),
(157, 'NZ', 'New Zealand'),
(158, 'NI', 'Nicaragua'),
(159, 'NE', 'Niger'),
(160, 'NG', 'Nigeria'),
(161, 'NU', 'Niue'),
(162, 'NF', 'Norfolk Island'),
(163, 'MP', 'Northern Mariana Islands'),
(164, 'NO', 'Norway'),
(165, 'OM', 'Oman'),
(166, 'PK', 'Pakistan'),
(167, 'PW', 'Palau'),
(168, 'PS', 'Palestinian Territory Occupied'),
(169, 'PA', 'Panama'),
(170, 'PG', 'Papua new Guinea'),
(171, 'PY', 'Paraguay'),
(172, 'PE', 'Peru'),
(173, 'PH', 'Philippines'),
(174, 'PN', 'Pitcairn Island'),
(175, 'PL', 'Poland'),
(176, 'PT', 'Portugal'),
(177, 'PR', 'Puerto Rico'),
(178, 'QA', 'Qatar'),
(179, 'RE', 'Reunion'),
(180, 'RO', 'Romania'),
(181, 'RU', 'Russia'),
(182, 'RW', 'Rwanda'),
(183, 'SH', 'Saint Helena'),
(184, 'KN', 'Saint Kitts And Nevis'),
(185, 'LC', 'Saint Lucia'),
(186, 'PM', 'Saint Pierre and Miquelon'),
(187, 'VC', 'Saint Vincent And The Grenadines'),
(188, 'WS', 'Samoa'),
(189, 'SM', 'San Marino'),
(190, 'ST', 'Sao Tome and Principe'),
(191, 'SA', 'Saudi Arabia'),
(192, 'SN', 'Senegal'),
(193, 'RS', 'Serbia'),
(194, 'SC', 'Seychelles'),
(195, 'SL', 'Sierra Leone'),
(196, 'SG', 'Singapore'),
(197, 'SK', 'Slovakia'),
(198, 'SI', 'Slovenia'),
(199, 'XG', 'Smaller Territories of the UK'),
(200, 'SB', 'Solomon Islands'),
(201, 'SO', 'Somalia'),
(202, 'ZA', 'South Africa'),
(203, 'GS', 'South Georgia'),
(204, 'SS', 'South Sudan'),
(205, 'ES', 'Spain'),
(206, 'LK', 'Sri Lanka'),
(207, 'SD', 'Sudan'),
(208, 'SR', 'Suriname'),
(209, 'SJ', 'Svalbard And Jan Mayen Islands'),
(210, 'SZ', 'Swaziland'),
(211, 'SE', 'Sweden'),
(212, 'CH', 'Switzerland'),
(213, 'SY', 'Syria'),
(214, 'TW', 'Taiwan'),
(215, 'TJ', 'Tajikistan'),
(216, 'TZ', 'Tanzania'),
(217, 'TH', 'Thailand'),
(218, 'TG', 'Togo'),
(219, 'TK', 'Tokelau'),
(220, 'TO', 'Tonga'),
(221, 'TT', 'Trinidad And Tobago'),
(222, 'TN', 'Tunisia'),
(223, 'TR', 'Turkey'),
(224, 'TM', 'Turkmenistan'),
(225, 'TC', 'Turks And Caicos Islands'),
(226, 'TV', 'Tuvalu'),
(227, 'UG', 'Uganda'),
(228, 'UA', 'Ukraine'),
(229, 'AE', 'United Arab Emirates'),
(230, 'GB', 'United Kingdom'),
(231, 'US', 'United States'),
(232, 'UM', 'United States Minor Outlying Islands'),
(233, 'UY', 'Uruguay'),
(234, 'UZ', 'Uzbekistan'),
(235, 'VU', 'Vanuatu'),
(236, 'VA', 'Vatican City State (Holy See)'),
(237, 'VE', 'Venezuela'),
(238, 'VN', 'Vietnam'),
(239, 'VG', 'Virgin Islands (British)'),
(240, 'VI', 'Virgin Islands (US)'),
(241, 'WF', 'Wallis And Futuna Islands'),
(242, 'EH', 'Western Sahara'),
(243, 'YE', 'Yemen'),
(244, 'YU', 'Yugoslavia'),
(245, 'ZM', 'Zambia'),
(246, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `free_trial`
--

CREATE TABLE IF NOT EXISTS `free_trial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `message` varchar(255) NOT NULL DEFAULT '0',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `free_trial`
--

INSERT INTO `free_trial` (`id`, `name`, `email`, `mobile`, `message`, `datetime`) VALUES
(10, 'rwe', 'werwerwer@gmail.com', '9859988889', 'rtyrty', '2017-09-15 06:19:27'),
(11, 'rwe', 'werwerwer@gmail.com', '9859988889', 'rtyrty', '2017-09-15 06:19:33'),
(12, 'rtyrtyr', 'werwerwer@gmail.com', '9859988889', 'rtyrtyrty', '2017-09-15 06:20:24'),
(13, 'rtyrtyr', 'werwerwer@gmail.com', '9859988889', 'rtyrtyrty', '2017-09-15 06:20:35'),
(14, 'rwe', 'werwerwer@gmail.com', '9859988889', 'werwer', '2017-09-15 06:21:06'),
(15, 'rtyrty', 'rtyrty@gmail.com', '9859988889', 'sdfsdfsdf', '2017-09-15 06:21:55'),
(16, 'rtyrty', 'werwerwer@gmail.com', '9859988889', 'werwer', '2017-09-15 06:22:29'),
(17, 'dfgdfdfg', 'dfgdfgdfgdfgdfgdfg@gmail.com', '9856936365', 'dfgdfgdfgdfgdfg', '2017-09-15 06:24:32'),
(18, 'erert', 'ertertert@gmail.com', '9858888888', 'sdffsdfsdfsdf', '2017-09-15 06:25:54'),
(19, 'ertert', 'ertertert@gmail.com', '9856999999', '9asdfsdf', '2017-09-15 06:27:53'),
(20, 'dfgdf', 'dfgdfgdf@gmail.com', '9999999999', 'Null', '2017-09-18 11:58:05');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `active`) VALUES
(1, 'admin', 'Administrator', 1),
(2, 'Director', 'This is Director', 1),
(3, 'Sales Manager', 'This is the Sales Manager', 1),
(4, 'Sales Leader', 'This is the Sales Leader', 1),
(5, 'Sales Rep', 'This is the Sales Rep ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `txnid` varchar(255) NOT NULL,
  `hash_key` varchar(255) NOT NULL,
  `price` int(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zipcode` int(10) NOT NULL DEFAULT '0',
  `service` varchar(100) NOT NULL,
  `buy_date` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(100) NOT NULL,
  `option_value` varchar(100) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 for on 0 for off',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `option_name`, `option_value`, `status`) VALUES
(3, 'admin_email', 'pawan.mobiwebtech@gmail.com', 1),
(4, 'site_name', 'SalesCoach', 1),
(5, 'date_foramte', 'd F Y h:i:s A', 1),
(6, 'site_meta_title', 'Self Assessment', 1),
(7, 'site_meta_description', 'Self Assessment', 1),
(9, 'site_logo', 'uploads/app/1504177975_self-assessment.png', 1),
(10, 'google_captcha', '', 1),
(11, 'data_sitekey', '', 1),
(12, 'secret_key', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `city` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `update_on` datetime DEFAULT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL COMMENT '1 =active 0= inactive',
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `gender` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `signup_type` int(2) NOT NULL DEFAULT '1' COMMENT '1=web2=fb',
  `fb_id` varchar(20) DEFAULT NULL,
  `email_verify` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for unverified 1 for verified',
  `profile_pic` varchar(255) DEFAULT NULL,
  `user_image_thumb` varchar(255) DEFAULT NULL COMMENT '250*250',
  `is_logged_out` tinyint(2) NOT NULL DEFAULT '0' COMMENT '''0 = No, 1= Yes''',
  `is_blocked` tinyint(2) NOT NULL DEFAULT '0' COMMENT '''0 = no, 1 = yes''',
  `device_id` varchar(255) DEFAULT NULL COMMENT 'Device Unique ID',
  `device_type` enum('ANDROID','IOS','WEB') NOT NULL DEFAULT 'WEB' COMMENT 'Used to send push notifications',
  `device_token` text,
  `user_token` varchar(255) DEFAULT NULL,
  `badges` int(10) NOT NULL DEFAULT '0',
  `social_type` enum('FACEBOOK','GOOGLE','TWITTER','INSTAGRAM') DEFAULT NULL,
  `social_id` varchar(250) DEFAULT NULL,
  `is_social_signup` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 = NO, 1 = YES',
  `login_session_key` varchar(255) DEFAULT NULL,
  `is_pass_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=200 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `city`, `state`, `country`, `street`, `update_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `gender`, `date_of_birth`, `signup_type`, `fb_id`, `email_verify`, `profile_pic`, `user_image_thumb`, `is_logged_out`, `is_blocked`, `device_id`, `device_type`, `device_token`, `user_token`, `badges`, `social_type`, `social_id`, `is_social_signup`, `login_session_key`, `is_pass_token`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$08$HahiJzxzWz4VgVfFsJpfZOz1g3vyV8UdQuEmg.MXImUO.kA7/fK5y', '', 'admin@assessment.com', '', 'kiTuQMWjJvfCk5LWBZ7RB.c4017e6155a8fddc89', 1501839749, 'xB5SskYO2D/biy6Mr9lcfO', 1268889823, 0, 0, 0, '', '0000-00-00 00:00:00', 1505317564, 1, 'Admin', 'Admin', 'Admin', '0', 'MALE', '1998-10-26', 0, '', 0, 'uploads/users/1496412531_FantasyGolf202_(1).png', '', 0, 0, '', 'WEB', '', '', 0, NULL, '', 0, '', ''),
(61, '217.165.113.147', 'rani', '$2y$08$gdWCXgqc52p3BFkKVD2cfOFgngw6XhsNZN3NKfEzzVOKDyUOZuOki', 'bMCssndg1cGZHA6siegfXu', 'rani@diayafa.com', NULL, NULL, NULL, NULL, 1497953677, NULL, NULL, NULL, NULL, NULL, 1501493149, 1, 'Rani', 'Maalouf', NULL, '0097111111', 'MALE', '1950-06-13', 1, NULL, 1, '', NULL, 0, 0, '3433355444', 'IOS', 'rttrtrr65656565', NULL, 0, NULL, NULL, 0, 'e2fcc4ee-438a-cd19-6f11-8227a5dcd3a8', '123456'),
(62, '183.182.87.242', 'manish.mobiwebtech', '$2y$08$4DMQqdeS1q8sIRwJGVs9L.sk.99nZzxjfvkXMM2HNDtJT.I91QY8y', '', 'manish.mobiwebtech@gmail.com', NULL, 'ysqp1Ap84lqr1sWtFQmAc.b14336f4b81ee69fac', 1500104017, NULL, 1497955029, NULL, NULL, NULL, NULL, NULL, 1501503580, 1, 'James', 'Marker', NULL, '3698521478', 'MALE', '1991-03-13', 1, NULL, 1, 'uploads/users/img5.png', 'uploads/users/img5.png', 0, 0, '3433355444', 'IOS', 'rttrtrr65656565', 'eNortjIxslLKTczLLM7Qy81PyixPTSpJTc5wSM9NzMzRS87P1TUz0jU0sbQwMTc1MzRXsgZcMK92D5E.', 0, NULL, NULL, 0, '33bef3b9-66a6-7a04-a40f-d0a5c2ed2ca5', '12345678abc'),
(63, '183.182.87.242', 'suhail.mobiwebtech', '$2y$08$uyHN1EsZa0RpkWvd2WqOjuE.Pywp07.RXJo5AWqt7mn3eJtZmqJKi', 'xJW1b2KKJXyPrYAjfiN4q.', 'suhail.mobiwebtech@gmail.com', NULL, NULL, NULL, NULL, 1497955089, NULL, NULL, NULL, NULL, NULL, 1503673122, 1, 'Suhail', 'KHAN', NULL, '9758456212', 'MALE', '1990-06-05', 1, NULL, 1, 'uploads/users/name6.png', 'uploads/users/name6_thumb.png', 1, 0, '', 'ANDROID', '', 'eNortjIxslIqLs1IzMzRy81PyixPTSpJTc5wSM8FiSTn5-qaGesamhoYGJgYGZiZKVkDXDCvxQ98', 0, NULL, NULL, 0, '3e995b4a-8759-0b6d-5075-a3a8cd1ccd52', '123456'),
(65, '183.182.87.242', 'chris.mobiwebtech', '$2y$08$nS6pOk4C9R711SFqIl.hOO7QgZR0Th/FdQs8/r2iq6Qtcruo0Zffq', 'KE8EUGcDKLbaHTP0vl.hXu', 'chris.mobiwebtech@gmail.com', NULL, NULL, NULL, NULL, 1498201043, NULL, NULL, NULL, NULL, NULL, 1502364763, 1, 'Chris', 'Anderson', NULL, '9981286964', 'MALE', '2017-04-29', 1, NULL, 1, 'uploads/users/img27.png', 'uploads/users/img27_thumb.png', 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'a2cf9015-e877-5e99-a182-f664ea723594', 'C123456'),
(66, '183.182.87.242', 'tarun', '$2y$08$Bsy2wvvEEsDCwq3/B8vJ8evUGYYLmodnYwiUJIW4tt2AkDSamDnuO', 'fLi9.mW8z4WrteriFAyWQu', 'tarun@mobiwebtech.com', NULL, NULL, NULL, NULL, 1498201103, NULL, NULL, NULL, NULL, NULL, 1503930168, 1, 'Tarun', 'Goud', NULL, '9981286964', 'MALE', '1969-12-31', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', 'eNortjI2tVIqSSwqzXPIzU_KLE9NKklNztBLzs_VNTPTNTSxtDAyMjYwM1ayBlwwOjAM-w..', 0, NULL, NULL, 0, 'c4cb7dfe-18f4-c889-e984-3edfee49978c', 'abcd12345'),
(67, '183.182.87.242', 'Aaksh', '$2y$08$CPg5oxoYB11XmVr9Sdr6rOwYkcjiFEAMhZguVGr.j22wcFFVSSvvW', 'j/6WHZnDcKbxZltTULgxYe', 'aaksh@mobiwebtech.com', NULL, NULL, NULL, NULL, 1498201864, NULL, NULL, NULL, NULL, NULL, 1503930990, 1, 'Akash', 'Bhatnagar', NULL, '9981286964', 'MALE', '1969-12-31', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '7c9d1731-eed2-c281-1c73-41971c53dcff', 'A123456'),
(68, '183.182.87.242', 'dashrath', '$2y$08$NI7SQscrxKdFomr6jL/JwOwfnK/YqfQZyZWGfwZodbQv2HfOMjxWS', 'Sm3F7wZ8A1b2kqtGrZwvSu', 'dashrath@mobiwebtech.com', NULL, NULL, NULL, NULL, 1498202081, NULL, NULL, NULL, NULL, NULL, 1501494418, 1, 'Dashrath', 'Rathoree', NULL, '9981286964', 'MALE', '1969-12-31', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '984fd2cd-e055-0bf4-3257-e125c6c0e6a3', '123456'),
(69, '183.182.87.242', 'Manish', '$2y$08$8qnZ/.ygPDabTfi2bngcCeMPbC7doLadMTfPezj82k67x1l5PCRAe', 'bE5ZqxxiXRhqXrhK1lxMzO', 'manish@mobiwebtech.com', NULL, NULL, NULL, NULL, 1498202179, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Manish', 'Jaiswal', NULL, '9981286964', 'MALE', '1969-12-31', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, '123456'),
(71, '183.182.87.242', 'surbhi', '$2y$08$kRMcufQkKoOo9OhoGcpksumMSTfi4UHZERVJ0jmNC2rLpu9.vCYRy', 'USl4wLuRM8oa1H9qHiJcSO', 'surbhi@mobwebtech.com', NULL, NULL, NULL, NULL, 1498205835, NULL, NULL, NULL, NULL, NULL, 1502357887, 1, 'Surbhi', 'Choudhary', NULL, '9981286964', 'FEMALE', '1969-12-31', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '0eec814a-ace4-f2bc-a74b-5ad637ebd07b', 'S123456'),
(72, '183.182.87.242', 'kunal', '$2y$08$gNIhetvepRQit/C85F3vyuHK9CsetRRXUunR3iswroBnBj8bEwVJC', 'QAbwJ7srFFdbyr63F0HOde', 'kunal@mobiwebtech.com', NULL, NULL, NULL, NULL, 1498205892, NULL, NULL, NULL, NULL, NULL, 1502705389, 1, 'Kunal', 'Nigam', NULL, '9981286964', 'MALE', '1969-12-31', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '0d609df8-ef88-68f7-0bca-97fd654d9c99', 'k123456'),
(74, '43.229.224.75', 'rahul.mobiwebtech', '$2y$08$VIWJGaQGx.ZVgNvkrq7l6.sQyUlRbENscZYKTI1EobHrwIDeLMCPG', 'IfXLnBd66TLEMIKYCYmtVO', 'rahul.mobiwebtech@gmail.com', NULL, NULL, NULL, NULL, 1498215384, NULL, NULL, NULL, NULL, NULL, 1499322931, 1, 'Rahul', 'Pareta', NULL, '9826458985', 'MALE', '1989-01-26', 1, NULL, 1, '', NULL, 0, 0, '3433355444', 'IOS', 'rttrtrr65656565', NULL, 0, NULL, NULL, 0, '22d39ae9-3c29-79a5-d14b-e7e7ed183e1d', ''),
(75, '43.229.224.75', 'ranveer.mobiwebtech', '$2y$08$Iprz9Z/Sm5KBhxv80cvb8uBQNhNp8WM0CHY.QR9l61fZOrq1jb9mW', 'jVw1tdxU90Zzf42R0rhdJu', 'ranveer.mobiwebtech@gmail.com', NULL, NULL, NULL, NULL, 1498215434, NULL, NULL, NULL, NULL, NULL, 1503672312, 1, 'Ranveer', 'Saini', NULL, '9632587412', 'MALE', '1990-02-01', 1, NULL, 1, '', NULL, 0, 0, '3433355444', 'IOS', 'rttrtrr65656565', NULL, 0, NULL, NULL, 0, '7658a4df-6f73-3d78-a85a-4c8b9c235687', '123456'),
(76, '43.229.224.75', 'deepak.mobiwebtech', '$2y$08$TUpB61vWYz2nrFkrMXNzV.ho4VGHaKMKUqIyHyKIJUwGy5rL/tXD.', 'dEnMOL0wLTKGjaRimS0Ip.', 'deepak.mobiwebtech@gmail.com', NULL, NULL, NULL, NULL, 1498215495, NULL, NULL, NULL, NULL, NULL, 1503558613, 1, 'Deepak', 'Shrivastava', NULL, '7896541236', 'MALE', '1990-03-24', 1, NULL, 1, '', NULL, 0, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'b6166e1c-6b8d-5519-b539-a9c498c0db2a', 'Suhailk.18'),
(77, '43.229.224.75', 'neha.mobiwebtech', '$2y$08$MJq0pkU99VgJnI5nKlZT9Okt40MLk5RqMtP85AVbmlIB4d3AJuOw2', 'wStyQaBxHWdrH.T.mwRA.u', 'neha.mobiwebtech@gmail.com', NULL, NULL, NULL, NULL, 1498215553, NULL, NULL, NULL, NULL, NULL, 1501497860, 1, 'Neha', 'Chouhan', NULL, '7896541236', 'FEMALE', '1989-03-25', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '77bd9a93-dc4a-fb03-e45a-b8f6bca8264b', '123456'),
(78, '43.229.224.75', 'sumit.mobiwebtech', '$2y$08$pCpMWfTVYUJiDrk3j18kmOs6d1PZ5Ev37fMt5rk2x1fM5qr9ve86.', 'BDJXtgLwK9v0xZ9zDTbNhe', 'sumit.mobiwebtech@gmail.com', NULL, NULL, NULL, NULL, 1498215603, NULL, NULL, NULL, NULL, NULL, 1499150561, 1, 'Sumit', 'Jagdev', NULL, '1478523698', 'MALE', '1990-04-25', 1, NULL, 1, '', NULL, 0, 0, '3433355444', 'IOS', 'rttrtrr65656565', NULL, 0, NULL, NULL, 0, 'be0d09ea-c282-9dfe-3ea1-a79099d7c6f7', ''),
(79, '127.0.0.1', 'pawan.mobiwebtech', '$2y$08$ps7VKtzv6nNxWvxqoHffdO35a/REw2zSHUDAabibYMC.tNAFxEW/e', 'O8eOGZt73k1PWUfYY/09AO', 'pawan.mobiwebtech@gmail.com', NULL, NULL, NULL, NULL, 1498632063, NULL, NULL, NULL, NULL, NULL, 1501493427, 1, 'pawan', 'sen', NULL, '9856200213', 'MALE', '2017-07-26', 1, NULL, 1, 'uploads/users/name28.png', 'uploads/users/name28_thumb.png', 0, 0, '', 'ANDROID', '', 'eNortjIxtFIqSCxPzNPLzU_KLE9NKklNznBIz03MzNFLzs_VNbfUNTQ1MDCwtLAwNlOyBlwwm8APIw..', 0, NULL, NULL, 0, 'b2dbe718-891a-9960-1076-6d79c1918195', '123abc'),
(121, '43.229.224.75', 'suresh.rathore', '$2y$08$a/3vRy1PQUOqmrmTvLGTCOfchRzA/rEGMMS/zsfA2UTn1iNbSR.lu', '4Gh1uIZvB24DI9vpGKGdmO', 'suresh.rathore@mailinator.com', NULL, NULL, NULL, NULL, 1501147350, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Suresh', 'Rathore', NULL, '9827459981', 'MALE', '1981-10-26', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, '123456'),
(124, '43.229.224.75', 'vijay.rathore', '$2y$08$4/XaVFUAuVzYTb7dwE3qQ.opWkvTjbw8Va0jZvc8FA5XmrhQi0QMO', 'z8ilBjUuVkws.1XHSqzMSe', 'vijay.rathore@mailinator.com', NULL, NULL, NULL, NULL, 1501147522, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Vijay', 'Rathore', NULL, '9827459981', 'MALE', '1983-10-24', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, '123456'),
(125, '43.229.224.75', 'dashrathrathore', '$2y$08$GRabQacMUGbXD0RmvoR68uenZ6D1Xa3wPdVQ2X7vZ.32m1Av7H3XW', '09SgCTk2rLZaAMpF2gekOO', 'dashrathrathore@mailinator.com', NULL, NULL, NULL, NULL, 1501147567, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Dinesh', 'Rathore', NULL, '9827459981', 'MALE', '1984-06-12', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, '123456'),
(126, '43.229.224.75', 'ramesh.rathore', '$2y$08$0wq8gQ18OEaZVutOkeFX0uDgcjXngLNmCKSo7SDD/USnxm0KF0c2i', 'TyXx.ogxdtG8K.noUVqvru', 'ramesh.rathore@mailinator.com', NULL, NULL, NULL, NULL, 1501147612, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Ramesh', 'Rathore', NULL, '9827459981', 'MALE', '1985-07-17', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, '123456'),
(127, '43.229.224.75', 'kishan.rathore', '$2y$08$4zfeRcRQZG7vE9Y74TVsTuew3JXNbehpZq8GOw.xugvuEsz833z3a', 'ORGhP0EAWVAmTluxuxhYKu', 'kishan.rathore@mailinator.com', NULL, NULL, NULL, NULL, 1501147665, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Kishan', 'Rathore', NULL, '9827459981', 'MALE', '1983-06-13', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, '123456'),
(128, '43.229.224.75', 'rohit.rathore', '$2y$08$nL1kAZ1Nahr43YylctoyweQlePlFU.ZddmbKy3pD9Y.JVH7oxHQlO', 'pOFgEjwN.WZFRtSuTmKqIu', 'rohit.rathore@mailinator.com', NULL, NULL, NULL, NULL, 1501147710, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Rohit', 'Rathore', NULL, '9827459981', 'MALE', '1985-07-19', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, '123456'),
(129, '43.229.224.75', 'test', '$2y$08$NFMhHtyavCWRBq1xem/QNewddTQxH4K8XKmxmh/Yul.AwCpCVJFQa', '6YGA6UHcKNzwHcEPmOLRwO', 'test@mailinator.com', NULL, NULL, NULL, NULL, 1501150014, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'test', 'test', NULL, '9827459981', 'MALE', '1969-12-31', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, '123456'),
(131, '43.229.224.75', 'test123', '$2y$08$Yq0hktUjZniOTQ4JOp6t4.U1s1LUL5KOR.0vyPmXUBtZCp6T5l0fu', 'XSe6zYBq9yD5binY/U.mie', 'test123@gmail.com', NULL, NULL, NULL, NULL, 1501480297, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'test123', 'test123', NULL, '9856969999', 'MALE', '2010-02-09', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'eKctlDoa'),
(132, '43.229.224.75', 'test', '$2y$08$Jc1t56nPDyfmnVtcU5YdyuRqhcUiE2EsndYN3/gIbL7YSfJwcX1Bq', 'Nv4jUaogNYF2j85o.AgMpe', 'test@gmail.com', NULL, NULL, NULL, NULL, 1501487434, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'test', 'test', NULL, 'test', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, '0C7AQG8!'),
(134, '43.229.224.75', 'dashrath.ratan', '$2y$08$8uTD0SAP7NjU8THctg/mOuPcnNLk39PEaiUNUD/pE2uTlxKMwIA1y', '8d8DVJ2EKNGes488T1PXqu', 'dashrath.ratan@mailinator.com', NULL, NULL, NULL, NULL, 1501578094, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Dashrath', 'Ratan', NULL, '9827459981', 'MALE', '2010-02-09', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, '123456'),
(135, '43.229.224.75', 'nitin.ratan', '$2y$08$jXHvHSTR/MtZ0H6e87/6netlXi32VkfSzOBM5aQYW07puX92p7pvO', 'YbcEQrl4oGMqgvlXAO8M.O', 'nitin.ratan@mailinator.com', NULL, NULL, NULL, NULL, 1501578186, NULL, NULL, NULL, NULL, NULL, 1501584436, 1, 'Nitin', 'Ratan', NULL, '9827459981', 'MALE', '1983-09-17', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'cde1355a-9bd1-4b7e-d987-e95bf13b5eb3', '123456'),
(136, '43.229.224.75', 'santosh.ratan', '$2y$08$rWjlIxxnNzoCYu6cEdjbH.4BztEHLbZAhS0SP6nFNHYog9TWYpYta', '8vBfttG1RPd9v296JuuLee', 'santosh.ratan@mailinator.com', NULL, NULL, NULL, NULL, 1501578242, NULL, NULL, NULL, NULL, NULL, 1501580727, 1, 'Santosh', 'Ratan', NULL, '9827459981', 'MALE', '2010-02-02', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '324a50bb-b152-c684-8bd4-bc24630b29e2', '123456'),
(138, '43.229.224.75', 'rahul.ratan', '$2y$08$PgNaY0mUk.rfbsT7jKdf6OPS0JD0ZkFY14PsTqST25n2Nv1RfaT92', 'Ow2kKAz/41CjEbs3drZWce', 'rahul.ratan@mailinator.com', NULL, NULL, NULL, NULL, 1501578345, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Rahul', 'Ratan', NULL, '9827459981', 'MALE', '2010-02-02', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, '123456'),
(140, '43.229.224.75', 'deep.ratan', '$2y$08$SPUGhtO8pNKPuvzoyImEfe.GGBopawmoghQ9Yz9U.TVBqLYZAzVxO', 'ooHtItu0zeKYIp2E/yQqCO', 'deep.ratan@mailinator.com', NULL, NULL, NULL, NULL, 1501578444, NULL, NULL, NULL, NULL, NULL, 1501584273, 1, 'Deep', 'Ratan', NULL, '98527459981', 'MALE', '2012-04-06', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'cc00741f-c4d0-5d19-bc52-ebd750ad4497', '123456'),
(141, '43.229.224.75', 'ved.ratan', '$2y$08$/PFjBn1rIVjWiZpu1qclcu.BRy63doZIXFAmplI.y9tBFnGyorfIS', '5YlHnKauULGzxD5GlqR/1O', 'ved.ratan@mailinator.com', NULL, NULL, NULL, NULL, 1501578487, NULL, NULL, NULL, NULL, NULL, 1501589845, 1, 'Ved', 'Ratan', NULL, '9827459981', 'MALE', '2014-06-10', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'fc24ed5f-dabe-1c0d-2e78-63750d1e6136', '123456'),
(142, '43.229.224.75', 'ranga.ratan', '$2y$08$Nz8ooIji5onTuK0G4QsOluvZc1lxT5.dfn6TofaQY6ELKUdUajumC', 'O.YNohx6Mgx.ELt28Bz.i.', 'ranga.ratan@mailinator.com', NULL, NULL, NULL, NULL, 1501595074, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Ranga', 'Ratan', NULL, '9827459981', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, '123456'),
(143, '43.229.224.75', 'test.ratan', '$2y$08$x17BKX9HfMAl/gxmYWoK9u5iX29CGL9FFNKyIoudjjLxpr6B7lanC', 'uFMs6ZOKgiDZdGEgOrZCxO', 'test.ratan@mailinator.com', NULL, NULL, NULL, NULL, 1501595399, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Test', 'Ratan', NULL, '9827459981', 'MALE', '2015-07-15', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, '123456'),
(145, '43.229.224.75', 'Virat.rathore', '$2y$08$7m4TJrwZDn242LQrV.XdyevWxW2Emu8u4m6sz3VsV0vQl9tnbyTqi', '1xbScRG2kVSJt/Tjfpl4IO', 'virat.rathore@mailinatgor.com', NULL, NULL, NULL, NULL, 1502273910, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Virat', 'Rathore', NULL, '9827459981', 'MALE', '2010-02-02', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'D@shrath1'),
(146, '43.229.224.75', 'manoj.virat', '$2y$08$fYPkg.q7fQgEyON83EiHa.iUWJhZrXsys2fNlA565f8wEo/1KbZFS', 'Y8CkaGuwedBu53v6MGhGw.', 'manoj.virat@mailinator.com', NULL, NULL, NULL, NULL, 1502274005, NULL, NULL, NULL, NULL, NULL, 1504095350, 1, 'Manoj', 'Virat', NULL, '9827459981', 'MALE', '1983-09-17', 1, NULL, 1, 'uploads/users/name31.png', 'uploads/users/name31_thumb.png', 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'd808b872-06ec-bafa-8a73-426306436789', 'Suhailk.18'),
(147, '43.229.224.75', 'amit.virat', '$2y$08$KR5BRhJiM8tw7urAewBpiedEOtaXoO3lJ2LYmsNqJwk/d3TLNRGI.', 'VCfxuNeZRR1jjXUAvXRXyu', 'amit.virat@mailinator.com', NULL, NULL, NULL, NULL, 1502274260, NULL, NULL, NULL, NULL, NULL, 1503904407, 1, 'Amit', 'Virat', NULL, '9827459981', 'MALE', '1969-12-30', 1, NULL, 1, 'uploads/users/name30.png', 'uploads/users/name30_thumb.png', 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'ec3d3173-15a9-fb40-3af9-c29f92c31374', 'D@shrath3'),
(148, '43.229.224.75', 'Vishal.virat', '$2y$08$ICM2GOZKCiti1CNpqm5N3uLK1n6UtCFyUXsgT2MfxuNHuUoxGCpKq', 'jEiIgWHESYqYgJzpU8mkiu', 'vishal.virat@mailinator.com', NULL, NULL, NULL, NULL, 1502274344, NULL, NULL, NULL, NULL, NULL, 1504010353, 1, 'Vishal', 'Virat', NULL, '9827459981', 'MALE', '2015-07-15', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '6636ba43-1882-7521-f158-b22543a8bbed', 'D@shrath1'),
(149, '43.229.224.75', 'Wasim.virat', '$2y$08$Gi8mvr9BEYoX6/ysAw7fLOXi1/Mpezfe6YfJB2uZa6ndarHJZj2/C', 'owtMrIwuMKAcIKrxWSUES.', 'wasim.virat@mailinator.com', NULL, NULL, NULL, NULL, 1502274836, NULL, NULL, NULL, NULL, NULL, 1503053840, 1, 'Wasim', 'Virat', NULL, '9827459981', 'MALE', '2015-07-15', 1, NULL, 1, 'uploads/users/1503485230_3.jpg', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '5370239f-9145-3f9e-09cf-41c9cbd71b90', 'D@shrath1'),
(150, '43.229.224.75', 'santosh.virat', '$2y$08$pM4OtWRlrnoISJuDELzATe6DGjHrbLQwlIdPYdBbopq0JxZUTjyma', 'lID6PUIeAaGRJ8lHr2uq7u', 'santosh.virat@mailinator.com', NULL, NULL, NULL, NULL, 1502274896, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Santosh', 'Virat', NULL, '9827459981', 'MALE', '2010-02-02', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'D@shrath1'),
(151, '43.229.224.75', 'ved.virat', '$2y$08$WozPJiQVmNfbgJEyOEbsIe/NrcAScCN5ZGu2AKPEgQLRd5/3UANr2', 'GDJB1LJSJCyDJ3hZkZRUPe', 'ved.virat@mailinator.com', NULL, NULL, NULL, NULL, 1502274942, NULL, NULL, NULL, NULL, NULL, 1502868613, 1, 'Ved', 'Virat', NULL, '9827459981', 'MALE', '2010-02-09', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'ddde23ae-b79f-7c8e-6b2e-ca6f5a979ac7', 'D@shrath1'),
(152, '43.229.224.75', 'ankit.virat', '$2y$08$3UB30rxrxw6Uz9r65d23Zer85GcHvR5a5HLOP3p7RF6b1fe9S8h/q', 'p4vQigLdvxC7/988u6jqie', 'ankit.virat@mailinator.com', NULL, NULL, NULL, NULL, 1502274982, NULL, NULL, NULL, NULL, NULL, 1502877352, 1, 'Ankit', 'Virat', NULL, '9827459981', 'MALE', '2015-07-15', 1, NULL, 1, '', NULL, 1, 0, '1D4BEEC5-BDCE-4586-A18E-A57AAB7D1270', 'IOS', '2E464D52-A726-43C4-A369-87E7F6CE1D67', NULL, 0, NULL, NULL, 0, 'f11d0822-51b9-2e3f-6bd1-d96b37b4881c', 'D@shrath1'),
(165, '43.229.224.75', 'ertertertert', '$2y$08$0Y3W2719XyToW1m4A5.DouAuV8.FsXfol3wcH1zLEic/LXYu/.uwm', 'LnAexPcD1HgmRhwOq2uj0e', 'ertertertert@gmail.com', NULL, NULL, NULL, NULL, 1502973695, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'erterter', 'terterter', NULL, '98566699989', 'MALE', '2010-02-02', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'd5pJydfg'),
(166, '183.182.87.242', 'vinod.virat', '$2y$08$hhi5oJBLAcDEEoBoR6Ol0eHqobjTca4wl78ORciDgnm9dHMkMUIdK', 'yjwdWQoxDc4phJb85SQkVu', 'vinod.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503047013, NULL, NULL, NULL, NULL, NULL, 1503047573, 1, 'Vinod', 'Mankere', NULL, '9827459987', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'f04b2b24-c7bc-4b5f-7bdb-ebe88e7738d9', 'D@shrath1'),
(167, '183.182.87.242', 'atul.virat', '$2y$08$S6fNsjbzp1VLLWSGN0IW6ewEaTRCUismxy5YPa4gZX.hPRS.BSWFW', '8fowan0a.stY9VEQDk2bRe', 'atul.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503057470, NULL, NULL, NULL, NULL, NULL, 1503473554, 1, 'Atul', 'Virat', NULL, '9827459981', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '82139d4f-530b-a922-bf64-a1bd529db8d1', 'D@shrath1'),
(168, '43.229.224.75', 'zaheer.khan', '$2y$08$YWN50zKDK1MU2dGjFUDwGeed1tCcN4t9vwV7mqdzif/M0VHs.3/Wa', 'A17NgWRhkVdcuZnEt.XPDu', 'zaheer.khan@mailinator.com', NULL, NULL, NULL, NULL, 1503145850, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zaheer', 'khan', NULL, '9827459981', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'D@shrath1'),
(169, '183.182.87.242', 'vivan', '$2y$08$JREzHpiGUdAQ34e3cOYSPu.yK1tmfV4JNA489UXl7B2YH6bPDOcZe', 'kKW70qljdPlNtsExlD2gL.', 'vivan@gmail.com', NULL, NULL, NULL, NULL, 1503403393, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Vivan', 'Singh', NULL, '9856988888', 'MALE', '2010-06-15', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'Ni@JQ148'),
(170, '43.229.224.75', 'jayesh.virat', '$2y$08$xcYQsz/ofE1hWxptzXeEGen/aaP1cPVq64DAJ8U2D8xEgtjwS60zC', 'MATU06uuhAlkmhym6DkPce', 'jayesh.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503474395, NULL, NULL, NULL, NULL, NULL, 1503903986, 1, 'Jayesh', 'Virat', NULL, '9827459981', 'MALE', '2017-05-15', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '05f4dade-4ac0-a9c2-74e9-38bf84d84ed0', 'D@shrath1'),
(171, '43.229.224.75', 'raju.virat', '$2y$08$xGhhdgqkVevg9QHroh/8eOewrbZNHlCgw0uRdPRCD8cXwhjmKO/iW', 'luzytJ2GF3fMQ.0QZRC6Ju', 'raju.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503567963, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Raju', 'Raghuwanshi', NULL, '9827459981', 'MALE', '1983-06-01', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'D@shrath1'),
(172, '43.229.224.75', 'govinda.virat', '$2y$08$tyIwXK.w2YHlIqFAXssf0.AhMc0hC9psuGKhGilRuHE8HcJNY7f4G', 'ivKqGs93NQteqF74VJEf0e', 'govinda.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503568658, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Govinda', 'Bhagat', NULL, '9827459981', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'D@shrath1'),
(173, '43.229.224.75', 'pankaj.virat', '$2y$08$fHdjwFbHpt0iacjs7zjHV.5NWA8HS1TQpLvY5tgyOHPSFbc6u3/D6', '1AmzhPFe.1UEzfiQaNbDmO', 'pankaj.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503568706, NULL, NULL, NULL, NULL, NULL, 1503578316, 1, 'Pankaj', 'kumar', NULL, '9827459981', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'ceccbf10-123e-ec53-9ebe-7594c77ec6ee', 'D@shrath1'),
(174, '43.229.224.75', 'prashant.virat', '$2y$08$Qgvrtfazm.c36R6YDYuaP.RuQAz3K7oJKhXhz837Pg7AhntoC51Fm', 'QIZrMY8pNymJShKLlnjFle', 'prashant.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503568792, NULL, NULL, NULL, NULL, NULL, 1503672097, 1, 'Prashant', 'Tiwari', NULL, '9827459981', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '7e987fb4-1288-f06d-3f6c-6b7fbe71c8d5', 'D@shrath1'),
(175, '43.229.224.75', 'bhuwan.virat', '$2y$08$CRUOBpOuQZpWdj4R01QDKu9SvKZm/gwCbH1yrUjm7M/vX3LF7ueeS', '65jLouO5tE8JywKVUVEtQu', 'bhuwan.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503574247, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Bhuwan', 'B', NULL, '9827459981', 'MALE', '2010-02-08', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'D@shrath1'),
(176, '43.229.224.75', 'suraj.virat', '$2y$08$Rtw3YcAPItA5TmIIrwr5vuQY9oGxWybH7xEiT9cnypTSuLIs0tfh.', 'oaqtyTEA2D9VwooaX.4ar.', 'suraj.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503576621, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Suraj', 's', NULL, '9827459981', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'D@shrath1'),
(177, '43.229.224.75', 'suny.virat', '$2y$08$veT3PKkQK90z6xPlWzmx7OQe1p6ir1it6SFmxTGbkIJcRbRrZPLkm', '4CfWjRVEqgaloTRqMOpide', 'suny.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503576760, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Suny', 's', NULL, '9827459981', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'D@shrath1'),
(178, '43.229.224.75', 'Sauragh.virat', '$2y$08$rS6ZVJ9sbtKicS1Ng.KOZeYoc2VW0PlVnqVNuK17AWDbORZQFCmUK', 'taZR5UDycro2OiGMmGiLnu', 'sauragh.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503577275, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Saurabh', 'S', NULL, '9827459981', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'D@shrath1'),
(179, '43.229.224.75', 'dinesh.virat', '$2y$08$Igf5kH8MRNXt.rCCUNJGQ.c4NxRRxFKh3Bac/cADx20MfQnkO7jlG', 'OET6R8qIMmRZMHksrCZjqe', 'dinesh.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503578493, NULL, NULL, NULL, NULL, NULL, 1503999418, 1, 'Dinesh', 'R', NULL, '9827459981', 'MALE', '2010-02-06', 1, NULL, 1, '', NULL, 0, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '772e439b-cfd1-b605-b234-db3179e5313c', 'D@shrath1'),
(180, '43.229.224.75', 'animesh.virat', '$2y$08$Fu06vsGJuHVE4H7Ceonr9O/1nTDQEOFKNPIapYuOR.qrQvggMmPQW', 'lh5T7nUbpA11gI5YoGhAfu', 'animesh.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503578727, NULL, NULL, NULL, NULL, NULL, 1503662171, 1, 'Animesh', 'R', NULL, '9827459981', 'MALE', '2010-02-08', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '431147b9-8c85-ff26-4b35-34933289ecb5', 'D@shrath1'),
(181, '43.229.224.75', 'dershika.virat', '$2y$08$PV3YY2vJEl3fMS754d9GJu5xOFmbrMJMsCzvwplhLypOIFyjdqnQm', 'jkVaCs4AL9p5UtByhaGdSe', 'dershika.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503578994, NULL, NULL, NULL, NULL, NULL, 1503656277, 1, 'Dershika', 'R', NULL, '9827459981', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '61045fd0-7132-0ad8-a367-b61fed8c09f2', 'D@shrath1'),
(182, '43.229.224.75', 'janvi.virat', '$2y$08$JTuhFHYljKpsXjyuVYjDm.URM9Js5LS6nk6rbYTPe0.vpz6d2HlMC', 'SR5vNa87qRMzzLog8i8ew.', 'janvi.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503581535, NULL, NULL, NULL, NULL, NULL, 1503661650, 1, 'Janvi', 'R', NULL, '9827459981', 'MALE', '2011-03-02', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'cf0deeb3-6b8e-08d0-44ae-e4e3afe9e538', 'D@shrath1'),
(183, '43.229.224.75', 'kritika.virat', '$2y$08$nxHbvFuMgrqFcv.oxV5nh.0FX579FpXKPckNYFYNAPM72ZXGriZ3q', 'TD76Ahky1Z/0hbmKTsDXpu', 'kritika.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503647886, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Kritika', 'K', NULL, '9827459981', 'FEMALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'D@shrath1'),
(184, '43.229.224.75', 'yesh.virat', '$2y$08$s1nk560JsqTQLKrJBTf0ZO85dOy7xPQ9aiQQfDbgxGurE/UFnDeb.', '6O4mshrERopZ9huAxsjri.', 'yesh.virat@mailintor.com', NULL, NULL, NULL, NULL, 1503658127, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Yesh', 'R', NULL, '9827459981', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'D@shrath1'),
(185, '43.229.224.75', 'imran.virat', '$2y$08$OSLbamLl.zn1z32ZxQB8q.bhP90ce.q02r7yxTpXV9laxvjHDtwzW', '71qoiOa1WOTaY3RL5hz/je', 'imran.virat@mailinator.com', NULL, NULL, NULL, NULL, 1503918636, NULL, NULL, NULL, NULL, NULL, 1504097640, 1, 'Imran', 'K', NULL, '9827459981', 'MALE', '2003-01-01', 1, NULL, 1, '', NULL, 0, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '85a973f5-a3be-53cb-85e2-7d01765133b3', 'D@shrath1'),
(186, '43.229.224.75', 'ts', '$2y$08$zgvNl0IxyvDR.qGuOHejPOHXjE5fZ1FRg9lYYO9bLkGOedGpGchKq', 'F4mr66RfnVB6DJiBr/Hd3O', 'ts@gmail.com', NULL, NULL, NULL, NULL, 1503988128, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'ts', 'ts', NULL, '9827459981', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'V9tOyW27'),
(187, '217.165.114.23', 'bernard.west', '$2y$08$JCHmw3hzcECZG6mQAAiEMOGYDaAZoHRXZknbZaPdW578Vtfc3088a', 'CoHvNp6BysH90M0OxSAbo.', 'bernard.west@test2.com', NULL, NULL, NULL, NULL, 1503990193, NULL, NULL, NULL, NULL, NULL, 1503994620, 1, 'Bernard', 'West', NULL, '+97122222222', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'c310836c-11f6-a98c-93c3-ee251307fae6', 'A1234567'),
(188, '217.165.114.23', 'rose.simon', '$2y$08$AkLcBGl5u88PJVza/mpqaeZgTf3uFrkdag.AAybFxN8Ucb1BzoshO', 'Ho/RjcU6U0RmKvl1DC68HO', 'rose.simon@test2.com', NULL, NULL, NULL, NULL, 1503990224, NULL, NULL, NULL, NULL, NULL, 1503994741, 1, 'Rose', 'Simon', NULL, '+971222222222', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '3f8ea585-275e-a72d-bab2-36250837b471', 'A1234567'),
(189, '217.165.114.23', 'jake.guzman', '$2y$08$luFF6m28zgCjzqVJ5/wtrul/gbM7qAmM19zuwYhQZTDqb.6NG.xd2', 'gO2pesKmuf65yXvFfEim3.', 'jake.guzman@test2.com', NULL, NULL, NULL, NULL, 1503990318, NULL, NULL, NULL, NULL, NULL, 1503994782, 1, 'Jake', 'Guzman', NULL, '+971222222222', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '026b0126-09f2-732f-fded-8470dcf74c38', 'A1234567'),
(190, '217.165.114.23', 'gina.wong', '$2y$08$R0SAxK3leFSIY/FRI6NYy.Bz2nCaVJoGenc20/DWLmXdwneH7BE9i', 'yQrUhXPO9dURTE96PWiSQO', 'gina.wong@test2.com', NULL, NULL, NULL, NULL, 1503990398, NULL, NULL, NULL, NULL, NULL, 1503995130, 1, 'Gina', 'Wong', NULL, '+971222222222', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'caf72c08-fa0f-9290-6892-9205a47d8613', 'A1234567'),
(191, '217.165.114.23', 'trevor.hoffman', '$2y$08$kvHqUjkQG1NR5CIGoTHj1u8QDMVXBn6o/lN.0tFCOxGgV5I31Rl/G', 'lKrn0NLS8p3ZGP6gEIpLYu', 'trevor.hoffman@test2.com', NULL, NULL, NULL, NULL, 1503990569, NULL, NULL, NULL, NULL, NULL, 1503995041, 1, 'Trevor', 'Hoffman', NULL, '+971222222222', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'a808b9df-d908-8a1c-5bdc-7f6561e0a999', 'A1234567'),
(192, '217.165.114.23', 'greg.richardson', '$2y$08$wUc288ZMR8ES.FjaUShrKet0CVHU.KbidwNza4/or5sig7qdvsLUi', 'bvq2.8FA6q5vxDhwpERzNO', 'greg.richardson@test2.com', NULL, NULL, NULL, NULL, 1503990612, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Greg', 'Richardson', NULL, '+971222222222', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'A1234567'),
(193, '217.165.114.23', 'frankie.wise', '$2y$08$7N3lobgBVvMB4PZ5.G0pyO4cnoAk0C9MXcR4C7UV658g7l2WZwQXy', 'jDvUCoF8cZn7h1UY7eoGqu', 'frankie.wise@test2.com', NULL, NULL, NULL, NULL, 1503990647, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Frankie', 'Wise', NULL, '+971222222222', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'A1234567'),
(194, '217.165.114.23', 'mark.townsend', '$2y$08$sNH92sQqAckW6c9ud2w7deo4eOevDOhqwkdaCF4HJYqxwJ5yIEV/a', 'j/LxP3CX2Mqvw9gsLmHyH.', 'mark.townsend@test2.com', NULL, NULL, NULL, NULL, 1503990678, NULL, NULL, NULL, NULL, NULL, 1503992308, 1, 'Mark', 'Townsend', NULL, '+971222222222', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'ca6b62b7-1b77-b014-178b-ddcff8cb0ce7', 'A1234567'),
(195, '217.165.114.23', 'alice.cohen', '$2y$08$NFjw/HjopH68nwZcKcMcLOm14RgekOk9YXkQeZrzZWhh1Dy9jl35q', 'sj2aPEUilqLLRuYfR1zOte', 'alice.cohen@test2.com', NULL, NULL, NULL, NULL, 1503990706, NULL, NULL, NULL, NULL, NULL, 1503992276, 1, 'Alice', 'Cohen', NULL, '+971222222222', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '81e1b312-44a8-c1fe-e4dc-19d0661157b6', 'A1234567'),
(196, '217.165.114.23', 'garry.farmer', '$2y$08$gGmg70LECXuTW2VKq9YXoOfttn34F.BrHumLhaOQNVxohd/NngTfO', 'tl.bpXfVEIwAdtS.9JaQee', 'garry.farmer@test2.com', NULL, NULL, NULL, NULL, 1503990738, NULL, NULL, NULL, NULL, NULL, 1503992437, 1, 'Garry', 'Farmer', NULL, '+971222222222', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, '64f28f27-b486-5fc6-f3d4-62ac924cd6aa', 'A1234567'),
(197, '217.165.114.23', 'steve.thompson', '$2y$08$HYiixiQlfcvab8fhqIZJwO5w/enhXVWG0pvjsbDowHdQylASNSKJu', 'hWO2TZpKRUP70MRWNQgO4u', 'steve.thompson@test2.com', NULL, NULL, NULL, NULL, 1503990768, NULL, NULL, NULL, NULL, NULL, 1503995059, 1, 'Steve', 'Thompson', NULL, '+971222222222', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 1, 0, '', 'ANDROID', '', NULL, 0, NULL, NULL, 0, 'a63bb4a3-b6af-4ee0-9f48-85d8e906ebcc', 'A1234567'),
(198, '217.165.114.23', 'paul.norton', '$2y$08$2sUGvdmqPR4qw/Wba809SOkrKTCZVyAuofQJNLnOZlUZ3LFP26hbm', 'y/rZBwxIOMI9VIwgQyglte', 'paul.norton@test2.com', NULL, NULL, NULL, NULL, 1503990791, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Paul', 'Norton', NULL, '+971222222222', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'A1234567'),
(199, '43.229.224.75', 'parag.virat', '$2y$08$I8WuvIzCKvjNU/NvVjKBDeBpMZCaUL7paMv5xYOa5FRbDyXWkC2KO', 'u92WbdfPEKaaO8PmvCv0JO', 'parag.virat@mailinator.com', NULL, NULL, NULL, NULL, 1504002796, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Parag', 's', NULL, '9827459981', 'MALE', '0000-00-00', 1, NULL, 1, '', NULL, 0, 0, NULL, 'WEB', NULL, NULL, 0, NULL, NULL, 0, NULL, 'D@shrath1');

-- --------------------------------------------------------

--
-- Table structure for table `users_device_history`
--

CREATE TABLE IF NOT EXISTS `users_device_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `device_token` text NOT NULL COMMENT 'Used to send push notfications',
  `device_type` enum('ANDROID','IOS') NOT NULL,
  `device_id` varchar(150) NOT NULL COMMENT 'Device Unique ID',
  `added_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`),
  KEY `user_id_3` (`user_id`),
  KEY `user_id_4` (`user_id`),
  KEY `user_id_5` (`user_id`),
  KEY `user_id_6` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

--
-- Dumping data for table `users_device_history`
--

INSERT INTO `users_device_history` (`id`, `user_id`, `device_token`, `device_type`, `device_id`, `added_date`) VALUES
(5, 45, 'sdghsdjkjk79879878sdjdfk6hj', 'IOS', '78989sajk89129', '2017-06-02 16:04:49'),
(6, 45, 'sdiufrwerjbkxcv7s8d9f6s87dfsd fbsudfy', 'ANDROID', 'fsdfkjsdfnmvj87689', '2017-06-02 16:31:35'),
(8, 52, '2E464D52-A726-43C4-A369-87E7F6CE1D67', 'IOS', '86F29D83-B781-45CB-AE84-D4F63966388C', '2017-06-15 05:19:25'),
(9, 52, '2E464D52-A726-43C4-A369-87E7F6CE1D67', 'IOS', '8321497E-83BA-4428-A995-5F2239850428', '2017-06-15 08:19:43'),
(10, 52, '2E464D52-A726-43C4-A369-87E7F6CE1D67', 'IOS', '63D99AA2-5129-4476-9851-3A07197A88E4', '2017-06-16 03:14:21'),
(11, 52, '2E464D52-A726-43C4-A369-87E7F6CE1D67', 'IOS', 'C3B9669B-1DE8-4A76-9C29-6F223EE25752', '2017-06-16 03:19:40'),
(12, 52, '2E464D52-A726-43C4-A369-87E7F6CE1D67', 'IOS', 'C7FD118C-776F-4084-895E-2B6197B49DC3', '2017-06-16 03:29:49'),
(14, 52, '2E464D52-A726-43C4-A369-87E7F6CE1D67', 'IOS', 'C2862D9B-CF3A-41C7-AA7C-527CD54C26F0', '2017-06-16 03:53:04'),
(15, 52, '2E464D52-A726-43C4-A369-87E7F6CE1D67', 'IOS', 'F5A71C29-92C1-456A-95A4-01DEA6692E88', '2017-06-16 06:30:30'),
(16, 52, '2E464D52-A726-43C4-A369-87E7F6CE1D67', 'IOS', '489314C1-6226-400E-9C66-9F6779ECDE6B', '2017-06-16 08:23:35'),
(17, 52, '2E464D52-A726-43C4-A369-87E7F6CE1D67', 'IOS', 'F078D52F-89C1-48B4-8541-7F2D1C0B1DEC', '2017-06-16 08:34:47'),
(30, 63, '', '', '', '2017-06-19 04:52:12'),
(31, 75, 'rttrtrr65656565', 'IOS', '3433355444', '2017-06-19 04:53:23'),
(32, 56, 'rttrtrr65656565', '', '3433355444', '2017-06-19 04:53:52'),
(51, 65, '2E464D52-A726-43C4-A369-87E7F6CE1D67', 'IOS', '773A261F-9BC2-4B6C-AB2E-2AAF1FF73288', '2017-07-17 00:54:58'),
(53, 88, '2E464D52-A726-43C4-A369-87E7F6CE1D67', 'IOS', '610488EC-CA7D-4389-AF2F-99D1A9BCBDDC', '2017-07-17 02:38:30'),
(83, 147, '2E464D52-A726-43C4-A369-87E7F6CE1D67', 'IOS', 'A3884B2C-39C2-4252-9F45-5D147352144A', '2017-08-16 08:32:54'),
(91, 147, '2E464D52-A726-43C4-A369-87E7F6CE1D67', 'IOS', '90D01052-309F-407E-8676-1214FA2CBF20', '2017-08-19 05:43:00'),
(92, 185, '', 'ANDROID', '', '2017-08-29 00:39:32');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=199 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`, `organization_id`) VALUES
(1, 1, 1, 0),
(60, 61, 2, 4),
(61, 62, 4, 4),
(62, 63, 3, 4),
(64, 65, 4, 4),
(65, 66, 4, 4),
(66, 67, 3, 4),
(67, 68, 5, 4),
(68, 69, 5, 4),
(70, 71, 4, 4),
(71, 72, 5, 4),
(73, 74, 5, 4),
(74, 75, 5, 4),
(75, 76, 5, 4),
(76, 77, 5, 4),
(77, 78, 5, 4),
(78, 79, 5, 4),
(120, 121, 2, 13),
(123, 124, 4, 13),
(124, 125, 5, 13),
(125, 126, 5, 13),
(126, 127, 5, 13),
(127, 128, 5, 13),
(128, 129, 5, 13),
(130, 131, 5, 4),
(131, 132, 5, 13),
(133, 134, 2, 14),
(134, 135, 3, 14),
(135, 136, 4, 14),
(137, 138, 5, 14),
(139, 140, 5, 14),
(140, 141, 5, 14),
(141, 142, 5, 14),
(142, 143, 5, 14),
(144, 145, 2, 15),
(145, 146, 3, 15),
(146, 147, 4, 15),
(147, 148, 4, 15),
(148, 149, 5, 15),
(149, 150, 5, 15),
(150, 151, 5, 15),
(151, 152, 5, 15),
(164, 165, 5, 4),
(165, 166, 5, 15),
(166, 167, 5, 15),
(167, 168, 5, 15),
(168, 169, 5, 4),
(169, 170, 5, 15),
(170, 171, 5, 15),
(171, 172, 5, 15),
(172, 173, 5, 15),
(173, 174, 5, 15),
(174, 175, 5, 15),
(175, 176, 5, 15),
(176, 177, 4, 15),
(177, 178, 3, 15),
(178, 179, 3, 15),
(179, 180, 4, 15),
(180, 181, 5, 15),
(181, 182, 5, 15),
(182, 183, 5, 15),
(183, 184, 4, 15),
(184, 185, 5, 15),
(185, 186, 4, 15),
(186, 187, 5, 17),
(187, 188, 5, 17),
(188, 189, 5, 17),
(189, 190, 5, 17),
(190, 191, 4, 17),
(191, 192, 5, 17),
(192, 193, 5, 17),
(193, 194, 5, 17),
(194, 195, 5, 17),
(195, 196, 4, 17),
(196, 197, 3, 17),
(197, 198, 2, 17),
(198, 199, 5, 15);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
