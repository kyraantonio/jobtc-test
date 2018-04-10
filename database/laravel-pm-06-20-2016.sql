-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2016 at 11:16 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `laravel-pm`
--

-- --------------------------------------------------------

--
-- Table structure for table `fp_accounts`
--

CREATE TABLE IF NOT EXISTS `fp_accounts` (
`id` int(10) unsigned NOT NULL,
  `account_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `payment_method_id` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_applicants`
--

CREATE TABLE IF NOT EXISTS `fp_applicants` (
`id` int(10) unsigned NOT NULL,
  `job_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `resume` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `notes` text COLLATE utf8_unicode_ci,
  `hired` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No'
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_applicants`
--

INSERT INTO `fp_applicants` (`id`, `job_id`, `name`, `email`, `phone`, `resume`, `photo`, `password`, `remember_token`, `created_at`, `updated_at`, `notes`, `hired`) VALUES
(4, 10, 'Jane Doe', 'janedoe@gmail.com', '1234567890', 'assets/applicant/resumes\\Sample-Resume-Computer-Programmer-Entry-Level1.doc', 'assets/applicant/photos\\resume_sample_photo.jpg', '$2y$10$rlXQGFPbq58NxUWLUPEDyeNDSqXihFAqE5Aj44Wp3l7.veZmd98m2', 'VjRhUrqI5kv3esoBtMn5FzQNbDGHV851l8VY8ayLcuuel5olBz3USTfAyMdB', '2016-05-23 10:56:55', '2016-06-09 06:46:25', '', 'No'),
(5, 10, 'John Doe', 'johndoe@gmail.com', '1234567890', 'assets/applicant/resumes\\Sample-Resume-Computer-Programmer-Entry-Level1.doc', 'assets/applicant/photos\\testjobseeker.jpg', '$2y$10$eN9t.cCJ4RyDfzi42YSdmu..ca4aR1jML7k6URNFd1MmAq/rsPnKq', '', '2016-05-23 22:09:16', '2016-05-23 22:09:16', '', 'No'),
(6, 10, 'Keith Murner', 'keithmurner@gmail.com', '1234567890', 'assets/applicant/resumes\\Sample-Resume-Computer-Programmer-Entry-Level1.doc', 'assets/applicant/photos\\sample_company_photo_2.jpg', '$2y$10$2GpkmgEEHE8ZB8fhmOvQQeqJmjO2OAwlDGeCIJeCYWoLijoA.eGEG', '', '2016-05-23 22:11:40', '2016-05-23 22:11:40', '', 'No'),
(7, 10, 'Michelle Mackey', 'michellemackey@gmail.com', '1234567890', 'assets/applicant/resumes\\Sample-Resume-Computer-Programmer-Entry-Level1.doc', 'assets/applicant/photos\\sample_company_photo_5.jpg', '$2y$10$nRQMNqd/1IHQK6uMKYJZjO7UVe5gf7J/y9xfeASLRd6/EJ7eMf25i', 'OrYNNDxxn1IEm68KpSq0MYf7Sxr5N3zRB6SEC2gXVrBJTKyNYb4iQVvU602V', '2016-05-23 22:12:22', '2016-06-08 01:06:30', '', 'No'),
(8, 10, 'John Wick', 'johnwick@gmail.com', '1234567890', 'assets/applicant/resumes\\Sample-Resume-Computer-Programmer-Entry-Level1.doc', 'assets/applicant/photos\\testjobseeker.jpg', '$2y$10$7voXqcMtvs4/szsJkZyOg.qYkiNEJaIvMtFiN0m6zJ.EROAAaa16C', 'M3em6eHCDYINL61xfsI2qvaYDOBEy7eojuW2EjNGH8nuGmdosJOW0ITWv5y0', '2016-05-23 22:22:48', '2016-06-07 06:22:20', '', 'No'),
(9, 10, 'Philip Fox', 'philipfox@gmail.com', '1234567890', 'assets/applicant/resumes\\Sample-Resume-Computer-Programmer-Entry-Level1.doc', 'assets/applicant/photos\\testjobseeker.jpg', '$2y$10$qcy.ZGtzdQVJxkgW7xSvzuISg8wZKk06IihXFPw23dl3IaqRiZQzu', 'lonwGPm2uZD7SsiS73bIS4BXj4B4UwJlweTZiqv9W2mxALmq9dA4679q0Ecb', '2016-05-23 22:23:59', '2016-06-07 05:12:46', '<p>Test</p>\r\n', 'No'),
(19, 10, 'Robert Williams', 'robertwilliams@gmail.com', '1234567890', 'assets/applicant/resumes\\Sample-Resume-Computer-Programmer-Entry-Level1.doc', 'assets/applicant/photos\\^BB4810BF879B81C661CFF083B2BF9F1D4958FF5D738137C2AC^pimgpsh_fullsize_distr.jpg', '$2y$10$DL/CZm6NrX2YTxjpp7pjyeSOMuBlNagg4AIPgSzCM/p1PEjGllA4G', 'ZpPxG5XTVkgJlWKEhzUUMUpuJFtm83DDHFYctu0LqkFVEVvuhH2CuyIJTBqQ', '2016-06-03 07:17:00', '2016-06-06 00:08:41', '', 'No'),
(20, 10, 'Robert Castro', 'robertcastro@gmail.com', '', 'assets/applicant/', 'assets/user/avatar.png', '$2y$10$qD24UmZyyPiMcV09FGYPyu.B5lJzyP/xWjEvugyGZGzZzm5y9VgWC', '', '2016-06-03 07:30:53', '2016-06-03 07:30:53', '', 'No'),
(21, 10, 'Jexter Dean Buenaventura', 'jexterdeanbuenaventura@gmail.com', '1234567890', 'assets/applicant/resumes\\Sample-Resume-Computer-Programmer-Entry-Level1.doc', 'assets/applicant/photos\\Snapshot_20160526_2.JPG', '$2y$10$Mt3OWBmoahNqkxypTjQb1OFhzBBnZytldBAQcssipfAOwJLuKu90y', 'HzEhUSEOmJNqR7NwXi2ZYRmvNavhjEzVydd9RuTeARxqgFyJp3pG6wnj7YjR', '2016-06-08 06:30:11', '2016-06-08 07:13:02', '', 'No'),
(25, 10, 'Robert Will', 'robertwill@gmail.com', '1234567890', 'assets/applicant/resumes\\Sample-Resume-Computer-Programmer-Entry-Level1.doc', 'assets/applicant/photos\\testjobseeker.jpg', '$2y$10$uLh7EMucdjI8VrFEYEpqQ.YEEG3fsvbL/FP24UsovJQEBFLK66SZu', '5lyd93pJWkdEgne9nXSewRgksZDQBbT8bCpkr0Vd3KNmW1yozEiT1MW1cGcZ', '2016-06-08 08:52:13', '2016-06-17 05:00:33', '', 'No'),
(37, 29, 'Sheena Hann ', 'sheenahann2+7dt@indeedemail.com ', ' +1 587-586-6572', 'assets/applicant/resumes/ResumeSheena Hann .pdf', 'assets/user/default-avatar.jpg', '$2y$10$iOMms5n3OzzhTReyY..zEuwGTHp6hTG0VQ.fweEZ6wyRog0ZY7nEC', NULL, '2016-06-15 02:51:51', '2016-06-15 02:51:51', NULL, 'No'),
(38, 28, 'Foster Pariseau ', 'fosterpariseau8+s3q@indeedemail.com ', ' +1 587-896-3243', 'assets/applicant/resumes/ResumeFoster Pariseau .pdf', 'assets/user/default-avatar.jpg', '$2y$10$2rL1mCeafiph2D3xFeArLOWinmASzHkF6YKigKJXI8cD1oRPRy1S.', NULL, '2016-06-15 02:52:10', '2016-06-15 02:52:10', NULL, 'No'),
(39, 33, 'Tom Markiewicz ', 'tommarkiewicz7+tab@indeedemail.com ', ' +1 403-589-5798', 'assets/applicant/resumes/ResumeTom Markiewicz .pdf', 'assets/user/default-avatar.jpg', '$2y$10$WcCT9Gc3gMxDwg5iiHDh9ub9J6CVPJjqvOtgh02tSChMu7w/H0Rqq', NULL, '2016-06-15 02:52:37', '2016-06-15 02:52:37', NULL, 'No'),
(40, 28, 'Abdi Hafid ', 'hafid44+s6d@indeedemail.com ', ' +1 587-350-9525', 'assets/applicant/resumes/ResumeAbdi Hafid .pdf', 'assets/user/default-avatar.jpg', '$2y$10$r8tOiq3OX1kghlyBtttYlOABVhv/FQna7cShGPP1h9.BRwQndQ55a', NULL, '2016-06-15 02:52:46', '2016-06-15 02:52:46', NULL, 'No'),
(41, 33, 'Brent Cardiff ', 'brentcardiff5+qt2@indeedemail.com ', ' +1 403-554-3767', 'assets/applicant/resumes/ResumeBrent Cardiff .pdf', 'assets/user/default-avatar.jpg', '$2y$10$BztBhIMeWnFWXDml87s9y.pJubcP/2NXq2umP3OH39PG7zt6dg1zq', NULL, '2016-06-15 02:53:04', '2016-06-15 02:53:04', NULL, 'No'),
(42, 29, 'Kezia. Haynes ', 'keziahaynes5+j4i@indeedemail.com ', ' +1 587-990-6219', 'assets/applicant/resumes/ResumeKezia. Haynes .pdf', 'assets/user/default-avatar.jpg', '$2y$10$0W5zeedLQ0cQzm7HN30wr.nP.JVlEoHo3dqxXWu8ktQyA/zGjVSLW', NULL, '2016-06-15 02:53:41', '2016-06-15 02:53:41', NULL, 'No'),
(43, 29, 'Jeremy kierstead ', 'jeremykiersted2+mwf@indeedemail.com ', ' +1 403-651-2001', 'assets/applicant/resumes/ResumeJeremy kierstead .pdf', 'assets/user/default-avatar.jpg', '$2y$10$nQ4B0JjmIHdvCB0VFKfsle3H0BIZ1GuhgnMHObjeLAalibSeRGNVa', NULL, '2016-06-15 02:54:00', '2016-06-15 02:54:00', NULL, 'No'),
(44, 29, 'Veron Gebhardt ', 'verongebhardt9+9yy@indeedemail.com ', ' 587-893-5731', 'assets/applicant/resumes/ResumeVeron Gebhardt .pdf', 'assets/user/default-avatar.jpg', '$2y$10$d6.ndQtooyUhZoJijTl/jOozunMyfTpN7hspSHt/XJr8MqfDVhFlC', NULL, '2016-06-15 02:54:21', '2016-06-15 02:54:21', NULL, 'No'),
(45, 30, 'Milanka Radovanovic ', 'milankaradovanovic4+xg9@indeedemail.com ', ' +1 403-991-4130', 'assets/applicant/resumes/ResumeMilanka Radovanovic .pdf', 'assets/user/default-avatar.jpg', '$2y$10$4NHhlDqLh1w33yB9Hf44zeo3JcN.OgG7PwwTXcvidKFHDgGukEYL.', NULL, '2016-06-15 02:54:41', '2016-06-15 02:54:41', NULL, 'No'),
(46, 30, 'Jacqueline Sabourin ', 'jacquelinesabourin2+3sh@indeedemail.com ', ' +1 403-606-0734', 'assets/applicant/resumes/ResumeJacqueline Sabourin .pdf', 'assets/user/default-avatar.jpg', '$2y$10$/5dwPrxnjyfCR8HqLXI5g.6bjsebXj2MbmUwiKVaNsbkLXgT8EQkO', NULL, '2016-06-15 02:55:20', '2016-06-15 02:55:20', NULL, 'No'),
(47, 30, 'Marium Rumpa ', 'mariumrumpa3+8kh@indeedemail.com ', ' +880 1552-363687', 'assets/applicant/resumes/ResumeMarium Rumpa .pdf', 'assets/user/default-avatar.jpg', '$2y$10$n/n4IP7t8rE9UvvoyVh1xejwpDDZc5YuztZpnoaD1vQ1315h5Jlpu', NULL, '2016-06-15 02:55:40', '2016-06-15 02:55:40', NULL, 'No'),
(48, 30, 'April Good ', 'aprilgood9+suo@indeedemail.com ', ' +1 403-561-6203', 'assets/applicant/resumes/ResumeApril Good .pdf', 'assets/user/default-avatar.jpg', '$2y$10$xrxqbxrSx8Zjnl5Ro2Skye3WHMXh1EUIErPYgEvw3ijT/0VMkiLdG', NULL, '2016-06-15 02:55:59', '2016-06-15 02:55:59', NULL, 'No'),
(49, 30, 'Kayla Cleator ', 'kaylacleator5+3k6@indeedemail.com ', ' +1 587-968-3304', 'assets/applicant/resumes/ResumeKayla Cleator .pdf', 'assets/user/default-avatar.jpg', '$2y$10$vNoi6ytGN7PBqsXz12td7OosX0EPRpeQnbsSHGJr4oyp6esPMJHxy', NULL, '2016-06-15 02:56:19', '2016-06-15 02:56:19', NULL, 'No'),
(50, 30, 'Andrea Robinson ', 'andrearobinson69+xqm@indeedemail.com ', ' 4034025930', 'assets/applicant/resumes/ResumeAndrea Robinson .pdf', 'assets/user/default-avatar.jpg', '$2y$10$5iO.iVnTXlEMplZ0xAwaUuLIAG9Km.QDj/C1OOzm07bI5Vv55nMHm', NULL, '2016-06-15 02:56:38', '2016-06-15 02:56:38', NULL, 'No'),
(51, 30, 'Mackenzie Hames ', 'mackenziehames8+pyg@indeedemail.com ', ' +1 403-688-2076', 'assets/applicant/resumes/ResumeMackenzie Hames .pdf', 'assets/user/default-avatar.jpg', '$2y$10$lP4tyWBEC1y7NIZ1Sx3j0eSXNs9Y/tINckdLWqJ/ha1FPT1gNSm32', NULL, '2016-06-15 02:57:01', '2016-06-15 02:57:01', NULL, 'No'),
(52, 30, 'Travis Fehr ', 'travisfehr8+a76@indeedemail.com ', ' +1 403-475-9452', 'assets/applicant/resumes/ResumeTravis Fehr .pdf', 'assets/user/default-avatar.jpg', '$2y$10$YZ7FeWJaCAwDa.56a67/geFOLu3Byel5A5I.yWJupUzbY.4.gRBza', NULL, '2016-06-15 02:57:21', '2016-06-15 02:57:21', NULL, 'No'),
(53, 30, 'Brittany Anderson ', 'brittanyannderson8+bty@indeedemail.com ', ' +1 403-797-7913', 'assets/applicant/resumes/ResumeBrittany Anderson .pdf', 'assets/user/default-avatar.jpg', '$2y$10$WIOxm8DxL.w.yGuwPDyCr.HWogjdNxq3rm/Q62Wt0WpJL5ErgKnVe', NULL, '2016-06-15 02:57:40', '2016-06-15 02:57:40', NULL, 'No'),
(54, 30, 'Bestman Eleanya ', 'bestmanplutarcheleanya3+ko9@indeedemail.com ', ' +1 519-897-3213', 'assets/applicant/resumes/ResumeBestman Eleanya .pdf', 'assets/user/default-avatar.jpg', '$2y$10$Zcr0tAowS8JXsqkG.v7ZSuguQrcsQO5t3TA9khb5/gsfBoYgS/ZQq', NULL, '2016-06-15 02:57:59', '2016-06-15 02:57:59', NULL, 'No'),
(55, 30, 'Danijel Juricic ', 'danijeljuricic6+pd3@indeedemail.com ', ' +1 587-433-9961', 'assets/applicant/resumes/ResumeDanijel Juricic .pdf', 'assets/user/default-avatar.jpg', '$2y$10$04k3y/HDGPPpNtv2O4OsOO3xW91Z8haFxW0hl1SG.EqZJU5h8eX6y', NULL, '2016-06-15 02:58:19', '2016-06-15 02:58:19', NULL, 'No'),
(56, 30, 'Rina Desimone ', 'rinadesimone6+755@indeedemail.com ', ' +1 403-217-7941', 'assets/applicant/resumes/ResumeRina Desimone .pdf', 'assets/user/default-avatar.jpg', '$2y$10$PtRf24hxcVv6/Ez3KWU4P.q2jBLqvVoFJ0nxwamgFaCCGVaf.obYm', NULL, '2016-06-15 02:58:40', '2016-06-15 02:58:40', NULL, 'No'),
(57, 30, 'Jaedis Smith ', 'jaedissmith9+4t6@indeedemail.com ', ' +1 587-229-1395', 'assets/applicant/resumes/ResumeJaedis Smith .pdf', 'assets/user/default-avatar.jpg', '$2y$10$ULQicELyt.qS9ovV6.bo3uRTr38aHxN9EMI0KZzd6TxuC/.Z9iGuO', NULL, '2016-06-15 02:59:01', '2016-06-15 02:59:01', NULL, 'No'),
(58, 30, 'Nicole Lee Pack ', 'nicoleleepack4+5rv@indeedemail.com ', ' +1 403-629-8209', 'assets/applicant/resumes/ResumeNicole Lee Pack .pdf', 'assets/user/default-avatar.jpg', '$2y$10$PEmpZ.G50Itl8rlyvrG/p.ygcsQ79my8ayRMLBwXvCGibDE8IYJu6', NULL, '2016-06-15 02:59:20', '2016-06-15 02:59:20', NULL, 'No'),
(59, 30, 'Jorge Bermudez ', 'jorgebermudez5+ntg@indeedemail.com ', ' 587.225.5058/204.647.5899', 'assets/applicant/resumes/ResumeJorge Bermudez .pdf', 'assets/user/default-avatar.jpg', '$2y$10$TLkgvCLq2vTGdzlY6jHjpuHnffVpI3bkPOPM/Vb6HtjWahP0DvIBW', NULL, '2016-06-15 02:59:39', '2016-06-15 02:59:39', NULL, 'No'),
(60, 30, 'Dianne Rutledge ', 'diannerutledge7+72z@indeedemail.com ', ' +1 403-479-3503', 'assets/applicant/resumes/ResumeDianne Rutledge .pdf', 'assets/user/default-avatar.jpg', '$2y$10$nWQYxa72Rg8PLw.e1UAfauErIsbH8oRv8XhoLK1OH8OOuOALWqxX.', NULL, '2016-06-15 02:59:58', '2016-06-15 02:59:58', NULL, 'No'),
(61, 30, 'Jagroop Chhina ', 'jagroopchhina4+rxy@indeedemail.com ', ' +1 403-467-3706', 'assets/applicant/resumes/ResumeJagroop Chhina .pdf', 'assets/user/default-avatar.jpg', '$2y$10$MWdHFCVsOYBAZw.6pvMqJOUHykg/nvnQk8KpxjV/8zaJyuEsj4w9u', NULL, '2016-06-15 03:00:17', '2016-06-15 03:00:17', NULL, 'No'),
(62, 30, 'Sonia Brovko ', 'sofiabrovko9+ktu@indeedemail.com ', ' +1 403-547-8103', 'assets/applicant/resumes/ResumeSonia Brovko .pdf', 'assets/user/default-avatar.jpg', '$2y$10$GbY39vo431mV8amWq.8oXuIMjQHuJh7aYXUfZ4tS5eWEoa7/0QTNG', NULL, '2016-06-15 03:00:38', '2016-06-15 03:00:38', NULL, 'No'),
(63, 30, 'Sarah MacPherson ', 'sarahmacpherson34+eq8@indeedemail.com ', ' +1 403-512-7878', 'assets/applicant/resumes/ResumeSarah MacPherson .pdf', 'assets/user/default-avatar.jpg', '$2y$10$Ox3iWpE37cgpwdcqDxf9kuQ0w.Ynr9.fYy36Uxn1HgfP5rhH44i5C', NULL, '2016-06-15 03:00:59', '2016-06-15 03:00:59', NULL, 'No'),
(64, 30, 'Alaina Lorriman ', 'alainalorriman2+w4v@indeedemail.com ', ' 587.896.8683', 'assets/applicant/resumes/ResumeAlaina Lorriman .pdf', 'assets/user/default-avatar.jpg', '$2y$10$bKUdsTzjbhQUZ4CTZMbgr.TiHM81u3.Mf1Rn/WU6YExMa1nBNkjza', NULL, '2016-06-15 03:01:22', '2016-06-15 03:01:22', NULL, 'No'),
(65, 30, 'Suzanne Leslie ', 'suzanneleslie2+42e@indeedemail.com ', ' +1 403-952-8167', 'assets/applicant/resumes/ResumeSuzanne Leslie .pdf', 'assets/user/default-avatar.jpg', '$2y$10$4jC9agANeqwWUlMT4rEtl.4t9LMhoUgWHJcupAALe7rbA4m1zMA9y', NULL, '2016-06-15 03:01:41', '2016-06-15 03:01:41', NULL, 'No'),
(66, 30, 'Gabriela R. Hernandez ', 'gabrielahernandez43+jqc@indeedemail.com ', ' +1 403-256-9796', 'assets/applicant/resumes/ResumeGabriela R. Hernandez .pdf', 'assets/user/default-avatar.jpg', '$2y$10$sfvj/PqsGeeOHLoSJxNVe.U6gUIvT08GpY50.X3NDcWnDi6j/9Ayu', NULL, '2016-06-15 03:02:03', '2016-06-15 03:02:03', NULL, 'No'),
(67, 30, 'Edwin Fominyam ', 'edwinfominyam5+erp@indeedemail.com ', ' +1 403-617-9398', 'assets/applicant/resumes/ResumeEdwin Fominyam .pdf', 'assets/user/default-avatar.jpg', '$2y$10$KpMqp/7j7yQPcQhxzeez1OTJRThtPAs25x4hTFkllNSQkHuwTwZze', NULL, '2016-06-15 03:02:24', '2016-06-15 03:02:24', NULL, 'No'),
(68, 30, 'Hailey Coles ', 'haileycoleshotmailcacoles8+hv8@indeedemail.com ', ' +1 587-968-4097', 'assets/applicant/resumes/ResumeHailey Coles .pdf', 'assets/user/default-avatar.jpg', '$2y$10$uqkr/FC/FfbsygKcuJHzBus4LTQdOquwbM2Tp6NJ1WGStkAHRimIa', NULL, '2016-06-15 03:02:46', '2016-06-15 03:02:46', NULL, 'No'),
(69, 30, 'Ahmed alhuwaymil ', 'ahmedalhuwaymil7+dxx@indeedemail.com ', ' +1 587-707-4324', 'assets/applicant/resumes/ResumeAhmed alhuwaymil .pdf', 'assets/user/default-avatar.jpg', '$2y$10$5.Ye/V8Ez0201BxTvqFlWuKOUQ6pbvSpcz4h1/fEXHRtcBU.bU3ry', NULL, '2016-06-15 03:03:11', '2016-06-15 03:03:11', NULL, 'No'),
(70, 30, 'Reymundo Adriano ', 'reymundoadrianoii9+rzs@indeedemail.com ', ' +1 403-400-6204', 'assets/applicant/resumes/ResumeReymundo Adriano .pdf', 'assets/user/default-avatar.jpg', '$2y$10$k48hbviLMtFPW5x4nbk26.SPv1.5dx1OHHClpF7cNGueypi83B/y6', NULL, '2016-06-15 03:03:31', '2016-06-15 03:03:31', NULL, 'No'),
(71, 30, 'Sandra Campbell ', 'sandracampbell82+dr5@indeedemail.com ', ' +1 403-259-6250', 'assets/applicant/resumes/ResumeSandra Campbell .pdf', 'assets/user/default-avatar.jpg', '$2y$10$ToXVSDOCWZZRfSfa/S4uHeCm/Tt/J//epnAWmOHcAFqdTKli1G6Fu', NULL, '2016-06-15 03:03:51', '2016-06-15 03:03:51', NULL, 'No'),
(72, 30, 'Lori Folkerson ', 'lorifolkerson2+7kq@indeedemail.com ', ' +1 905-699-6141', 'assets/applicant/resumes/ResumeLori Folkerson .pdf', 'assets/user/default-avatar.jpg', '$2y$10$L2dYqUrwJDBFLk52WmomfuHHJEZC050TfCpPT5CwHT2.g.RMq4Bka', NULL, '2016-06-15 03:04:47', '2016-06-15 03:04:47', NULL, 'No'),
(73, 30, 'Jacqueline Sambu ', 'jackiesambu2+8sd@indeedemail.com ', ' +1 403-613-1667', 'assets/applicant/resumes/ResumeJacqueline Sambu .pdf', 'assets/user/default-avatar.jpg', '$2y$10$rHegbKbMsmpl4016uhIU2uhqjgtNRV/c17JHWlk3VOCCUxyfWkoxi', NULL, '2016-06-15 03:05:09', '2016-06-15 03:05:09', NULL, 'No'),
(74, 30, 'Caity Bell ', 'caitlinbell74+9e3@indeedemail.com ', ' +1 403-852-1274', 'assets/applicant/resumes/ResumeCaity Bell .pdf', 'assets/user/default-avatar.jpg', '$2y$10$Q9hviZRKeQnTkHK0Vkyzc.Vzza8bnOT7r9mHiSmFpY6p4EZmMddbq', NULL, '2016-06-15 03:05:29', '2016-06-15 03:05:29', NULL, 'No'),
(75, 30, 'John Kuryk ', 'johnkuryk4+hd8@indeedemail.com ', ' +1 403-993-5322', 'assets/applicant/resumes/ResumeJohn Kuryk .pdf', 'assets/user/default-avatar.jpg', '$2y$10$ZgwNzyd0yrguGY/NZJeRhuV.oZRIep5E0vbIoCVAG2Nueom4vonR.', NULL, '2016-06-15 03:05:48', '2016-06-15 03:05:48', NULL, 'No'),
(76, 30, 'Nnamdi C Okoye ', 'nnamdiokoye3+pzb@indeedemail.com ', ' +1 403-404-2443', 'assets/applicant/resumes/ResumeNnamdi C Okoye .pdf', 'assets/user/default-avatar.jpg', '$2y$10$49UN6nKBM2EAWfqqLHgOcO2486T5odg37I7MMyrGoWsdcoRBzkzQ.', NULL, '2016-06-15 03:06:10', '2016-06-15 03:06:10', NULL, 'No'),
(77, 30, 'adriana soto ', 'adrianasoto83+fni@indeedemail.com ', ' 4034372155  or 587 9696995', 'assets/applicant/resumes/Resumeadriana soto .pdf', 'assets/user/default-avatar.jpg', '$2y$10$mXhkgnfaRyGJhtUpFOPCk.Jo94kNta118XSxudH/WraE90ecacjfa', NULL, '2016-06-15 03:06:30', '2016-06-15 03:06:30', NULL, 'No'),
(78, 30, 'Patrick Elliott ', 'patrickelliott9+f5a@indeedemail.com ', ' +1 403-620-5076', 'assets/applicant/resumes/ResumePatrick Elliott .pdf', 'assets/user/default-avatar.jpg', '$2y$10$ADBZlAzRRoflMrd9D4/91ONt8w8jrMcrQgtfNbv/OWZ80Z0pMoCz2', NULL, '2016-06-15 03:06:49', '2016-06-15 03:06:49', NULL, 'No'),
(79, 30, 'Habib Faizulaev ', 'habib7+dz4@indeedemail.com ', ' +1 403-615-6462', 'assets/applicant/resumes/ResumeHabib Faizulaev .pdf', 'assets/user/default-avatar.jpg', '$2y$10$z6RnP1o96YzHIAToT/CRAOrtDL5e8BoiMc.UT4rNtTbrgwliEmXEK', NULL, '2016-06-15 03:07:09', '2016-06-15 03:07:09', NULL, 'No'),
(80, 30, 'Simone Fisher ', 'simonefisher8+5wf@indeedemail.com ', ' +1 587-998-4061', 'assets/applicant/resumes/ResumeSimone Fisher .pdf', 'assets/user/default-avatar.jpg', '$2y$10$dZ9qMy3eGMtvrspNVpboLug0o3YctPKs34CwZeuMPH.QvVJMxlY0a', NULL, '2016-06-15 03:07:32', '2016-06-15 03:07:32', NULL, 'No'),
(81, 30, 'bruno perrier ', 'perrier79+fy4@indeedemail.com ', ' +1 403-651-3896', 'assets/applicant/resumes/Resumebruno perrier .pdf', 'assets/user/default-avatar.jpg', '$2y$10$5I4DUtP9D.vhskPwl9Xm1.a2RkNcbYoMRSkXqZr4BvrY0Nvodcd2a', NULL, '2016-06-15 03:07:51', '2016-06-15 03:07:51', NULL, 'No'),
(82, 30, 'Luis Zavala ', 'luiszavala34+2ij@indeedemail.com ', ' +1 403-909-3622', 'assets/applicant/resumes/ResumeLuis Zavala .pdf', 'assets/user/default-avatar.jpg', '$2y$10$AMJMbLgDpeq7SmzQLdEZy.zmv8FeuOCZXkaH84VDIo2Bq38oUJBqe', NULL, '2016-06-15 03:08:10', '2016-06-15 03:08:10', NULL, 'No'),
(83, 30, 'Mandeep Gosal ', 'mandeepgosal4+wfw@indeedemail.com ', ' +1 780-318-3430', 'assets/applicant/resumes/ResumeMandeep Gosal .pdf', 'assets/user/default-avatar.jpg', '$2y$10$nrOBEmIgCtzdh/8wUofYpeTQH3fxEArMcKrg4q2yrxbjRVedRO0nC', NULL, '2016-06-15 03:08:31', '2016-06-15 03:08:31', NULL, 'No'),
(84, 30, 'Aimee-Marie Hennessey ', 'aimeemariehennessey5+esf@indeedemail.com ', ' +1 403-870-3171', 'assets/applicant/resumes/ResumeAimee-Marie Hennessey .pdf', 'assets/user/default-avatar.jpg', '$2y$10$/rlzQGP4KxtfXQC7LKf77.I.3JVuLF7WzkJiwMS8GdHnU7qoR4eG6', NULL, '2016-06-15 03:08:51', '2016-06-15 03:08:51', NULL, 'No'),
(85, 30, 'Jordon Langevin ', 'jordonlangevin8+tj9@indeedemail.com ', ' +1 587-433-1475', 'assets/applicant/resumes/ResumeJordon Langevin .pdf', 'assets/user/default-avatar.jpg', '$2y$10$4qumsuOS0pMAjlF4FATh4eIa1aI7tTx07BgJ8jQsS/n6Hc0O8YXay', NULL, '2016-06-15 03:09:14', '2016-06-15 03:09:14', NULL, 'No'),
(86, 30, 'Jacquiline Whiteway ', 'jacquilinewhiteway2+6g2@indeedemail.com ', ' +1 403-585-9158', 'assets/applicant/resumes/ResumeJacquiline Whiteway .pdf', 'assets/user/default-avatar.jpg', '$2y$10$OBJt3ZQtqVQoWxZE9pw2E.B2vbh28ZDDldhTmaQlcXnfNc0b//3L.', NULL, '2016-06-15 03:09:35', '2016-06-15 03:09:35', NULL, 'No'),
(87, 30, 'Forbes Goredema ', 'forbesgoredema2+88s@indeedemail.com ', ' +1 403-402-5987', 'assets/applicant/resumes/ResumeForbes Goredema .pdf', 'assets/user/default-avatar.jpg', '$2y$10$AY.IiajOK7VvLz4tvFMc5OP6IrMZVJXoV5HozrVYdg5YS.DloBSRW', NULL, '2016-06-15 03:10:04', '2016-06-15 03:10:04', NULL, 'No'),
(88, 30, 'Kiara Mcquaker ', 'kiaramcquaker9+nri@indeedemail.com ', ' +1 403-828-6808', 'assets/applicant/resumes/ResumeKiara Mcquaker .pdf', 'assets/user/default-avatar.jpg', '$2y$10$/kUx3bamk0PlEq5.QaAFe.qvSjnRTmg4rNQfIC2tZgnOfDy8XXCou', NULL, '2016-06-15 03:10:23', '2016-06-15 03:10:23', NULL, 'No'),
(89, 30, 'Maria Cadiente ', 'mariacadiente2+6y4@indeedemail.com ', ' +1 403-714-2896', 'assets/applicant/resumes/ResumeMaria Cadiente .pdf', 'assets/user/default-avatar.jpg', '$2y$10$4WLiSLusbVoaYkinrcI1peg0mO3mu.BIsDffNKN1LCUxwLNbxukF.', NULL, '2016-06-15 03:10:43', '2016-06-15 03:10:43', NULL, 'No'),
(90, 30, 'Ronald Rey ', 'ronaldreydcnocon5+v37@indeedemail.com ', ' +1 403-200-7623', 'assets/applicant/resumes/ResumeRonald Rey .pdf', 'assets/user/default-avatar.jpg', '$2y$10$.X3t9CSQYuv5u8UXG/1uvO95fjXDgfn78Di1ucq8gPJsnOZZtQg3O', NULL, '2016-06-15 03:11:03', '2016-06-15 03:11:03', NULL, 'No'),
(91, 30, 'Twila D. Genoway ', 'twiladgenoway6+kj3@indeedemail.com ', ' +1 403-397-2035', 'assets/applicant/resumes/ResumeTwila D. Genoway .pdf', 'assets/user/default-avatar.jpg', '$2y$10$CrbN4nK2totqEwHEp9PtO.mhLMZkI1WSBoutT.HxyVD7i/X9o6U9m', NULL, '2016-06-15 03:11:30', '2016-06-15 03:11:30', NULL, 'No'),
(92, 30, 'Michele Wienecke ', 'michelewienecke4+qot@indeedemail.com ', ' +1 519-301-0931', 'assets/applicant/resumes/ResumeMichele Wienecke .pdf', 'assets/user/default-avatar.jpg', '$2y$10$jRcfTzj/TXyJsjvreUdaw.0c60MT.1m.HB4QVYi2cixvpH9Cnc3fO', NULL, '2016-06-15 03:11:52', '2016-06-15 03:11:52', NULL, 'No'),
(93, 30, 'Darey Riches IGBINOSA ', 'dareyrichesigbinosa2+f9j@indeedemail.com ', ' +1 403-402-2135', 'assets/applicant/resumes/ResumeDarey Riches IGBINOSA .pdf', 'assets/user/default-avatar.jpg', '$2y$10$IOsg9DmSjDB8bDoYm83WxeJHWR0pxLF869xEmZ3jCf4sofjC/WoYu', NULL, '2016-06-15 03:12:13', '2016-06-15 03:12:13', NULL, 'No'),
(94, 30, 'Silvana furtado ', 'silvanafurtado3+dfw@indeedemail.com ', ' +1 587-579-9560', 'assets/applicant/resumes/ResumeSilvana furtado .pdf', 'assets/user/default-avatar.jpg', '$2y$10$PwKXljOwPJ1SmDpx8jRkb.pYxFF67HLM0FwkyHdgBwOxNvpvkS7bO', NULL, '2016-06-15 03:12:37', '2016-06-15 03:12:37', NULL, 'No'),
(95, 30, 'Sierrah Coates ', 'sierrah9+pfp@indeedemail.com ', ' +1 519-991-5048', 'assets/applicant/resumes/ResumeSierrah Coates .pdf', 'assets/user/default-avatar.jpg', '$2y$10$3ThatWXBtEEAasJdhptfp.jM5nwINZxNokftNJN9.Cjes2fieHyuW', NULL, '2016-06-15 03:12:59', '2016-06-15 03:12:59', NULL, 'No'),
(96, 30, 'Cheryl Brown ', 'cherylbrown33+pov@indeedemail.com ', ' 403-460-0092', 'assets/applicant/resumes/ResumeCheryl Brown .pdf', 'assets/user/default-avatar.jpg', '$2y$10$t5H4Wk0Ys71ikoV.6iyRuORLO8jhstblZqvPm49WK.GYmjV5zeF.W', NULL, '2016-06-15 03:13:20', '2016-06-15 03:13:20', NULL, 'No'),
(97, 30, 'Felipe Aguilar ', 'felipealvarado3+dwr@indeedemail.com ', ' +1 306-480-9560', 'assets/applicant/resumes/ResumeFelipe Aguilar .pdf', 'assets/user/default-avatar.jpg', '$2y$10$EmbPaPnZC64T7NOEAmjhxOf78WIHawckKit70joT6yx3D6ZNanu.G', NULL, '2016-06-15 03:13:41', '2016-06-15 03:13:41', NULL, 'No'),
(98, 30, 'Laura Macculloch ', 'lauramacculloch5+wsr@indeedemail.com ', ' +1 403-275-3245', 'assets/applicant/resumes/ResumeLaura Macculloch .pdf', 'assets/user/default-avatar.jpg', '$2y$10$CfEYV5RGsCi1oNDzW9Lzz.vvUmkCFW6/Jp5oWPWlzOepecWow2xRS', NULL, '2016-06-15 03:14:03', '2016-06-15 03:14:03', NULL, 'No'),
(99, 30, 'Patrick Land ', 'patrickland2+6yd@indeedemail.com ', ' +1 403-919-9343', 'assets/applicant/resumes/ResumePatrick Land .pdf', 'assets/user/default-avatar.jpg', '$2y$10$HMhw6tOxXjltVWO.t9a2oOCrkcGZVcqBfj1dZgT6CRDfwV9luq06K', NULL, '2016-06-15 03:14:24', '2016-06-15 03:14:24', NULL, 'No'),
(100, 30, 'Eveline Gaudet ', 'kerryminer2+chi@indeedemail.com ', ' +1 403-243-4714', 'assets/applicant/resumes/ResumeEveline Gaudet .pdf', 'assets/user/default-avatar.jpg', '$2y$10$aueNDXYYbOd7oM2.Ps8vYOoNdOWm1JYmhOSW8E0JX3.Buk1omJWvO', NULL, '2016-06-15 03:14:44', '2016-06-15 03:14:44', NULL, 'No'),
(101, 30, 'Tatiana Todica ', 'tatianatodica2+nha@indeedemail.com ', ' +1 587-577-8797', 'assets/applicant/resumes/ResumeTatiana Todica .pdf', 'assets/user/default-avatar.jpg', '$2y$10$s6wHp2SuAsQ27WQm73y9nOfH/3HJT6TdXNMITn0MHkNRKsOq7tVoC', NULL, '2016-06-15 03:15:03', '2016-06-15 03:15:03', NULL, 'No'),
(102, 30, 'yogan jeremy ponnampalam ', 'jeremyponnampalam8+ae3@indeedemail.com ', ' +1 403-305-3900', 'assets/applicant/resumes/Resumeyogan jeremy ponnampalam .pdf', 'assets/user/default-avatar.jpg', '$2y$10$C09PxOg/gfrst9/qN7QxfOmWsUcbu8cnk8n.SlFyrokXHU4u4smvi', NULL, '2016-06-15 03:15:22', '2016-06-15 03:15:22', NULL, 'No'),
(103, 30, 'Tracy Becker ', 'tracybecker35+vua@indeedemail.com ', ' +1 403-850-2524', 'assets/applicant/resumes/ResumeTracy Becker .pdf', 'assets/user/default-avatar.jpg', '$2y$10$iCOCalhtV2XgZ6B8apuaLulmCz0HmW7778Id.oqdaVjfApM.4mctC', NULL, '2016-06-15 03:15:41', '2016-06-15 03:15:41', NULL, 'No'),
(104, 30, 'MICHELLE JAMES ', 'michellejames43+mcb@indeedemail.com ', ' +1 403-828-5162', 'assets/applicant/resumes/ResumeMICHELLE JAMES .pdf', 'assets/user/default-avatar.jpg', '$2y$10$gMxHpo5vqqprWWPmszq.MeZs/OMqRZoY8tZM.wugRlXWakOWwKqge', NULL, '2016-06-15 03:16:00', '2016-06-15 03:16:00', NULL, 'No'),
(105, 30, 'Deborah Sedinger ', 'deborahsedinger6+d6h@indeedemail.com ', ' 587-436-8666', 'assets/applicant/resumes/ResumeDeborah Sedinger .pdf', 'assets/user/default-avatar.jpg', '$2y$10$.U09PLozbLdcIF/ISnWVFOTPwcn.X0gVcRBf1LmKyfUQLhLuJnnN.', NULL, '2016-06-15 03:16:19', '2016-06-15 03:16:19', NULL, 'No'),
(106, 30, 'Natasha Jennings ', 'natashajennings6+9x9@indeedemail.com ', ' 403-828-8147', 'assets/applicant/resumes/ResumeNatasha Jennings .pdf', 'assets/user/default-avatar.jpg', '$2y$10$uK2UjzJYY0Tz3PV8hT82q.we/e0th/DUPtS8npfrKK/mV5wgY5IUO', NULL, '2016-06-15 03:16:41', '2016-06-15 03:16:41', NULL, 'No'),
(107, 30, 'Kevin Lodoen ', 'kevinlodoen2+swd@indeedemail.com ', ' +1 587-224-1474', 'assets/applicant/resumes/ResumeKevin Lodoen .pdf', 'assets/user/default-avatar.jpg', '$2y$10$zNjukFTCLMqVuzMm.JhzPOZbDRBgI9SAvHLFK3/XFrrf94ZGSJn0W', NULL, '2016-06-15 03:17:01', '2016-06-15 03:17:01', NULL, 'No'),
(108, 30, 'Jenna Ogonoski ', 'jennaogonoski2+svu@indeedemail.com ', ' +1 587-581-0503', 'assets/applicant/resumes/ResumeJenna Ogonoski .pdf', 'assets/user/default-avatar.jpg', '$2y$10$9b4m6IIUmcpStX2Ss81mSOs5Y9.Ze0Hgk48k1FBR2VI9IdxFvGfvi', NULL, '2016-06-15 03:17:20', '2016-06-15 03:17:20', NULL, 'No'),
(109, 30, 'LaRae Krebs ', 'laraekrebs8+r22@indeedemail.com ', ' +1 403-830-2340', 'assets/applicant/resumes/ResumeLaRae Krebs .pdf', 'assets/user/default-avatar.jpg', '$2y$10$PILkVeNBGPw.MYuu2R1LAufHzW/odKAbi5GrvHaJFf4A0xqfeUidW', NULL, '2016-06-15 03:17:40', '2016-06-15 03:17:40', NULL, 'No'),
(110, 30, 'Anamaria Pinilla ', 'anamariapinilla4+o6e@indeedemail.com ', ' +1 403-397-3803', 'assets/applicant/resumes/ResumeAnamaria Pinilla .pdf', 'assets/user/default-avatar.jpg', '$2y$10$QGan/v/VeOGLKAex1xYOaOkboeO/LFn0pWOdPc.cE8SqlBkv9LlFu', NULL, '2016-06-15 03:50:20', '2016-06-15 03:50:20', NULL, 'No'),
(164, 30, 'Alexis Crowley ', 'alexiscrowley6+zoi@indeedemail.com ', ' +1 403-862-7988', 'assets/applicant/resumes/ResumeAlexis Crowley .pdf', 'assets/user/default-avatar.jpg', '$2y$10$14SjOJ/EO.CxK4yvtnl97ONJc0oZHQekMxiptjR3pe3Cbnt.V0BEa', NULL, '2016-06-15 04:19:46', '2016-06-15 04:19:46', NULL, 'No'),
(166, 30, 'Ronald Rey DC Nocon ', 'ronaldreydcnocon5+j5c@indeedemail.com ', ' +1 403-200-7623', 'assets/applicant/resumes/ResumeRonald Rey DC Nocon .pdf', 'assets/user/default-avatar.jpg', '$2y$10$SWtrckSo4BRPO5Sy6SBcSuiYD8a92wLpS9Xjoupl3NH7BWTmSiRMy', NULL, '2016-06-15 04:20:08', '2016-06-15 04:20:08', NULL, 'No'),
(168, 30, 'Michael Biteng ', 'michaelbiteng9+p45@indeedemail.com ', ' +1 403-399-0722', 'assets/applicant/resumes/ResumeMichael Biteng .pdf', 'assets/user/default-avatar.jpg', '$2y$10$LpAuMMyzorDn0a7DAn8s6.efOfxmh6KUDMiBGc4eE4x/VweHFwkke', NULL, '2016-06-15 04:20:31', '2016-06-15 04:20:31', NULL, 'No'),
(170, 30, 'Jeff Slack ', 'jeffslack8+ptu@indeedemail.com ', ' +1 403-589-3291', 'assets/applicant/resumes/ResumeJeff Slack .pdf', 'assets/user/default-avatar.jpg', '$2y$10$n1umyi6JEB0OYoz1EYVOG.pFG0gXjqlnSzKl5aUygy/l0Vy363Xuu', NULL, '2016-06-15 04:20:54', '2016-06-15 04:20:54', NULL, 'No'),
(172, 30, 'Joel wico ', 'joelwico6+niy@indeedemail.com ', ' +1 403-608-3661', 'assets/applicant/resumes/ResumeJoel wico .pdf', 'assets/user/default-avatar.jpg', '$2y$10$v1xZo5bbs4HuOe4znZcHYedR9t6CBXF4E.nT/K/vFhfJ3/G8DZU4K', NULL, '2016-06-15 04:21:26', '2016-06-15 04:21:26', NULL, 'No'),
(173, 32, 'Osayomwanbor Ogbebor ', 'osayomwanborogbebor7+wiq@indeedemail.com ', ' +1 403-402-2886', 'assets/applicant/resumes/ResumeOsayomwanbor Ogbebor .pdf', 'assets/user/default-avatar.jpg', '$2y$10$3wC0ya0pYMgMTkKLoT5DCe8sZWrr7Q6Ntqh/ogsu787QnThg7U59.', NULL, '2016-06-15 04:21:37', '2016-06-15 04:21:37', NULL, 'No'),
(175, 32, 'Silas Li ', 'silasli7+vxc@indeedemail.com ', ' 4039660148', 'assets/applicant/resumes/ResumeSilas Li .pdf', 'assets/user/default-avatar.jpg', '$2y$10$vMYpjWyxLIwt/T3zAWfVhO/bPYqBQ04/pxELfVMI0daonfthGMOi6', NULL, '2016-06-15 04:22:03', '2016-06-15 04:22:03', NULL, 'No'),
(177, 32, 'Jean-Jacques Tapsoba ', 'tapsoba6+aqb@indeedemail.com ', ' (514) 561 3784', 'assets/applicant/resumes/ResumeJean-Jacques Tapsoba .pdf', 'assets/user/default-avatar.jpg', '$2y$10$iPSNCquP.z0q6sN1HAuYz.0KOCtZS/jUsVRWon1cXHIi5rDqHzaEK', NULL, '2016-06-15 04:22:26', '2016-06-15 04:22:26', NULL, 'No'),
(179, 32, 'Tanner Cassidy ', 'tannercassidy3+stv@indeedemail.com ', ' +1 403-612-7338', 'assets/applicant/resumes/ResumeTanner Cassidy .pdf', 'assets/user/default-avatar.jpg', '$2y$10$/fw2YqOeMB6jn16/4.Lc0ey8RUb9TH5J9a3FonmhfeRIOrKqwtU3.', NULL, '2016-06-15 04:22:47', '2016-06-15 04:22:47', NULL, 'No'),
(181, 32, 'Shailesh Dholakia, P.Eng.,GSI ', 'shaileshdholakiapenggsi2+dwu@indeedemail.com ', ' +1 403-891-5040', 'assets/applicant/resumes/ResumeShailesh Dholakia, P.Eng.,GSI .pdf', 'assets/user/default-avatar.jpg', '$2y$10$vevEqFaK9MuEMaR/sVopRupiUI9nwoH49TuukIc4UVMcAzHycVf1W', NULL, '2016-06-15 04:23:09', '2016-06-15 04:23:09', NULL, 'No'),
(183, 32, 'Shabeela Majeed ', 'shabeelamajeedkhan6+hfr@indeedemail.com ', ' +1 587-438-7816', 'assets/applicant/resumes/ResumeShabeela Majeed .pdf', 'assets/user/default-avatar.jpg', '$2y$10$Eeg3jXscmiDuoD19HeQinOqrEhxTBbiEtYVVf7LVdvWMUnUfR/u.i', NULL, '2016-06-15 04:23:42', '2016-06-15 04:23:42', NULL, 'No'),
(185, 32, 'Melver Tan ', 'melvertan4+rjm@indeedemail.com ', ' +1 514-578-0166', 'assets/applicant/resumes/ResumeMelver Tan .pdf', 'assets/user/default-avatar.jpg', '$2y$10$sHVJqsQgQPcTLkMAo7pNEesPw9JxiJcODAQ7MBNvliJOtG02VKTgO', NULL, '2016-06-15 04:24:02', '2016-06-15 04:24:02', NULL, 'No'),
(187, 32, 'Olivier ', 'uwamahoroolivier9+56t@indeedemail.com ', ' +1 780-668-2572', 'assets/applicant/resumes/ResumeOlivier .pdf', 'assets/user/default-avatar.jpg', '$2y$10$q47YmyBLrNUvs9Dd4J7oAulHO1luRLHWFPbytdZpYwFSqXd57daMi', NULL, '2016-06-15 04:25:43', '2016-06-15 04:25:43', NULL, 'No'),
(189, 32, 'Maricar Nuňez ', 'maricarsnunez7+wz9@indeedemail.com ', ' +1 403-968-0111', 'assets/applicant/resumes/ResumeMaricar Nuňez .pdf', 'assets/user/default-avatar.jpg', '$2y$10$eSSy7rtFb67Dw7YnZvRVpeIfvcx6gdNpX6w.TlK.cQxJzggFU2zDe', NULL, '2016-06-15 04:26:07', '2016-06-15 04:26:07', NULL, 'No'),
(191, 32, 'Jerome Desroches ', 'jeromedesroches6+api@indeedemail.com ', ' 403 619-6666', 'assets/applicant/resumes/ResumeJerome Desroches .pdf', 'assets/user/default-avatar.jpg', '$2y$10$8vNl71EHQ.iXeJ/Bw/pgZOmHL3bmVvhlICT0RBuVieeQJ9f8FGVwy', NULL, '2016-06-15 04:26:36', '2016-06-15 04:26:36', NULL, 'No'),
(193, 32, 'Robert Chang ', 'robertshichang4+o2i@indeedemail.com ', ' +1 780-966-9609', 'assets/applicant/resumes/ResumeRobert Chang .pdf', 'assets/user/default-avatar.jpg', '$2y$10$rnalFM9bGblCi5MvV/zl/OMlzl3CNHNbh2JL9zUt4o9UsT4w27c/a', NULL, '2016-06-15 04:26:56', '2016-06-15 04:26:56', NULL, 'No'),
(195, 32, 'Bassem Abdrabou ', 'bassemabdrabou2+5cd@indeedemail.com ', ' +1 403-401-6986', 'assets/applicant/resumes/ResumeBassem Abdrabou .pdf', 'assets/user/default-avatar.jpg', '$2y$10$kxRiv4S6atPrFsXPwxWh8.YSrdlnth/Y0/cldDppK2iQ5tBuVPAWe', NULL, '2016-06-15 04:27:16', '2016-06-15 04:27:16', NULL, 'No'),
(197, 32, 'Anthony Culloo ', 'anthonyculloo3+3cd@indeedemail.com ', ' +1 647-986-6706', 'assets/applicant/resumes/ResumeAnthony Culloo .pdf', 'assets/user/default-avatar.jpg', '$2y$10$dPNHxpM12V1QtTk4yek9Y.hjHZ8omcQMVt1w9y7W2Ag5uKABQX1vS', NULL, '2016-06-15 04:27:35', '2016-06-15 04:27:35', NULL, 'No'),
(199, 32, 'Jeff Meidl ', 'jeffmeidl7+aqr@indeedemail.com ', ' +1 403-604-7633', 'assets/applicant/resumes/ResumeJeff Meidl .pdf', 'assets/user/default-avatar.jpg', '$2y$10$1yacEWXoq1y5iIDOhzbDeuKsa0raFvQ7dRXtdFzZwiIagmb3KjVPy', NULL, '2016-06-15 04:27:54', '2016-06-15 04:27:54', NULL, 'No'),
(201, 32, 'James Oborne ', 'jamesoborne9+7rb@indeedemail.com ', ' +1 250-361-6183', 'assets/applicant/resumes/ResumeJames Oborne .pdf', 'assets/user/default-avatar.jpg', '$2y$10$7x.lTchBWFSMgdEVoL8Pzuj9qbe6dzoaB4taIM7R4.9XYlJgYDGJW', NULL, '2016-06-15 04:28:13', '2016-06-15 04:28:13', NULL, 'No'),
(203, 32, 'Ali Hosseini ', 'seyedalihosseini8+wxx@indeedemail.com ', ' +1 780-802-8939', 'assets/applicant/resumes/ResumeAli Hosseini .pdf', 'assets/user/default-avatar.jpg', '$2y$10$oHnwOSkZyGyzG9oGKeugDeqsrmVKsKLvoF6m.ZjHyA.HEMa9l3lYK', NULL, '2016-06-15 04:28:31', '2016-06-15 04:28:31', NULL, 'No'),
(213, 28, 'Brent Cardiff ', 'brentcardiff5+p9v@indeedemail.com ', ' +1 403-554-3767', 'assets/applicant/resumes/ResumeBrent Cardiff .pdf', 'assets/user/default-avatar.jpg', '$2y$10$Dh3.Lt8NrnEkMfCOtmdCm.2fcEuknntzzw9vVb8vJ3wln3KUPnmCi', NULL, '2016-06-15 04:51:16', '2016-06-15 04:51:16', NULL, 'No'),
(223, 30, 'Sheena Hann ', 'sheenahann2+6cx@indeedemail.com ', ' +1 587-586-6572', 'assets/applicant/resumes/ResumeSheena Hann .pdf', 'assets/user/default-avatar.jpg', '$2y$10$Bp/wHfvLQw9yfoE5KMAytO535AWQlRl0kud7rYhPp5u9s3nQ/0SWa', NULL, '2016-06-15 04:52:50', '2016-06-15 04:52:50', NULL, 'No'),
(224, 31, 'Colby Sweet ', 'colbysweet9+dbb@indeedemail.com ', ' +1 403-999-1283', 'assets/applicant/resumes/ResumeColby Sweet .pdf', 'assets/user/default-avatar.jpg', '$2y$10$rshQCO9SNORjS6VjE5pWz.mxHnEd90MAGy/OaoY/Ywk7PIiSrLoPq', NULL, '2016-06-16 00:27:35', '2016-06-16 00:27:35', NULL, 'No'),
(226, 31, 'Matthew Thomas ', 'matthewthomas726+quc@indeedemail.com ', ' +1 403-700-5909', 'assets/applicant/resumes/ResumeMatthew Thomas .pdf', 'assets/user/default-avatar.jpg', '$2y$10$DNndJ0i.j6PdujEdblLxXOxgLnjzysGg0/AlteewHTU7F7PCrQiU2', NULL, '2016-06-16 00:27:57', '2016-06-16 00:27:57', NULL, 'No'),
(228, 28, 'Shawn Gilhen ', 'shawngilhen5+vo9@indeedemail.com ', ' +1 403-305-2618', 'assets/applicant/resumes/ResumeShawn Gilhen .pdf', 'assets/user/default-avatar.jpg', '$2y$10$fF6qMA3zuFPHb0DLpokN6uxsRw34CH.gRFNzY.1SFDcgcUrZJzrR.', NULL, '2016-06-16 00:28:21', '2016-06-16 00:28:21', NULL, 'No'),
(230, 31, 'Victoria Chukwuanu ', 'victoriachukwuanu8+far@indeedemail.com ', ' +1 780-940-6472', 'assets/applicant/resumes/ResumeVictoria Chukwuanu .pdf', 'assets/user/default-avatar.jpg', '$2y$10$nqtGqdn34U06OZAJeTLB3Ovj38bGtl7awzrSGdr6O3h6iY2DYO6Za', NULL, '2016-06-16 00:28:43', '2016-06-16 00:28:43', NULL, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `fp_applicant_ratings`
--

CREATE TABLE IF NOT EXISTS `fp_applicant_ratings` (
`id` int(10) unsigned NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_applicant_tags`
--

CREATE TABLE IF NOT EXISTS `fp_applicant_tags` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `tags` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_applicant_tags`
--

INSERT INTO `fp_applicant_tags` (`id`, `user_id`, `applicant_id`, `job_id`, `tags`, `created_at`, `updated_at`) VALUES
(1, 18, 4, 10, 'test,tester,testing', '2016-05-23 21:36:56', '2016-05-23 21:58:52'),
(2, 18, 5, 10, 'testing', '2016-05-23 22:10:10', '2016-05-23 22:10:10'),
(3, 18, 9, 10, 'test,test2,test3,test4,test5', '2016-05-23 22:48:21', '2016-06-07 06:59:09'),
(4, 18, 8, 10, 'testing,tester', '2016-05-23 23:39:34', '2016-05-24 02:55:07'),
(5, 18, 7, 10, 'tester', '2016-05-23 23:39:38', '2016-05-23 23:40:58'),
(6, 18, 228, 28, 'test', '2016-06-17 01:57:35', '2016-06-17 01:57:35');

-- --------------------------------------------------------

--
-- Table structure for table `fp_assigned_roles`
--

CREATE TABLE IF NOT EXISTS `fp_assigned_roles` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_assigned_user`
--

CREATE TABLE IF NOT EXISTS `fp_assigned_user` (
`id` int(11) NOT NULL,
  `belongs_to` varchar(100) CHARACTER SET latin1 NOT NULL,
  `unique_id` int(11) NOT NULL,
  `username` text CHARACTER SET latin1 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_assigned_user`
--

INSERT INTO `fp_assigned_user` (`id`, `belongs_to`, `unique_id`, `username`, `created_at`, `updated_at`) VALUES
(3, 'bug', 1, 'ab', '2016-03-15 06:12:59', '2016-03-15 06:12:59');

-- --------------------------------------------------------

--
-- Table structure for table `fp_attachment`
--

CREATE TABLE IF NOT EXISTS `fp_attachment` (
`attachment_id` int(11) NOT NULL,
  `attachment_title` varchar(100) NOT NULL,
  `attachment_description` text NOT NULL,
  `belongs_to` varchar(100) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `file` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fp_billing`
--

CREATE TABLE IF NOT EXISTS `fp_billing` (
`billing_id` int(11) NOT NULL,
  `ref_no` varchar(100) NOT NULL,
  `client_id` int(11) NOT NULL,
  `issue_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `due_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `valid_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tax` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `notes` text,
  `billing_type` enum('estimate','invoice') NOT NULL,
  `invoiced_on` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_billing`
--

INSERT INTO `fp_billing` (`billing_id`, `ref_no`, `client_id`, `issue_date`, `due_date`, `valid_date`, `tax`, `discount`, `currency`, `notes`, `billing_type`, `invoiced_on`, `created_at`, `updated_at`) VALUES
(1, '1231', 1, '2016-03-18 16:00:00', '0000-00-00 00:00:00', '2016-03-31 16:00:00', '0.00', '0.00', 'usd', 'the estimate test', 'estimate', NULL, '2016-03-16 06:26:40', '2016-03-16 06:26:40'),
(2, '12321', 1, '2016-03-15 16:00:00', '2016-03-16 16:00:00', '0000-00-00 00:00:00', '0.00', '0.00', 'usd', '', 'invoice', NULL, '2016-03-16 06:33:12', '2016-03-16 06:33:12');

-- --------------------------------------------------------

--
-- Table structure for table `fp_bug`
--

CREATE TABLE IF NOT EXISTS `fp_bug` (
`bug_id` int(11) NOT NULL,
  `ref_no` varchar(100) NOT NULL,
  `project_id` int(11) NOT NULL,
  `bug_priority` enum('low','medium','high','critical') NOT NULL,
  `bug_description` text,
  `bug_status` enum('unconfirmed','confirmed','progress','resolved') NOT NULL,
  `reported_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_bug`
--

INSERT INTO `fp_bug` (`bug_id`, `ref_no`, `project_id`, `bug_priority`, `bug_description`, `bug_status`, `reported_on`, `created_at`, `updated_at`) VALUES
(1, '2334', 1, 'high', 'project controller bugs', 'progress', '2016-02-14 16:00:00', '2016-03-15 06:09:34', '2016-03-17 12:28:49');

-- --------------------------------------------------------

--
-- Table structure for table `fp_client`
--

CREATE TABLE IF NOT EXISTS `fp_client` (
`client_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text,
  `zipcode` varchar(10) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_client`
--

INSERT INTO `fp_client` (`client_id`, `company_name`, `contact_person`, `email`, `phone`, `address`, `zipcode`, `city`, `state`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'HDEnergy', 'ralph', 'ralph@gmail.com', '123123123', 'asdfasdfsdf sdf a', '1023', 'davao city', 'asdf asdf', 185, '2016-03-14 17:43:15', '2016-03-14 09:43:15'),
(2, 'Test', 'Test', 'test@gmail.com', '1234567890', 'Test', '2600', 'Baguio City', 'Benguet', 185, '2016-04-27 00:18:32', '2016-04-27 00:18:32'),
(3, 'Test2', '1234567890', 'jexterdeanbuenaventura@gmail.com', '1234567890', 'Test', '2600', 'Baguio City', 'Benguet', 185, '2016-04-27 01:51:07', '2016-04-27 01:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `fp_comment`
--

CREATE TABLE IF NOT EXISTS `fp_comment` (
`comment_id` int(11) NOT NULL,
  `commenter_id` int(11) NOT NULL,
  `commenter_type` varchar(255) NOT NULL,
  `belongs_to` varchar(10) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_comment`
--

INSERT INTO `fp_comment` (`comment_id`, `commenter_id`, `commenter_type`, `belongs_to`, `unique_id`, `comment`, `created_at`, `updated_at`) VALUES
(3, 18, 'employee', 'applicant', 9, 'Test', '2016-06-08 13:09:53', '2016-05-24 04:11:36'),
(4, 18, 'employee', 'applicant', 9, 'Test', '2016-06-08 13:09:53', '2016-05-24 04:12:03'),
(5, 18, 'employee', 'applicant', 9, 'Test', '2016-06-08 13:09:53', '2016-05-24 04:12:57'),
(6, 18, 'employee', 'applicant', 9, 'Test', '2016-06-08 13:09:53', '2016-05-24 04:13:27'),
(7, 18, 'employee', 'applicant', 9, 'Test', '2016-06-08 13:09:53', '2016-05-24 04:14:04'),
(8, 18, 'employee', 'applicant', 9, 'Test', '2016-06-08 13:09:53', '2016-05-24 04:14:56'),
(9, 18, 'employee', 'applicant', 9, 'Test', '2016-06-08 13:09:53', '2016-05-24 04:17:09'),
(10, 18, 'employee', 'applicant', 9, 'Test', '2016-06-08 13:09:53', '2016-05-24 04:19:49'),
(11, 18, 'employee', 'applicant', 9, 'Test', '2016-06-08 13:09:53', '2016-05-24 04:23:59'),
(12, 18, 'employee', 'applicant', 9, 'Test', '2016-06-08 13:09:53', '2016-05-24 04:24:54'),
(13, 18, 'employee', 'applicant', 9, 'Test', '2016-06-08 13:09:53', '2016-05-24 04:25:59'),
(14, 18, 'employee', 'applicant', 9, 'Test', '2016-06-08 13:09:53', '2016-05-24 04:28:16'),
(15, 18, 'employee', 'applicant', 9, 'Test', '2016-06-08 13:09:53', '2016-05-24 04:43:10'),
(16, 18, 'employee', 'applicant', 8, 'Test', '2016-06-08 13:09:53', '2016-05-24 04:55:31'),
(17, 18, 'employee', 'applicant', 4, 'Test', '2016-06-08 13:09:53', '2016-05-24 04:58:18'),
(18, 18, 'employee', 'applicant', 4, 'Test', '2016-06-08 13:09:53', '2016-05-24 05:11:43'),
(19, 18, 'employee', 'applicant', 4, 'Testing comment', '2016-06-08 13:09:53', '2016-05-24 05:11:57'),
(20, 18, 'employee', 'applicant', 5, 'Test', '2016-06-08 13:09:53', '2016-05-24 05:18:36'),
(21, 18, 'employee', 'applicant', 5, 'Test', '2016-06-08 13:09:53', '2016-05-24 05:21:20'),
(22, 18, 'employee', 'applicant', 4, 'Testing Again\r\n', '2016-06-08 13:09:53', '2016-05-24 05:23:59'),
(23, 18, 'employee', 'applicant', 4, 'Testing Test\r\n', '2016-06-08 13:09:53', '2016-05-24 05:24:50'),
(24, 18, 'employee', 'applicant', 4, 'Testing Again\r\n', '2016-06-08 13:09:53', '2016-05-24 05:25:22'),
(25, 18, 'employee', 'applicant', 4, 'Testing\r\n', '2016-06-08 13:09:53', '2016-05-24 05:26:56'),
(26, 18, 'employee', 'applicant', 4, 'Test', '2016-06-08 13:09:53', '2016-05-24 05:27:05'),
(27, 18, 'employee', 'applicant', 4, 'Tester\r\n', '2016-06-08 13:09:53', '2016-05-24 05:27:31'),
(28, 18, 'employee', 'applicant', 4, 'Test', '2016-06-08 13:09:53', '2016-05-24 05:34:43'),
(29, 18, 'employee', 'applicant', 4, 'Testing this comment\r\n', '2016-06-08 13:09:53', '2016-05-24 05:36:11'),
(30, 18, 'employee', 'applicant', 4, 'Test', '2016-06-08 13:09:53', '2016-05-24 05:36:46'),
(31, 18, 'employee', 'applicant', 9, 'Test 2', '2016-06-08 13:09:53', '2016-05-24 06:41:18'),
(32, 0, 'employee', 'applicant', 4, 'Test', '2016-06-08 13:09:53', '2016-05-27 04:02:27'),
(33, 0, 'employee', 'applicant', 4, 'Test 1\r\n', '2016-06-08 13:09:53', '2016-05-27 04:15:41'),
(34, 0, 'employee', 'applicant', 4, 'Test 2', '2016-06-08 13:09:53', '2016-05-27 04:15:45'),
(35, 18, 'employee', 'applicant', 4, 'Test 3', '2016-06-08 13:09:53', '2016-05-27 04:18:57'),
(36, 18, 'employee', 'applicant', 9, 'Test 3', '2016-06-08 13:09:53', '2016-06-07 00:10:04'),
(37, 18, 'employee', 'applicant', 20, 'Test', '2016-06-08 13:09:53', '2016-06-08 04:18:57'),
(38, 18, 'employee', 'applicant', 20, 'Test', '2016-06-08 13:09:53', '2016-06-08 04:20:47'),
(39, 18, 'employee', 'applicant', 20, 'Test', '2016-06-08 13:09:53', '2016-06-08 04:22:04'),
(40, 18, 'employee', 'applicant', 20, 'Test 1', '2016-06-08 13:09:53', '2016-06-08 04:24:15'),
(41, 18, 'employee', 'applicant', 20, 'Test 2', '2016-06-08 13:09:53', '2016-06-08 04:25:20'),
(42, 18, 'employee', 'applicant', 20, 'Test 3', '2016-06-08 13:09:53', '2016-06-08 04:29:12'),
(43, 18, 'employee', 'applicant', 20, 'Test 4', '2016-06-08 13:09:53', '2016-06-08 04:32:44'),
(44, 18, 'employee', 'applicant', 20, 'Test 5', '2016-06-08 13:09:53', '2016-06-08 04:34:17'),
(45, 18, 'employee', 'applicant', 20, 'Test 6', '2016-06-08 13:09:53', '2016-06-08 04:34:59'),
(46, 18, 'employee', 'applicant', 20, 'Test 7', '2016-06-08 13:09:53', '2016-06-08 04:37:08'),
(47, 18, 'employee', 'applicant', 20, 'Test 8', '2016-06-08 13:09:53', '2016-06-08 04:50:52'),
(48, 18, 'employee', 'applicant', 20, 'Test 9', '2016-06-08 13:09:53', '2016-06-08 04:53:10'),
(49, 18, 'employee', 'applicant', 20, 'Test 10', '2016-06-08 05:35:25', '2016-06-08 05:35:25'),
(50, 18, 'employee', 'applicant', 20, 'Test 11', '2016-06-08 05:45:21', '2016-06-08 05:45:21'),
(51, 18, 'employee', 'applicant', 20, 'Test 12', '2016-06-08 05:49:57', '2016-06-08 05:49:57'),
(52, 18, 'employee', 'applicant', 20, 'Test 13', '2016-06-08 05:52:10', '2016-06-08 05:52:10'),
(53, 18, 'employee', 'applicant', 20, 'Test 14', '2016-06-08 05:52:50', '2016-06-08 05:52:50'),
(54, 18, 'employee', 'applicant', 20, 'Test 15', '2016-06-08 05:54:22', '2016-06-08 05:54:22'),
(55, 18, 'employee', 'applicant', 20, 'Test 16', '2016-06-08 05:56:51', '2016-06-08 05:56:51'),
(56, 18, 'employee', 'applicant', 20, 'Test 17', '2016-06-08 05:59:22', '2016-06-08 05:59:22'),
(57, 18, 'employee', 'applicant', 20, 'Test 18', '2016-06-08 06:00:18', '2016-06-08 06:00:18'),
(58, 18, 'employee', 'applicant', 20, 'Test 19', '2016-06-08 06:13:42', '2016-06-08 06:13:42'),
(59, 18, 'employee', 'applicant', 20, 'Test 20', '2016-06-08 06:16:27', '2016-06-08 06:16:27'),
(60, 18, 'employee', 'applicant', 20, 'Test 21', '2016-06-08 06:17:21', '2016-06-08 06:17:21'),
(61, 18, 'employee', 'applicant', 20, 'Test 22', '2016-06-08 06:18:36', '2016-06-08 06:18:36'),
(62, 18, 'employee', 'applicant', 20, 'Test 23', '2016-06-08 06:20:21', '2016-06-08 06:20:21'),
(63, 18, 'employee', 'applicant', 20, 'Test 24', '2016-06-08 06:22:14', '2016-06-08 06:22:14'),
(64, 18, 'employee', 'applicant', 20, 'Test 25', '2016-06-08 06:25:24', '2016-06-08 06:25:24'),
(65, 18, 'employee', 'applicant', 20, 'Test 26', '2016-06-08 06:27:06', '2016-06-08 06:27:06'),
(66, 18, 'employee', 'applicant', 21, 'Testing', '2016-06-08 06:30:40', '2016-06-08 06:30:40'),
(67, 18, 'employee', 'applicant', 21, 'Testing Again', '2016-06-08 06:31:26', '2016-06-08 06:31:26'),
(68, 18, 'employee', 'applicant', 21, 'Test', '2016-06-08 06:42:38', '2016-06-08 06:42:38'),
(69, 21, 'applicant', 'applicant', 21, 'Test 1', '2016-06-08 06:56:55', '2016-06-08 06:56:55'),
(70, 18, 'employee', 'applicant', 25, 'Test', '2016-06-09 00:56:30', '2016-06-09 00:56:30'),
(71, 25, 'applicant', 'applicant', 25, 'Testing', '2016-06-09 00:58:22', '2016-06-09 00:58:22'),
(72, 18, 'employee', 'applicant', 25, 'Testing From Chrome', '2016-06-09 01:06:46', '2016-06-09 01:06:46'),
(73, 18, 'employee', 'applicant', 4, 'Test 4', '2016-06-17 03:00:16', '2016-06-17 03:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `fp_companies`
--

CREATE TABLE IF NOT EXISTS `fp_companies` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number_of_employees` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `address_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_companies`
--

INSERT INTO `fp_companies` (`id`, `name`, `email`, `phone`, `number_of_employees`, `address_1`, `address_2`, `province`, `zipcode`, `website`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'HD Energy', 'sales@hdenergy.ca', '1234567890', '1', 'Ontario', NULL, NULL, NULL, NULL, 15, '2016-05-11 06:34:13', '0000-00-00 00:00:00'),
(18, 'Test Company', 'testcompany@gmail.com', '1234567890', 'more than 5', 'Test', 'Test', 'Benguet', '2600', 'test.com', 185, '2016-06-03 03:36:14', '2016-06-03 03:36:14'),
(19, 'Test Company 2', 'testcompany2@gmail.com', '1234567890', '1 employee', 'Test', 'Test', 'Test', '2600', 'testcompany2.com', 185, '2016-06-06 00:23:31', '2016-06-06 00:23:31');

-- --------------------------------------------------------

--
-- Table structure for table `fp_company_divisions`
--

CREATE TABLE IF NOT EXISTS `fp_company_divisions` (
`id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `division_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_company_divisions`
--

INSERT INTO `fp_company_divisions` (`id`, `company_id`, `division_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Oshawa', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `fp_country`
--

CREATE TABLE IF NOT EXISTS `fp_country` (
`country_id` int(11) unsigned NOT NULL,
  `country_name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=258 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_country`
--

INSERT INTO `fp_country` (`country_id`, `country_name`) VALUES
(1, 'Afghanistan'),
(2, 'Akrotiri'),
(3, 'Albania'),
(4, 'Algeria'),
(5, 'American Samoa'),
(6, 'Andorra'),
(7, 'Angola'),
(8, 'Anguilla'),
(9, 'Antarctica'),
(10, 'Antigua and Barbuda'),
(11, 'Argentina'),
(12, 'Armenia'),
(13, 'Aruba'),
(14, 'Ashmore and Cartier Islands'),
(15, 'Australia'),
(16, 'Austria'),
(17, 'Azerbaijan'),
(18, 'Bahamas, The'),
(19, 'Bahrain'),
(20, 'Bangladesh'),
(21, 'Barbados'),
(22, 'Bassas da India'),
(23, 'Belarus'),
(24, 'Belgium'),
(25, 'Belize'),
(26, 'Benin'),
(27, 'Bermuda'),
(28, 'Bhutan'),
(29, 'Bolivia'),
(30, 'Bosnia and Herzegovina'),
(31, 'Botswana'),
(32, 'Bouvet Island'),
(33, 'Brazil'),
(34, 'British Indian Ocean Territory'),
(35, 'British Virgin Islands'),
(36, 'Brunei'),
(37, 'Bulgaria'),
(38, 'Burkina Faso'),
(39, 'Burma'),
(40, 'Burundi'),
(41, 'Cambodia'),
(42, 'Cameroon'),
(43, 'Canada'),
(44, 'Cape Verde'),
(45, 'Cayman Islands'),
(46, 'Central African Republic'),
(47, 'Chad'),
(48, 'Chile'),
(49, 'China'),
(50, 'Christmas Island'),
(51, 'Clipperton Island'),
(52, 'Cocos (Keeling) Islands'),
(53, 'Colombia'),
(54, 'Comoros'),
(55, 'Congo, Democratic Republic of the'),
(56, 'Congo, Republic of the'),
(57, 'Cook Islands'),
(58, 'Coral Sea Islands'),
(59, 'Costa Rica'),
(60, 'Cote d''Ivoire'),
(61, 'Croatia'),
(62, 'Cuba'),
(63, 'Cyprus'),
(64, 'Czech Republic'),
(65, 'Denmark'),
(66, 'Dhekelia'),
(67, 'Djibouti'),
(68, 'Dominica'),
(69, 'Dominican Republic'),
(70, 'Ecuador'),
(71, 'Egypt'),
(72, 'El Salvador'),
(73, 'Equatorial Guinea'),
(74, 'Eritrea'),
(75, 'Estonia'),
(76, 'Ethiopia'),
(77, 'Europa Island'),
(78, 'Falkland Islands (Islas Malvinas)'),
(79, 'Faroe Islands'),
(80, 'Fiji'),
(81, 'Finland'),
(82, 'France'),
(83, 'French Guiana'),
(84, 'French Polynesia'),
(85, 'French Southern and Antarctic Lands'),
(86, 'Gabon'),
(87, 'Gambia, The'),
(88, 'Gaza Strip'),
(89, 'Georgia'),
(90, 'Germany'),
(91, 'Ghana'),
(92, 'Gibraltar'),
(93, 'Glorioso Islands'),
(94, 'Greece'),
(95, 'Greenland'),
(96, 'Grenada'),
(97, 'Guadeloupe'),
(98, 'Guam'),
(99, 'Guatemala'),
(100, 'Guernsey'),
(101, 'Guinea'),
(102, 'Guinea-Bissau'),
(103, 'Guyana'),
(104, 'Haiti'),
(105, 'Heard Island and McDonald Islands'),
(106, 'Holy See (Vatican City)'),
(107, 'Honduras'),
(108, 'Hong Kong'),
(109, 'Hungary'),
(110, 'Iceland'),
(111, 'India'),
(112, 'Indonesia'),
(113, 'Iran'),
(114, 'Iraq'),
(115, 'Ireland'),
(116, 'Isle of Man'),
(117, 'Israel'),
(118, 'Italy'),
(119, 'Jamaica'),
(120, 'Jan Mayen'),
(121, 'Japan'),
(122, 'Jersey'),
(123, 'Jordan'),
(124, 'Juan de Nova Island'),
(125, 'Kazakhstan'),
(126, 'Kenya'),
(127, 'Kiribati'),
(128, 'Korea, North'),
(129, 'Korea, South'),
(130, 'Kuwait'),
(131, 'Kyrgyzstan'),
(132, 'Laos'),
(133, 'Latvia'),
(134, 'Lebanon'),
(135, 'Lesotho'),
(136, 'Liberia'),
(137, 'Libya'),
(138, 'Liechtenstein'),
(139, 'Lithuania'),
(140, 'Luxembourg'),
(141, 'Macau'),
(142, 'Macedonia'),
(143, 'Madagascar'),
(144, 'Malawi'),
(145, 'Malaysia'),
(146, 'Maldives'),
(147, 'Mali'),
(148, 'Malta'),
(149, 'Marshall Islands'),
(150, 'Martinique'),
(151, 'Mauritania'),
(152, 'Mauritius'),
(153, 'Mayotte'),
(154, 'Mexico'),
(155, 'Micronesia, Federated States of'),
(156, 'Moldova'),
(157, 'Monaco'),
(158, 'Mongolia'),
(159, 'Montserrat'),
(160, 'Morocco'),
(161, 'Mozambique'),
(162, 'Namibia'),
(163, 'Nauru'),
(164, 'Navassa Island'),
(165, 'Nepal'),
(166, 'Netherlands'),
(167, 'Netherlands Antilles'),
(168, 'New Caledonia'),
(169, 'New Zealand'),
(170, 'Nicaragua'),
(171, 'Niger'),
(172, 'Nigeria'),
(173, 'Niue'),
(174, 'Norfolk Island'),
(175, 'Northern Mariana Islands'),
(176, 'Norway'),
(177, 'Oman'),
(178, 'Pakistan'),
(179, 'Palau'),
(180, 'Panama'),
(181, 'Papua New Guinea'),
(182, 'Paracel Islands'),
(183, 'Paraguay'),
(184, 'Peru'),
(185, 'Philippines'),
(186, 'Pitcairn Islands'),
(187, 'Poland'),
(188, 'Portugal'),
(189, 'Puerto Rico'),
(190, 'Qatar'),
(191, 'Reunion'),
(192, 'Romania'),
(193, 'Russia'),
(194, 'Rwanda'),
(195, 'Saint Helena'),
(196, 'Saint Kitts and Nevis'),
(197, 'Saint Lucia'),
(198, 'Saint Pierre and Miquelon'),
(199, 'Saint Vincent and the Grenadines'),
(200, 'Samoa'),
(201, 'San Marino'),
(202, 'Sao Tome and Principe'),
(203, 'Saudi Arabia'),
(204, 'Senegal'),
(205, 'Serbia and Montenegro'),
(206, 'Seychelles'),
(207, 'Sierra Leone'),
(208, 'Singapore'),
(209, 'Slovakia'),
(210, 'Slovenia'),
(211, 'Solomon Islands'),
(212, 'Somalia'),
(213, 'South Africa'),
(214, 'South Georgia and the South Sandwich Islands'),
(215, 'Spain'),
(216, 'Spratly Islands'),
(217, 'Sri Lanka'),
(218, 'Sudan'),
(219, 'Suriname'),
(220, 'Svalbard'),
(221, 'Swaziland'),
(222, 'Sweden'),
(223, 'Switzerland'),
(224, 'Syria'),
(225, 'Taiwan'),
(226, 'Tajikistan'),
(227, 'Tanzania'),
(228, 'Thailand'),
(229, 'Timor-Leste'),
(230, 'Togo'),
(231, 'Tokelau'),
(232, 'Tonga'),
(233, 'Trinidad and Tobago'),
(234, 'Tromelin Island'),
(235, 'Tunisia'),
(236, 'Turkey'),
(237, 'Turkmenistan'),
(238, 'Turks and Caicos Islands'),
(239, 'Tuvalu'),
(240, 'Uganda'),
(241, 'Ukraine'),
(242, 'United Arab Emirates'),
(243, 'United Kingdom'),
(244, 'United States'),
(245, 'Uruguay'),
(246, 'Uzbekistan'),
(247, 'Vanuatu'),
(248, 'Venezuela'),
(249, 'Vietnam'),
(250, 'Virgin Islands'),
(251, 'Wake Island'),
(252, 'Wallis and Futuna'),
(253, 'West Bank'),
(254, 'Western Sahara'),
(255, 'Yemen'),
(256, 'Zambia'),
(257, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `fp_events`
--

CREATE TABLE IF NOT EXISTS `fp_events` (
`event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_title` varchar(1000) CHARACTER SET latin1 NOT NULL,
  `event_description` text CHARACTER SET latin1,
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_date` timestamp NULL DEFAULT NULL,
  `public` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_events`
--

INSERT INTO `fp_events` (`event_id`, `user_id`, `event_title`, `event_description`, `start_date`, `end_date`, `public`, `created_at`, `updated_at`) VALUES
(2, 6, 'esda', 'asdfsf', '2016-05-11 16:12:56', '2016-03-18 16:00:00', 0, '2016-03-17 00:07:34', '2016-03-17 00:07:34'),
(3, 6, 'sest', 'asdf', '2016-05-11 16:13:00', '2016-03-20 16:00:00', 0, '2016-03-17 01:54:42', '2016-03-17 01:54:42');

-- --------------------------------------------------------

--
-- Table structure for table `fp_item`
--

CREATE TABLE IF NOT EXISTS `fp_item` (
`item_id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_quantity` decimal(10,2) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `item_description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_item`
--

INSERT INTO `fp_item` (`item_id`, `billing_id`, `item_name`, `item_quantity`, `unit_price`, `item_description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Work1', '1.00', '10.00', NULL, '2016-03-16 06:31:28', '2016-03-16 06:31:28');

-- --------------------------------------------------------

--
-- Table structure for table `fp_jobs`
--

CREATE TABLE IF NOT EXISTS `fp_jobs` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `notes` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_jobs`
--

INSERT INTO `fp_jobs` (`id`, `user_id`, `company_id`, `title`, `description`, `photo`, `created_at`, `updated_at`, `notes`) VALUES
(10, 18, 1, 'Testing 1', 'Testing 1', 'assets/job\\company_logo_2.jpg', '2016-05-23 06:02:59', '2016-06-14 08:36:16', '<p>TestingTestingTestingTesting</p>\r\n\r\n<p>TestingTestingTestingTesting</p>\r\n\r\n<p>TestingTestingTestingTesting</p>\r\n\r\n<p>TestingTestingTestingTesting</p>\r\n'),
(11, 18, 1, 'Test 5', '<p>Test 5</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Test 5</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Test 5</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Test 5</p>\r\n', 'assets/job\\company_logo_3.png', '2016-05-23 06:10:17', '2016-06-01 03:02:58', '<p>Testing</p>\r\n'),
(12, 18, 1, 'Test 1', 'Test  1', 'assets/job\\company_logo_2.jpg', '2016-05-23 09:39:42', '2016-05-23 09:40:10', ''),
(13, 18, 1, 'Test', '<p>Test</p>\r\n', 'assets/user/avatar.png', '2016-05-27 05:46:42', '2016-05-27 05:46:42', ''),
(14, 18, 1, 'Test 4', '<p>Test 4</p>\r\n', '', '2016-05-27 07:48:48', '2016-05-27 07:48:48', ''),
(15, 18, 15, 'Test ', '<p>Test</p>\r\n', '', '2016-06-01 01:55:02', '2016-06-01 01:55:02', ''),
(16, 18, 1, 'Test 6', '<p>Test</p>\r\n', '', '2016-06-03 00:29:30', '2016-06-03 00:29:30', ''),
(17, 18, 15, 'Test Job', '<p>Test</p>\r\n', '', '2016-06-03 02:23:10', '2016-06-03 02:23:10', ''),
(18, 18, 1, 'Test Job 2', '<p>Test</p>\r\n', '', '2016-06-03 02:23:52', '2016-06-03 02:23:52', ''),
(19, 18, 18, 'Test Job 3', '<p>Test</p>\r\n', '', '2016-06-03 03:44:15', '2016-06-03 03:44:22', '<p>Test</p>\r\n'),
(28, 18, 1, 'Construction Worker, Calgary, AB - Job Details | Indeed.com', 'Looking for a person with the ability to maintain concentration for long periods in guiding a concrete cutting machine across floors. The floor cut must be straight and even a short period of losing focus will sent the cut off the guide line. If you like to party at night and come to work spaced out, then this is not the job for you.\n\n Must have steel toed work boots.\n Must be able to lift 80 lbs\n\nThis opening is urgent. Monday Sept 14, we are working at The South Centre Mall, at the South end of Macleod Trail at 10:00 am till 2 pm on the North side by Shoppers Drug Mart. We will be testing applicants ability to control the machine. Look for the truck and trailer marked "Destiny Cutting and Coring".\nPics of the Job http://www.destinycuttingandcoring.com/home.html\nCall Tom Coghill 403-805-9364I will be at the site in blue coveralls.\nIMPORTANT INSTRUCTIONS: Open the link http://hirefit.net/j/4 and add your resume and a pic if you have one as it helps us remember who your talking to and will be photo ID if your hired. We do not look at indeed for resumes. If you do not upload to hirefit then you will be interviewed. This is custom coded for our companies for resume processing.\nJob Type: Full-time', '', '2016-06-15 02:50:47', '2016-06-15 02:50:47', NULL),
(29, 18, 1, 'Cutting and Coring Apprentice - URGENT, Calgary, AB - Job Details | Indeed.com', 'Looking for a person with the ability to maintain concentration for long periods in guiding a concrete cutting machine across floors. The floor cut must be straight and even a short period of losing focus will sent the cut off the guide line. If you like to party at night and come to work spaced out, then this is not the job for you.\n\n Must have steel toed work boots.\n Must be able to lift 80 lbs\n\nThis opening is urgent. Monday Sept 14, we are working at The South Centre Mall, at the South end of Macleod Trail at 10:00 am till 2 pm on the North side by Shoppers Drug Mart. We will be testing applicants ability to control the machine. Look for the truck and trailer marked "Destiny Cutting and Coring".\nPics of the Job http://www.destinycuttingandcoring.com/home.html\nCall Tom Coghill 403-805-9364I will be at the site in blue coveralls.\nIMPORTANT INSTRUCTIONS: Open the link http://hirefit.net/j/4 and add your resume and a pic if you have one as it helps us remember who your talking to and will be photo ID if your hired. We do not look at indeed for resumes. If you do not upload to hirefit then you will be interviewed. This is custom coded for our companies for resume processing.\nJob Type: Full-time', '', '2016-06-15 02:50:53', '2016-06-15 02:50:53', NULL),
(30, 18, 1, 'Domestic Helper (Erlton St SW), Calgary, AB - Job Details | Indeed.com', 'Busy executive seeks domestic help three times per week, 2 hours per day. House is located on the river.Location: 25 Ave SW & Erlton St SW\nDuties: Light house work. Feed and walk the dog. Occasional errands.This is a fun work environment for someone in the area that is looking to supplement their income.\nQuestions: Call Tom 403-805 9364\nInstructions: Please hit apply and upload your resume: http://hirefit.net/j/3This is a platform we use for processing and hiring staff for the companies owned by Henry the home owner. It is better to call me after you upload as I can keep the notes easier.\nJob Type: Part-time\nSalary: $25.00 /hour\nJob Location:\n\n Calgary, AB\n', '', '2016-06-15 02:50:58', '2016-06-15 02:50:58', NULL),
(31, 18, 1, 'General Helper- With a Clear Mind, Calgary, AB - Job Details | Indeed.com', 'Looking for a person with the ability to maintain concentration for long periods in guiding a concrete cutting machine across floors. The floor cut must be straight and even a short period of losing focus will sent the cut off the guide line. If you like to party at night and come to work spaced out, then this is not the job for you.\n\n Must have steel toed work boots.\n Must be able to lift 80 lbs\n\nThis opening is urgent. Monday Sept 14, we are working at The South Centre Mall, at the South end of Macleod Trail at 10:00 am till 2 pm on the North side by Shoppers Drug Mart. We will be testing applicants ability to control the machine. Look for the truck and trailer marked "Destiny Cutting and Coring".\nPics of the Job http://www.destinycuttingandcoring.com/home.html\nCall Tom Coghill 403-805-9364I will be at the site in blue coveralls.\nIMPORTANT INSTRUCTIONS: Open the link http://hirefit.net/j/4 and add your resume and a pic if you have one as it helps us remember who your talking to and will be photo ID if your hired. We do not look at indeed for resumes. If you do not upload to hirefit then you will be interviewed. This is custom coded for our companies for resume processing.', '', '2016-06-15 02:51:03', '2016-06-15 02:51:03', NULL),
(32, 18, 1, 'Project Manager/Estimator, Calgary, AB - Job Details | Indeed.com', 'Grade Pros Inc. is a commercial excavation and grading company located in Calgary, Alberta. By specializing on the pre-construction stage of commercial, industrial and new residential developments the company occupies a niche in the industry. Whether your development is large or small Grade Pros Inc.’s expertise includes:\n– Roadway preparation– Site grading– Berm construction– Catch basin installation– Utility pipe installation prior to construction/paving– Heavy equipment earthmoving– Demolition, concrete breaking, cutting and removal– New building excavation and backfill– Large and small scale slab on grade– Finished grading and loam installation.\nGrade Pros Inc. has an experienced team committed to delivering these services in an accurate, safe and timely manner which is critical to laying the foundation for a successful project that is “On Schedule, On Budget and On Grade.”\nJob Description\n\n Work with management to complete tenders and negotiate construction contracts including scheduling, procuring subcontractors and materials, and creating the project budget.\n Take full accountability as the main point of contact for clients.\n To manage bid responses and content quality\n To develop ongoing opportunities driving cost efficiencies through a proactive approach, best practice and continuous improvement.\n To develop and maintain successful working relationships with the client, key stakeholders and customers including monthly and quarterly performance reviews.\n To be responsible for ensuring that all bids are monitored to the point of final deposit.\n Source quotes and contracts from subcontractors and material suppliers.\n Analyse completed construction projects to measure the accuracy of estimates and to manage compliance with the project budget.\n Provide project management of selected projects, including planning, scheduling, coordinating all aspects of work\n Manage contracts, change orders, submittal, subcontracts and material orders.\n Communicate directly with engineers, consultants and clients.\n Track and measure production rates and profitability of various projects.\n Seek new tendering/negotiating opportunities and maintain relationships with clients.\n\nQualifications/skills:\n\n Construction field experience and knowledge of technology, equipment, materials, methodology, and standard specifications.\n Experience with large construction projects in Calgary.\n Excellent organizational, planning, and communication skills.\n Ability to work as part of a team with senior staff, project managers, field and office staff, and be self-motivated.\n Willingness to work under pressure, set goals, and meet deadlines.\n\nPlease add your name, phone and email to the body of the email.\nRequired experience:\n\n Estimating construction projects: 3 years\n', '', '2016-06-15 02:51:09', '2016-06-15 02:51:09', NULL),
(33, 18, 1, 'Smart Person with Excellent Concentration, Calgary, AB - Job Details | Indeed.com', 'Looking for a person with the ability to maintain concentration for long periods in guiding a concrete cutting machine across floors. The floor cut must be straight and even a short period of losing focus will sent the cut off the guide line. If you like to party at night and come to work spaced out, then this is not the job for you.\n\n Must have steel toed work boots.\n Must be able to lift 80 lbs\n\nThis opening is urgent. Monday Sept 14, we are working at The South Centre Mall, at the South end of Macleod Trail at 10:00 am till 2 pm on the North side by Shoppers Drug Mart. We will be testing applicants ability to control the machine. Look for the truck and trailer marked "Destiny Cutting and Coring".\nPics of the Job http://www.destinycuttingandcoring.com/home.html\nCall Tom Coghill 403-805-9364I will be at the site in blue coveralls.\nIMPORTANT INSTRUCTIONS: Open the link http://hirefit.net/j/4 and add your resume and a pic if you have one as it helps us remember who your talking to and will be photo ID if your hired. We do not look at indeed for resumes. If you do not upload to hirefit then you will be interviewed. This is custom coded for our companies for resume processing.\nJob Location:\n\n Calgary, AB\n', '', '2016-06-15 02:51:14', '2016-06-15 02:51:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fp_links`
--

CREATE TABLE IF NOT EXISTS `fp_links` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `descriptions` text COLLATE utf8_unicode_ci NOT NULL,
  `tags` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `task_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_links`
--

INSERT INTO `fp_links` (`id`, `title`, `url`, `descriptions`, `tags`, `comments`, `category_id`, `created_at`, `updated_at`, `task_id`) VALUES
(2, 'Test', 'test.com', 'Test', '', '', 0, '2016-04-27 01:45:16', '2016-04-27 01:45:16', 3),
(3, 'Test 2', 'test2.com', 'Test', '', '', 0, '2016-04-27 02:46:11', '2016-04-27 02:46:11', 3),
(4, 'Test', 'test.com', 'Test', '', '', 0, '2016-04-28 07:31:02', '2016-04-28 07:31:02', 6),
(5, 'Test 2', 'test2.com', 'Test', '', '', 0, '2016-04-28 07:33:58', '2016-04-28 07:33:58', 6);

-- --------------------------------------------------------

--
-- Table structure for table `fp_link_categories`
--

CREATE TABLE IF NOT EXISTS `fp_link_categories` (
`id` int(10) unsigned NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_link_tags`
--

CREATE TABLE IF NOT EXISTS `fp_link_tags` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_mail_queue`
--

CREATE TABLE IF NOT EXISTS `fp_mail_queue` (
`id` bigint(20) unsigned NOT NULL,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_meeting`
--

CREATE TABLE IF NOT EXISTS `fp_meeting` (
`id` int(10) unsigned NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `type_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `estimated_length` double(8,2) NOT NULL,
  `priority_id` int(11) NOT NULL,
  `attendees` text COLLATE utf8_unicode_ci NOT NULL,
  `meeting_url` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_meeting`
--

INSERT INTO `fp_meeting` (`id`, `project_id`, `user_id`, `start_date`, `end_date`, `type_id`, `description`, `estimated_length`, `priority_id`, `attendees`, `meeting_url`, `created_at`, `updated_at`) VALUES
(1, 1, 14, '2016-04-06 00:00:00', '2016-04-06 12:59:00', 1, 'Test', 12.00, 1, '["8","9","15"]', 'test', '2016-04-26 02:42:03', '2016-04-26 05:01:05'),
(2, 1, 6, '2016-04-07 00:00:00', '2016-04-07 12:59:00', 1, 'Test', 12.00, 2, '["6"]', 'Test', '2016-04-26 03:07:01', '2016-04-26 03:07:01'),
(3, 1, 6, '2016-04-05 00:00:00', '2016-04-05 12:59:00', 1, 'Test', 12.00, 1, '["15"]', 'test', '2016-04-26 03:11:05', '2016-04-26 03:11:05'),
(4, 2, 6, '2016-04-08 00:00:00', '2016-04-08 12:59:00', 2, 'Test', 30.00, 2, '["14","15","16"]', '', '2016-04-26 23:35:29', '2016-04-26 23:35:29');

-- --------------------------------------------------------

--
-- Table structure for table `fp_meeting_priority`
--

CREATE TABLE IF NOT EXISTS `fp_meeting_priority` (
`id` int(10) unsigned NOT NULL,
  `priority` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_meeting_priority`
--

INSERT INTO `fp_meeting_priority` (`id`, `priority`, `created_at`, `updated_at`) VALUES
(1, 'Normal', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Urgent', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `fp_meeting_type`
--

CREATE TABLE IF NOT EXISTS `fp_meeting_type` (
`id` int(10) unsigned NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_meeting_type`
--

INSERT INTO `fp_meeting_type` (`id`, `type`, `created_at`, `updated_at`) VALUES
(1, 'In Person', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Online', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Telephone', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `fp_message`
--

CREATE TABLE IF NOT EXISTS `fp_message` (
`message_id` int(11) NOT NULL,
  `message_subject` text NOT NULL,
  `message_content` text NOT NULL,
  `file` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_message`
--

INSERT INTO `fp_message` (`message_id`, `message_subject`, `message_content`, `file`, `created_at`, `updated_at`, `to_user_id`, `from_user_id`) VALUES
(1, 'hey', 'hey buddy<br>', '', '2016-03-16 16:44:12', '2016-03-16 16:44:12', 0, 0),
(2, 'Test', 'Test', '', '2016-04-26 23:34:49', '2016-04-26 23:34:49', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fp_migrations`
--

CREATE TABLE IF NOT EXISTS `fp_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_migrations`
--

INSERT INTO `fp_migrations` (`migration`, `batch`) VALUES
('2014_10_12_100000_create_password_resets_table', 1),
('2015_07_22_115516_create_ticketit_tables', 2),
('2015_07_22_123254_alter_users_table', 3),
('2015_09_29_123456_add_completed_at_column_to_ticketit_table', 3),
('2015_10_08_123457_create_settings_table', 3),
('2016_01_15_002617_add_htmlcontent_to_ticketit_and_comments', 3),
('2016_01_15_040207_enlarge_settings_columns', 3),
('2016_01_15_120557_add_indexes', 3),
('2015_01_15_105324_create_roles_table', 4),
('2015_01_15_114412_create_role_user_table', 5),
('2015_01_26_115212_create_permissions_table', 5),
('2015_01_26_115523_create_permission_role_table', 5),
('2015_02_09_132439_create_permission_user_table', 5),
('2016_03_23_155421_add_category_table', 5),
('2016_03_23_155435_add_links_table', 5),
('2016_03_23_162028_add_tags_table', 5),
('2016_04_02_070419_add_column_to_project_table', 6),
('2016_04_03_073424_create_meeting_table', 6),
('2016_04_03_084800_create_meeting_type_table', 6),
('2016_04_03_085458_create_meeting_priority_table', 6),
('2016_05_19_141425_create_task_checklist_permission_table', 7),
('2016_05_19_153450_update_task_checklist_permissions_table', 8),
('2016_05_23_065219_create_jobs_table', 9),
('2016_05_23_065537_create_applicants_table', 9),
('2016_05_23_160158_create_applicant_tags_table', 10),
('2016_05_23_081750_create_applicant_ratings_table', 11),
('2016_05_24_071706_create_videos_table', 12),
('2016_05_24_072847_create_video_tags_table', 12),
('2016_05_25_170952_create_test_per_applicant_table', 13),
('2016_05_25_171015_create_test_per_job', 13),
('2016_05_25_151202_update_test_table_change_author_id_to_user_id', 14),
('2016_05_26_153206_update_jobs_table_description_to_text', 15),
('2016_05_12_100510_update_test_table', 16),
('2016_05_26_095856_update_question_table', 16),
('2016_05_27_093838_create_applicant_roles', 16),
('2016_05_28_071227_create_test_result_table', 17),
('2016_05_31_070651_update_test_table', 18),
('2016_06_01_073253_update_question_table', 18),
('2016_06_01_101714_update_job_table_add_notes', 19),
('2016_06_01_101725_update_applicant_table_add_notes', 19),
('2016_06_02_072358_update_user_table_add_resume_and_notes', 20),
('2016_06_02_073259_update_applicant_table_add_hired_column', 20),
('2016_06_02_091438_update_user_nullable_fields', 21),
('2016_06_03_103000_update_applicant_table_make_email_unique', 22),
('2016_06_06_150752_update_test_results_table_turn_user_id_to_unique_id_add_id_type', 23),
('2016_06_02_103625_update_test_table_add_completion_files', 24),
('2016_06_04_074633_update_test_table_add_tags', 24),
('2016_06_04_084245_update_question_table_add_tags', 24),
('2016_06_07_091020_create_tests_taken_table', 24),
('2016_06_08_125621_update_comment_table_turn_user_id_to_commenter_id_and_user_type', 25),
('2016_06_08_140439_create_jobs_table', 26),
('2016_06_09_124723_update_task_check_list_table_update_checklist_header_and_checklist_content_to_nullable', 27),
('2016_06_09_165350_update_task_checklist_table_default_checklist_header', 28),
('2016_06_08_094416_update_text_result_add_points', 29),
('2016_06_13_072925_update_test_table_add_default_points', 30),
('2016_06_13_093019_create_team_companies_table', 31),
('2016_06_13_115103_create_share_jobs_table', 31),
('2016_06_13_145155_create_share_jobs_to_companies_table', 32),
('2016_06_13_170535_create_share_jobs_to_companies_permissions_table', 33),
('2016_06_17_110912_create_videos_table', 34),
('2016_06_17_132324_create_video_tags_table_2', 35);

-- --------------------------------------------------------

--
-- Table structure for table `fp_newnote`
--

CREATE TABLE IF NOT EXISTS `fp_newnote` (
`note_id` int(10) unsigned NOT NULL,
  `belongs_to` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `unique_id` int(11) NOT NULL,
  `note_content` text COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_notes`
--

CREATE TABLE IF NOT EXISTS `fp_notes` (
`note_id` int(11) NOT NULL,
  `belongs_to` varchar(20) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `note_content` text NOT NULL,
  `username` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_notes`
--

INSERT INTO `fp_notes` (`note_id`, `belongs_to`, `unique_id`, `note_content`, `username`, `created_at`, `updated_at`) VALUES
(2, 'billing', 1, 'this is total a total <b>amount</b>.', 'admin', '2016-03-16 06:28:35', '2016-03-16 06:28:35'),
(3, 'project', 2, 'Test 2', '', '2016-05-12 11:19:25', '2016-05-12 03:19:25'),
(4, 'project', 2, 'Testing', 'tomcoghill', '2016-05-10 10:47:49', '2016-05-10 02:47:49');

-- --------------------------------------------------------

--
-- Table structure for table `fp_password_resets`
--

CREATE TABLE IF NOT EXISTS `fp_password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_payment`
--

CREATE TABLE IF NOT EXISTS `fp_payment` (
`payment_id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_type` enum('cash','bank') NOT NULL,
  `payment_notes` text,
  `payment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fp_payment_method`
--

CREATE TABLE IF NOT EXISTS `fp_payment_method` (
`id` int(10) unsigned NOT NULL,
  `payment_method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_pay_period`
--

CREATE TABLE IF NOT EXISTS `fp_pay_period` (
`id` int(10) unsigned NOT NULL,
  `period` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_permissions`
--

CREATE TABLE IF NOT EXISTS `fp_permissions` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_permission_role`
--

CREATE TABLE IF NOT EXISTS `fp_permission_role` (
`id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_permission_user`
--

CREATE TABLE IF NOT EXISTS `fp_permission_user` (
`id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_profiles`
--

CREATE TABLE IF NOT EXISTS `fp_profiles` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_profiles`
--

INSERT INTO `fp_profiles` (`id`, `user_id`, `company_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 18, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, 18, 18, 11, '2016-06-03 03:36:15', '2016-06-03 03:36:15'),
(61, 18, 19, 14, '2016-06-06 00:23:32', '2016-06-06 00:23:32'),
(62, 19, 1, 3, '2016-06-09 01:34:01', '2016-06-10 00:18:23'),
(63, 20, 19, 1, '2016-06-13 03:56:01', '2016-06-13 03:56:01');

-- --------------------------------------------------------

--
-- Table structure for table `fp_project`
--

CREATE TABLE IF NOT EXISTS `fp_project` (
`project_id` int(11) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `ref_no` varchar(100) NOT NULL,
  `project_title` varchar(500) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deadline` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `project_description` text,
  `rate_type` enum('fixed','hourly') NOT NULL,
  `rate_value` float NOT NULL,
  `project_progress` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `account` varchar(100) NOT NULL,
  `reverence` text NOT NULL,
  `currency` text NOT NULL,
  `project_type` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_project`
--

INSERT INTO `fp_project` (`project_id`, `company_id`, `user_id`, `ref_no`, `project_title`, `start_date`, `deadline`, `project_description`, `rate_type`, `rate_value`, `project_progress`, `created_at`, `updated_at`, `account`, `reverence`, `currency`, `project_type`) VALUES
(2, 1, 18, '2', 'Test', '2016-05-13 14:01:53', '2016-10-05 16:00:00', 'Test', 'fixed', 12, 0, '2016-04-26 05:53:01', '2016-04-26 05:53:01', '123456', 'Test', 'USD', 'Standard'),
(5, 1, 18, '5', 'Jex Project Test 1', '2016-05-17 04:08:53', '2016-10-05 16:00:00', 'Test', 'fixed', 20, 0, '2016-05-16 20:08:53', '2016-05-16 20:08:53', '123456', '', 'USD', 'Hiring Assessment'),
(6, 15, 18, '6', 'Test 1', '2016-06-01 09:47:58', '0000-00-00 00:00:00', 'Test 1', '', 0, 0, '2016-05-16 23:45:08', '2016-05-16 23:45:08', '', '', '', 'Software Development'),
(8, 1, 18, '8', 'Test Project Jex 2', '2016-06-03 10:22:24', '2016-06-29 16:00:00', 'Test Project Jex 2', 'hourly', 12, 0, '2016-06-03 02:22:24', '2016-06-03 02:22:24', '1234', '', 'USD', ''),
(9, 1, 18, '9', 'Test Project Jex 3', '2016-06-03 10:24:29', '0000-00-00 00:00:00', 'Test Project Jex 3', 'fixed', 15, 0, '2016-06-03 02:24:29', '2016-06-03 02:24:29', '123', '', 'USD', 'Standard'),
(10, 1, 18, '10', 'Test Jex Project 4', '2016-06-03 10:25:22', '0000-00-00 00:00:00', 'Test Jex Project 4', 'hourly', 2, 0, '2016-06-03 02:25:22', '2016-06-03 02:25:22', '123', '', 'USD', 'Coding'),
(11, 1, 18, '11', 'Test Job Jex 5', '2016-06-03 10:43:38', '0000-00-00 00:00:00', 'Test Job Jex 5', '', 0, 0, '2016-06-03 02:43:38', '2016-06-03 02:43:38', '', '', '', 'Standard'),
(12, 18, 18, '12', 'Test Jex Project 6', '2016-06-03 11:38:07', '0000-00-00 00:00:00', 'Test Jex Project 6', '', 0, 0, '2016-06-03 03:38:07', '2016-06-03 03:38:07', '', '', '', 'Coding'),
(13, 1, 18, '13', 'Test Project 7', '2016-06-06 08:22:23', '0000-00-00 00:00:00', 'Test Project 7', '', 0, 0, '2016-06-06 00:22:23', '2016-06-06 00:22:23', '', '', '', 'Standard');

-- --------------------------------------------------------

--
-- Table structure for table `fp_question`
--

CREATE TABLE IF NOT EXISTS `fp_question` (
`id` int(10) unsigned NOT NULL,
  `test_id` int(11) NOT NULL,
  `question_type_id` int(11) NOT NULL,
  `question` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `question_choices` text COLLATE utf8_unicode_ci NOT NULL,
  `question_answer` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `length` time NOT NULL,
  `question_photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `score` int(11) NOT NULL,
  `order` double(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `points` double(8,2) NOT NULL,
  `explanation` text COLLATE utf8_unicode_ci NOT NULL,
  `marking_criteria` text COLLATE utf8_unicode_ci NOT NULL,
  `max_point` double(8,2) NOT NULL,
  `question_tags` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_question`
--

INSERT INTO `fp_question` (`id`, `test_id`, `question_type_id`, `question`, `question_choices`, `question_answer`, `length`, `question_photo`, `score`, `order`, `created_at`, `updated_at`, `points`, `explanation`, `marking_criteria`, `max_point`, `question_tags`) VALUES
(1, 1, 1, 'Test 2', '["a","b","c","d"]', '0', '00:10:00', '1.png', 0, 1.00, '2016-04-27 02:30:33', '2016-05-02 01:17:00', 0.00, '', '', 0.00, ''),
(2, 2, 1, 'Test', '["a","b","c","d"]', '2', '00:00:10', '', 0, 1.00, '2016-04-27 02:32:35', '2016-05-02 01:18:14', 0.00, '', '', 0.00, ''),
(3, 3, 1, 'Test', '["a","b","c","d"]', '2', '00:00:00', '', 0, 1.00, '2016-04-27 02:41:32', '2016-04-27 02:41:32', 0.00, '', '', 0.00, ''),
(4, 4, 1, 'Test', '["a","b","c","d"]', '2', '00:01:20', '', 0, 1.00, '2016-04-27 02:58:27', '2016-04-27 02:58:27', 0.00, '', '', 0.00, ''),
(5, 5, 1, 'Test', '["a","b","c","d"]', '3', '00:00:15', '', 0, 1.00, '2016-04-27 03:06:05', '2016-04-27 03:06:05', 0.00, '', '', 0.00, ''),
(6, 6, 1, 'Test 1', '["Test 1","Test 2","Test 3","Test 4","Test 5","Test 6"]', '0', '00:10:00', '', 0, 1.00, '2016-05-25 06:37:33', '2016-05-25 06:37:33', 1.00, '', '', 0.00, ''),
(7, 6, 1, 'Test 2', '["Test 1","Test 2","Test 3","Test 4"]', '2', '00:00:00', '', 0, 2.00, '2016-05-25 06:37:33', '2016-05-25 06:37:33', 1.00, '', '', 0.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `fp_question_feedback`
--

CREATE TABLE IF NOT EXISTS `fp_question_feedback` (
`id` int(10) unsigned NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `feedback` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_question_tag`
--

CREATE TABLE IF NOT EXISTS `fp_question_tag` (
`id` int(10) unsigned NOT NULL,
  `tag_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_question_type`
--

CREATE TABLE IF NOT EXISTS `fp_question_type` (
`id` int(10) unsigned NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_question_type`
--

INSERT INTO `fp_question_type` (`id`, `type`) VALUES
(1, 'Multiple Choice'),
(2, 'Fill in the Blank');

-- --------------------------------------------------------

--
-- Table structure for table `fp_roles`
--

CREATE TABLE IF NOT EXISTS `fp_roles` (
`id` int(10) unsigned NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `company_division_id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_roles`
--

INSERT INTO `fp_roles` (`id`, `company_id`, `company_division_id`, `name`, `slug`, `description`, `level`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Admin', 'admin', 'Administrator', 1, '2016-04-26 02:35:11', '2016-04-26 02:35:11'),
(2, 1, 1, 'Client', 'client', 'Clients', 3, '2016-04-26 02:35:11', '2016-04-26 02:35:11'),
(3, 1, 1, 'Staff', 'staff', 'The staff', 2, '2016-04-26 02:35:11', '2016-04-26 02:35:11'),
(7, 15, 8, 'Admin', 'admin-15', 'Administrator', 1, '2016-05-18 23:59:10', '2016-05-18 23:59:10'),
(8, 17, 0, 'Admin', 'admin-17', 'Administrator', 1, '2016-06-03 03:33:59', '2016-06-03 03:33:59'),
(9, 17, 0, 'Staff', 'staff-17', 'Staff', 2, '2016-06-03 03:33:59', '2016-06-03 03:33:59'),
(10, 17, 0, 'Client', 'client-17', 'Client', 3, '2016-06-03 03:33:59', '2016-06-03 03:33:59'),
(11, 18, 0, 'Admin', 'admin-18', 'Administrator', 1, '2016-06-03 03:36:14', '2016-06-03 03:36:14'),
(12, 18, 0, 'Staff', 'staff-18', 'Staff', 2, '2016-06-03 03:36:14', '2016-06-03 03:36:14'),
(13, 18, 0, 'Client', 'client-18', 'Client', 3, '2016-06-03 03:36:14', '2016-06-03 03:36:14'),
(14, 19, 0, 'Admin', 'admin-19', 'Administrator', 1, '2016-06-06 00:23:31', '2016-06-06 00:23:31'),
(15, 19, 0, 'Staff', 'staff-19', 'Staff', 2, '2016-06-06 00:23:32', '2016-06-06 00:23:32'),
(16, 19, 0, 'Client', 'client-19', 'Client', 3, '2016-06-06 00:23:32', '2016-06-06 00:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `fp_role_user`
--

CREATE TABLE IF NOT EXISTS `fp_role_user` (
`id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_role_user`
--

INSERT INTO `fp_role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(8, 1, 18, '2016-05-09 05:44:24', '2016-05-09 05:44:24'),
(9, 3, 19, '2016-06-09 01:34:01', '2016-06-10 00:18:23'),
(10, 1, 20, '2016-06-13 03:56:01', '2016-06-13 03:56:01');

-- --------------------------------------------------------

--
-- Table structure for table `fp_setting`
--

CREATE TABLE IF NOT EXISTS `fp_setting` (
`id` int(11) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `country_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `company_logo` varchar(100) DEFAULT NULL,
  `timezone_id` varchar(10) DEFAULT NULL,
  `default_currency` varchar(20) NOT NULL,
  `default_language` varchar(10) NOT NULL,
  `allowed_upload_file` text NOT NULL,
  `allowed_upload_max_size` int(11) NOT NULL,
  `default_tax` decimal(10,2) NOT NULL,
  `default_discount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_setting`
--

INSERT INTO `fp_setting` (`id`, `company_name`, `contact_person`, `address`, `city`, `state`, `zipcode`, `country_id`, `email`, `phone`, `company_logo`, `timezone_id`, `default_currency`, `default_language`, `allowed_upload_file`, `allowed_upload_max_size`, `default_tax`, `default_discount`, `created_at`, `updated_at`) VALUES
(1, 'Jobtc', 'admin', 'admin at admin building', 'davao', 'test', '1231', 185, 'admin@ab.com', '1212123456', NULL, '146', 'usd', 'en', 'txt,png,jpeg,jpg,zip,rar', 10, '0.00', '0.00', '2016-03-16 14:22:14', '2016-03-16 06:22:14');

-- --------------------------------------------------------

--
-- Table structure for table `fp_share_jobs`
--

CREATE TABLE IF NOT EXISTS `fp_share_jobs` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_share_jobs_companies`
--

CREATE TABLE IF NOT EXISTS `fp_share_jobs_companies` (
`id` int(10) unsigned NOT NULL,
  `company_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_share_jobs_companies`
--

INSERT INTO `fp_share_jobs_companies` (`id`, `company_id`, `job_id`, `created_at`, `updated_at`) VALUES
(7, 19, 10, '2016-06-16 03:55:08', '2016-06-16 03:55:08'),
(8, 19, 11, '2016-06-16 03:55:10', '2016-06-16 03:55:10');

-- --------------------------------------------------------

--
-- Table structure for table `fp_share_jobs_companies_permissions`
--

CREATE TABLE IF NOT EXISTS `fp_share_jobs_companies_permissions` (
`id` int(10) unsigned NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_share_jobs_companies_permissions`
--

INSERT INTO `fp_share_jobs_companies_permissions` (`id`, `company_id`, `user_id`, `job_id`, `created_at`, `updated_at`) VALUES
(3, 19, 20, 10, '2016-06-16 03:55:16', '2016-06-16 03:55:16');

-- --------------------------------------------------------

--
-- Table structure for table `fp_task`
--

CREATE TABLE IF NOT EXISTS `fp_task` (
`task_id` int(11) NOT NULL,
  `belongs_to` varchar(10) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `task_title` text NOT NULL,
  `task_description` text,
  `due_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_visible` enum('yes','no') NOT NULL,
  `task_status` enum('pending','progress','completed') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_task`
--

INSERT INTO `fp_task` (`task_id`, `belongs_to`, `unique_id`, `task_title`, `task_description`, `due_date`, `is_visible`, `task_status`, `created_at`, `updated_at`, `user_id`, `project_id`) VALUES
(6, 'project', 2, 'Test 4 Test', 'Test 4', '2016-05-17 04:01:19', 'yes', 'pending', '2016-04-27 23:59:51', '2016-04-29 03:02:50', 18, 2),
(19, 'project', 2, 'Test 2', 'Test 2', '2016-05-17 04:04:40', 'yes', 'pending', '2016-05-06 00:03:24', '2016-05-06 00:03:24', 34, 2),
(20, 'project', 4, 'Test Task', 'Test ', '2016-05-17 04:04:44', 'yes', 'pending', '2016-05-15 20:35:35', '2016-05-15 20:35:35', 38, 4),
(21, 'project', 3, 'Testing tasklist for Test 2', 'Test', '2016-05-17 04:04:47', 'yes', 'pending', '2016-05-16 04:50:36', '2016-05-16 04:50:36', 39, 3),
(22, 'project', 5, 'Test 1', 'Test', '2016-05-17 04:20:22', 'yes', 'pending', '2016-05-16 20:19:22', '2016-05-16 20:19:22', 18, 5),
(23, 'project', 5, 'Test 2', 'Test 2', '0000-00-00 00:00:00', 'yes', 'pending', '2016-05-16 20:20:34', '2016-05-16 20:20:34', 18, 5),
(24, 'project', 5, 'Test 3', 'Test 3', '0000-00-00 00:00:00', 'yes', 'pending', '2016-05-16 20:20:44', '2016-05-16 20:20:44', 18, 5),
(25, 'project', 5, '1', 'Test', '0000-00-00 00:00:00', 'yes', 'pending', '2016-05-16 20:22:32', '2016-05-16 20:22:32', 18, 5),
(28, 'project', 2, 'Test', 'Test', '0000-00-00 00:00:00', 'yes', 'pending', '2016-05-18 05:07:59', '2016-05-18 05:07:59', 18, 2),
(29, 'project', 6, 'Test', 'Test', '0000-00-00 00:00:00', 'yes', 'pending', '2016-05-18 05:20:10', '2016-05-18 05:20:10', 18, 6),
(30, 'project', 6, 'Test 2', 'Test', '0000-00-00 00:00:00', 'yes', 'pending', '2016-05-18 06:07:43', '2016-05-18 06:07:43', 18, 6),
(31, 'project', 6, 'Test 3', 'Test', '0000-00-00 00:00:00', 'yes', 'pending', '2016-05-18 06:19:16', '2016-05-18 06:19:16', 18, 6),
(32, 'project', 6, 'Test 4', 'Test', '0000-00-00 00:00:00', 'yes', 'pending', '2016-05-18 06:19:33', '2016-05-18 06:19:33', 18, 6),
(33, 'project', 7, 'Test', 'Test', '0000-00-00 00:00:00', 'yes', 'pending', '2016-06-01 01:16:20', '2016-06-01 01:16:20', 42, 7),
(34, 'project', 6, 'Test 5', 'Test 5', '0000-00-00 00:00:00', 'yes', 'pending', '2016-06-03 00:29:04', '2016-06-03 00:29:04', 18, 6),
(35, 'project', 11, 'Test', 'Test', '0000-00-00 00:00:00', 'yes', 'pending', '2016-06-03 02:44:11', '2016-06-03 02:44:11', 18, 11),
(36, 'project', 12, 'Test', 'Test', '0000-00-00 00:00:00', 'yes', 'pending', '2016-06-03 03:43:24', '2016-06-03 03:43:24', 18, 12),
(37, 'project', 9, 'Test', 'Test', '0000-00-00 00:00:00', 'yes', 'pending', '2016-06-10 00:20:19', '2016-06-10 00:20:19', 18, 9);

-- --------------------------------------------------------

--
-- Table structure for table `fp_task_check_list`
--

CREATE TABLE IF NOT EXISTS `fp_task_check_list` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `checklist_header` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'No Title',
  `checklist` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Default'
) ENGINE=InnoDB AUTO_INCREMENT=539 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_task_check_list`
--

INSERT INTO `fp_task_check_list` (`id`, `user_id`, `task_id`, `checklist_header`, `checklist`, `created_at`, `updated_at`, `status`) VALUES
(179, 0, 5, 'Test', 'Test', '2016-05-03 00:35:50', '2016-05-03 03:58:58', 'Default'),
(180, 0, 4, 'Test', 'Test 2', '2016-05-03 00:35:58', '2016-05-03 03:14:05', 'Default'),
(182, 0, 3, 'Test', 'Test 4', '2016-05-03 01:29:37', '2016-05-03 01:29:37', 'Default'),
(183, 0, 3, 'Test', 'Test 5', '2016-05-03 01:29:42', '2016-05-03 03:03:22', 'Default'),
(184, 0, 3, 'Test', 'Test 6', '2016-05-03 03:03:27', '2016-05-03 03:13:51', 'Default'),
(185, 0, 3, 'Test', 'Test 7', '2016-05-03 03:11:23', '2016-05-03 03:11:23', 'Default'),
(186, 0, 3, 'Test', 'Test 8', '2016-05-03 03:12:16', '2016-05-03 03:12:16', 'Default'),
(187, 0, 3, 'Test', 'Test 9', '2016-05-03 03:13:05', '2016-05-03 03:13:05', 'Default'),
(189, 0, 3, 'Test', 'Test', '2016-05-04 01:50:09', '2016-05-04 01:50:09', 'Default'),
(190, 0, 3, 'Test', 'Test 7', '2016-05-04 01:50:16', '2016-05-04 01:50:16', 'Default'),
(193, 0, 19, 'Test 7', '<p><strong>Intro</strong><br />\nMake changes to Best Practices or ask for clarification by asking a question in the task items. Success is when a person can commit to the server and restore the previous version without assistance using Putty.<br />\nProject management is on pm/project/1</p>\n', '2016-05-04 03:31:52', '2016-05-06 03:00:57', 'Ongoing'),
(194, 0, 14, 'Test', '<div><div><div>                                                    <div>                                                    <div>                                                    Test 4                                                </div>                                                </div>                                                </div></div></div>', '2016-05-04 03:49:06', '2016-05-04 06:03:24', 'Default'),
(222, 0, 15, 'Test 2', '<p>Testing</p><p>Testing</p>', '2016-05-04 05:18:57', '2016-05-04 08:21:45', 'Completed'),
(224, 0, 19, 'Test 12', 'Test', '2016-05-04 05:29:47', '2016-05-06 03:01:01', 'Ongoing'),
(225, 0, 18, 'Test 8', 'Test 9', '2016-05-05 00:51:05', '2016-05-08 22:16:50', 'Ongoing'),
(226, 0, 19, 'Test 9', 'Test 9', '2016-05-05 01:04:07', '2016-05-06 01:32:49', 'Ongoing'),
(241, 0, 18, 'Test 10', '<p>Test 10</p>\n', '2016-05-05 04:02:49', '2016-05-06 01:33:18', 'Ongoing'),
(243, 0, 28, 'Test 12', '<p>Test 12</p>\n', '2016-05-05 06:06:25', '2016-06-03 07:28:13', 'Ongoing'),
(244, 0, 19, 'Test 13', '<p>Test 13</p>\n', '2016-05-05 06:35:36', '2016-05-06 01:32:47', 'Ongoing'),
(247, 0, 18, 'Testing 3', 'Testing 3', '2016-05-06 01:25:45', '2016-05-10 03:22:15', 'Ongoing'),
(258, 0, 18, 'Testing 4', '<p>Testing 4</p>\n', '2016-05-10 03:21:39', '2016-05-10 03:22:18', 'Default'),
(259, 34, 19, 'Testing 5', '<p>Testing 5</p>\n', '2016-05-10 03:21:48', '2016-06-06 03:20:23', 'Ongoing'),
(260, 18, 6, 'Testing 6', '<p>Testing 6</p>\n', '2016-05-10 03:22:00', '2016-05-30 04:39:21', 'Default'),
(261, 34, 19, 'Testing 7', '<p>Testing 7</p>\n', '2016-05-10 04:22:25', '2016-06-06 08:20:12', 'Ongoing'),
(262, 34, 28, 'Testing 8', '<p>Testing 8</p>\n', '2016-05-10 06:01:49', '2016-06-08 09:04:40', 'Ongoing'),
(263, 34, 19, 'Testing 9', '<p>Testing 9</p>\n', '2016-05-10 09:38:14', '2016-06-06 00:14:00', 'Ongoing'),
(264, 34, 28, 'Testing 10', '<p>Testing 10</p>\n', '2016-05-10 09:42:40', '2016-06-08 09:04:34', 'Ongoing'),
(267, 0, 20, 'Test', '<p>Test</p>\n', '2016-05-16 03:30:35', '2016-05-16 03:30:35', 'Default'),
(269, 0, 20, 'Test 2', '<p>Test 2</p>\n', '2016-05-16 03:31:07', '2016-05-16 03:31:07', 'Default'),
(270, 0, 20, 'Test 3', '<p>Test 3</p>\n', '2016-05-16 03:31:24', '2016-05-16 03:31:41', 'Default'),
(271, 0, 20, 'Test 4', '<p>Test 4</p>\n', '2016-05-16 04:26:41', '2016-05-16 04:26:41', 'Default'),
(272, 0, 20, 'Test 5', '<p>Test 5</p>\n', '2016-05-16 04:27:04', '2016-05-16 04:27:04', 'Default'),
(273, 0, 20, 'Test 6', '<p>Test 6</p>\n', '2016-05-16 04:32:36', '2016-05-16 04:32:36', 'Default'),
(275, 0, 21, 'Test', '<p>Test</p>\n', '2016-05-16 04:50:45', '2016-05-16 04:50:45', 'Default'),
(277, 0, 21, 'Test', '<p>Test</p>\n', '2016-05-16 04:53:27', '2016-05-16 04:53:27', 'Default'),
(278, 18, 22, 'Test', '<p>Test</p>\n', '2016-05-17 02:57:39', '2016-06-06 05:35:53', 'Default'),
(279, 18, 23, 'Test', '<p>Test</p>\n', '2016-05-18 04:09:56', '2016-06-03 02:19:39', 'Default'),
(280, 18, 23, 'Test 1', '<p>Test 1</p>\n', '2016-05-18 04:19:36', '2016-06-03 02:20:06', 'Default'),
(281, 18, 6, 'Testing 11', '<p>Testing 11</p>\n', '2016-05-18 04:27:46', '2016-05-18 04:27:46', 'Default'),
(284, 18, 6, 'Testing 12', '<p>Testing 12</p>\n', '2016-05-18 04:54:11', '2016-05-18 04:54:11', 'Default'),
(285, 18, 6, 'Testing 14', '<p>Testing 14</p>\n', '2016-05-18 04:55:26', '2016-05-18 04:55:55', 'Default'),
(286, 18, 28, 'Test', '<p>Test</p>\n', '2016-05-18 05:11:29', '2016-05-18 05:11:29', 'Default'),
(287, 18, 28, 'Test', '<p>Test</p>\n', '2016-05-18 05:15:11', '2016-05-18 05:15:11', 'Default'),
(308, 18, 32, 'Test 1', '<p>Test 1</p>\n', '2016-05-18 06:19:43', '2016-05-18 06:19:43', 'Default'),
(309, 18, 32, 'Test 2', '<p>Test 2</p>\n', '2016-05-18 06:19:51', '2016-05-18 06:19:51', 'Default'),
(310, 18, 32, 'Test 3', '<p>Test 3</p>\n', '2016-05-18 06:19:59', '2016-05-18 06:19:59', 'Default'),
(311, 18, 32, 'Test 4', '<p>Test 4</p>\n', '2016-05-18 06:20:06', '2016-05-18 06:20:06', 'Default'),
(312, 18, 32, 'Test 5', '<p>Test 5</p>\n', '2016-05-18 06:20:17', '2016-05-18 06:20:17', 'Default'),
(313, 18, 32, 'Test 6', '<p>Test 6</p>\n', '2016-05-18 06:20:29', '2016-05-18 06:20:29', 'Default'),
(314, 18, 32, 'Test 7', '<p>Test 7</p>\n', '2016-05-18 06:20:38', '2016-05-18 06:20:38', 'Default'),
(315, 18, 32, 'Test 8', '', '2016-05-18 06:20:44', '2016-05-18 06:20:44', 'Default'),
(316, 18, 32, 'Test 9', '<p>Test 9</p>\n', '2016-05-18 06:20:51', '2016-05-18 06:20:51', 'Default'),
(317, 18, 32, 'Test 10', '', '2016-05-18 06:20:59', '2016-05-18 06:20:59', 'Default'),
(318, 18, 32, 'Test 11', '<p>Test 11</p>\n', '2016-05-18 06:21:07', '2016-05-18 06:21:07', 'Default'),
(319, 18, 32, 'Test 12', '<p>Test 12</p>\n', '2016-05-18 06:21:22', '2016-05-18 06:21:22', 'Default'),
(320, 18, 32, 'Test 13', '<p>Test 13</p>\n', '2016-05-18 06:21:35', '2016-05-18 06:21:35', 'Default'),
(321, 18, 32, 'Test 14', '', '2016-05-18 06:21:43', '2016-05-18 06:21:43', 'Default'),
(322, 18, 32, 'Test 15', '<p>Test 15</p>\n', '2016-05-18 06:22:00', '2016-05-18 06:22:00', 'Default'),
(323, 18, 32, 'Test 16', '<p>Test 16</p>\n', '2016-05-18 06:22:09', '2016-05-18 06:22:09', 'Default'),
(324, 18, 32, 'Test 17', '', '2016-05-18 06:23:35', '2016-05-18 06:23:35', 'Default'),
(325, 18, 32, 'Test 18', '<p>Test 18</p>\n', '2016-05-18 06:23:46', '2016-05-18 06:23:46', 'Default'),
(326, 18, 32, 'Test 19', '<p>Test 19</p>\n', '2016-05-18 06:24:05', '2016-05-18 06:24:05', 'Default'),
(327, 18, 32, 'Test 20', '<p>Test 20</p>\n', '2016-05-18 06:24:19', '2016-05-18 06:24:19', 'Default'),
(328, 18, 32, 'Test 21', '<p>Test 21</p>\n', '2016-05-18 06:24:38', '2016-05-18 06:24:38', 'Default'),
(329, 18, 32, 'Test 22', '<p>Test 22</p>\n', '2016-05-18 06:27:16', '2016-05-18 06:27:16', 'Default'),
(330, 18, 32, 'Test 23', '<p>Test 23</p>\n', '2016-05-18 06:28:05', '2016-05-18 06:28:05', 'Default'),
(331, 18, 32, 'Test 24', '<p>Test 24</p>\n', '2016-05-18 06:28:16', '2016-05-18 06:28:16', 'Default'),
(332, 18, 32, 'Test 25', '<p>Test 25</p>\n', '2016-05-18 06:28:28', '2016-05-18 06:28:28', 'Default'),
(345, 18, 29, 'Test 3', '<p>Test 3</p>\n', '2016-05-18 06:46:21', '2016-05-18 06:46:21', 'Default'),
(347, 18, 23, 'Testing', '<p>Test</p>\n', '2016-05-20 08:14:50', '2016-06-03 03:41:24', 'Default'),
(348, 18, 23, 'Test 1', '<p>Test 1</p>\n', '2016-05-26 03:36:26', '2016-06-03 03:41:15', 'Default'),
(349, 18, 22, 'Testing', '<p>Testing</p>\n', '2016-05-30 03:40:11', '2016-06-03 07:27:59', 'Default'),
(350, 18, 22, 'Test 1', '<p>Test 1</p>\n', '2016-05-30 04:30:21', '2016-06-10 07:15:27', 'Default'),
(351, 18, 6, 'Testing 12', '<p>Testing 12</p>\n', '2016-05-30 05:25:36', '2016-05-30 05:25:36', 'Default'),
(352, 18, 36, 'Testing', '<p>Testing</p>\n', '2016-06-06 02:21:46', '2016-06-06 02:22:00', 'Default'),
(377, 18, 22, 'Test 2', '<p>Test 2</p>\n', '2016-06-09 03:52:38', '2016-06-10 07:15:17', 'Default'),
(386, 18, 22, 'Test 3', '<p>Test 3</p>\n', '2016-06-09 04:07:37', '2016-06-10 07:15:13', 'Default'),
(436, 18, 28, 'Testing 9', '<p>Testing 9</p>\r\n', '2016-06-10 01:34:05', '2016-06-10 01:34:14', 'Default'),
(444, 18, 28, 'Test', '<p>Test</p>\r\n', '2016-06-10 01:51:50', '2016-06-10 01:51:55', 'Default'),
(445, 34, 19, 'Testing 9', '<p>Testing 9</p>\r\n', '2016-06-10 01:51:59', '2016-06-10 01:52:04', 'Default'),
(512, 18, 24, 'Test 1', '<iframe style="height: 800px;" id="spreadsheet_iframe" class="spreadsheet_iframe" src="https://job.tc:9000/task-spreadsheet-FASLy"></iframe>', '2016-06-10 07:16:33', '2016-06-10 07:16:46', 'Default'),
(520, 18, 24, 'Test 2', '<p><img height="181" src="http://localhost:8000/assets/ckeditor_uploaded_images/company_logo_2.jpg" width="278" /></p>\r\n', '2016-06-10 07:29:50', '2016-06-10 07:30:10', 'Default'),
(521, 18, 24, 'Test 3', '<p>Test 3<img height="110" src="http://localhost:8000/assets/ckeditor_uploaded_images/company_logo_3.png" width="459" /></p>\n', '2016-06-10 07:30:50', '2016-06-10 07:31:27', 'Default'),
(522, 18, 25, '', '<iframe style="height: 800px;" id="spreadsheet_iframe" class="spreadsheet_iframe" src="https://job.tc:9000/task-spreadsheet-k6MX8"></iframe>', '2016-06-10 07:44:45', '2016-06-10 07:45:28', 'Default'),
(523, 18, 25, 'Test 2', '<p>Test 2</p>\r\n', '2016-06-10 07:45:20', '2016-06-10 07:45:27', 'Default'),
(524, 18, 25, 'Test 3', '<p>Test 3</p>\r\n', '2016-06-10 07:45:43', '2016-06-10 07:45:49', 'Default'),
(525, 18, 25, 'Test 4', '<p>Test 4</p>\r\n', '2016-06-10 07:45:51', '2016-06-10 07:45:58', 'Default'),
(526, 18, 24, 'Test 4', '<p>Test 4</p>\r\n', '2016-06-14 04:22:58', '2016-06-14 04:23:03', 'Default'),
(529, 18, 6, 'Testing 13', '<p>Testing 13</p>\r\n', '2016-06-14 04:24:46', '2016-06-14 04:24:53', 'Default'),
(530, 18, 6, 'Testing 14', '<p>Testing 14</p>\r\n', '2016-06-14 04:25:08', '2016-06-14 04:25:24', 'Default'),
(535, 18, 24, 'Test 5', '<p>Test 5</p>\r\n', '2016-06-17 02:05:09', '2016-06-17 02:05:15', 'Default'),
(538, 18, 6, 'Testing 15', '<p>Testing 15</p>\r\n', '2016-06-17 02:42:36', '2016-06-17 02:42:45', 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `fp_task_check_list_order`
--

CREATE TABLE IF NOT EXISTS `fp_task_check_list_order` (
`id` int(10) unsigned NOT NULL,
  `task_id` bigint(20) NOT NULL,
  `task_id_order` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=385 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_task_check_list_order`
--

INSERT INTO `fp_task_check_list_order` (`id`, `task_id`, `task_id_order`, `created_at`, `updated_at`) VALUES
(365, 6, '260,284,281,285,351,448,527,528,529,530,530,530,531,531,532,538,531,532,533,534,536,537,538,538', '2016-06-08 03:04:44', '2016-06-17 02:42:46'),
(371, 19, '193,224,226,244,263,259,261,445,445', '2016-06-08 09:04:40', '2016-06-10 01:52:05'),
(377, 28, '286,287,243,264,262,436,444,446,447', '2016-06-10 01:52:22', '2016-06-10 02:34:28'),
(381, 23, '347,279,348,280', '2016-06-10 07:15:16', '2016-06-10 07:15:16'),
(383, 22, '278,350,377,386,349', '2016-06-10 07:15:17', '2016-06-10 07:15:17'),
(384, 24, '512,520,521,521,526,526,533,533,534,533,535,535,535', '2016-06-10 07:24:54', '2016-06-17 02:05:16');

-- --------------------------------------------------------

--
-- Table structure for table `fp_task_check_list_permissions`
--

CREATE TABLE IF NOT EXISTS `fp_task_check_list_permissions` (
`id` int(10) unsigned NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_task_check_list_permissions`
--

INSERT INTO `fp_task_check_list_permissions` (`id`, `task_id`, `user_id`, `project_id`, `created_at`, `updated_at`) VALUES
(1, 22, 42, 5, '2016-05-27 00:22:27', '2016-05-27 00:22:27'),
(3, 24, 54, 5, '2016-05-27 06:04:19', '2016-05-27 06:04:19'),
(6, 25, 59, 5, '2016-06-01 07:46:36', '2016-06-01 07:46:36'),
(7, 22, 59, 5, '2016-06-01 07:46:37', '2016-06-01 07:46:37'),
(8, 23, 60, 5, '2016-06-01 07:49:19', '2016-06-01 07:49:19'),
(9, 25, 61, 5, '2016-06-01 07:58:16', '2016-06-01 07:58:16'),
(10, 22, 61, 5, '2016-06-01 07:58:16', '2016-06-01 07:58:16'),
(11, 23, 61, 5, '2016-06-01 07:58:17', '2016-06-01 07:58:17'),
(12, 24, 61, 5, '2016-06-01 07:58:17', '2016-06-01 07:58:17'),
(13, 23, 42, 5, '2016-06-01 23:07:40', '2016-06-01 23:07:40'),
(14, 24, 42, 5, '2016-06-01 23:08:15', '2016-06-01 23:08:15'),
(19, 25, 87, 5, '2016-06-03 02:09:57', '2016-06-03 02:09:57'),
(20, 22, 87, 5, '2016-06-03 02:09:57', '2016-06-03 02:09:57');

-- --------------------------------------------------------

--
-- Table structure for table `fp_task_comment`
--

CREATE TABLE IF NOT EXISTS `fp_task_comment` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_task_timer`
--

CREATE TABLE IF NOT EXISTS `fp_task_timer` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_task_timer`
--

INSERT INTO `fp_task_timer` (`id`, `user_id`, `task_id`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(1, 0, 2, '2016-04-26 21:12:08', '2016-04-26 21:12:30', '2016-04-26 05:12:09', '2016-04-26 05:12:30'),
(2, 0, 2, '2016-04-26 21:12:29', '2016-04-26 21:12:40', '2016-04-26 05:12:29', '2016-04-26 05:12:40'),
(5, 0, 3, '2016-04-27 19:58:52', '2016-04-27 19:59:05', '2016-04-27 03:58:52', '2016-04-27 03:59:06'),
(6, 0, 3, '2016-04-27 22:00:50', '2016-04-27 22:01:41', '2016-04-27 06:00:51', '2016-04-27 06:01:41'),
(7, 0, 3, '2016-04-27 22:02:14', '2016-04-27 22:02:19', '2016-04-27 06:02:14', '2016-04-27 06:02:20'),
(8, 0, 3, '2016-04-27 22:09:24', '2016-04-27 22:09:34', '2016-04-27 06:09:24', '2016-04-27 06:09:35'),
(10, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2016-05-02 03:19:25', '2016-05-02 03:19:25'),
(27, 0, 6, '0000-00-00 00:00:00', '2016-05-05 00:14:57', '2016-05-02 04:38:21', '2016-05-04 08:14:57'),
(28, 0, 6, '0000-00-00 00:00:00', '2016-05-05 00:15:04', '2016-05-02 04:46:05', '2016-05-04 08:15:04'),
(29, 0, 6, '2016-05-05 00:15:05', '2016-05-05 00:15:07', '2016-05-04 08:15:05', '2016-05-04 08:15:07'),
(30, 0, 6, '0000-00-00 00:00:00', '2016-05-05 21:46:19', '2016-05-05 01:33:15', '2016-05-05 05:46:19'),
(31, 18, 24, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2016-05-20 00:58:51', '2016-05-20 00:58:51'),
(32, 34, 19, '2016-06-01 17:41:51', '2016-06-01 17:41:53', '2016-06-01 01:41:52', '2016-06-01 01:41:53'),
(33, 34, 19, '2016-06-01 17:41:55', '2016-06-01 17:41:59', '2016-06-01 01:41:55', '2016-06-01 01:41:59'),
(34, 18, 24, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2016-06-10 04:39:05', '2016-06-10 04:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `fp_team`
--

CREATE TABLE IF NOT EXISTS `fp_team` (
`id` int(10) unsigned NOT NULL,
  `project_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_team`
--

INSERT INTO `fp_team` (`id`, `project_id`, `created_at`, `updated_at`) VALUES
(14, 12, '2016-06-03 06:59:47', '2016-06-03 06:59:47'),
(15, 5, '2016-06-06 06:13:23', '2016-06-06 06:13:23'),
(16, 2, '2016-06-06 06:19:05', '2016-06-06 06:19:05'),
(17, 8, '2016-06-09 23:49:07', '2016-06-09 23:49:07'),
(18, 9, '2016-06-10 00:20:04', '2016-06-10 00:20:04');

-- --------------------------------------------------------

--
-- Table structure for table `fp_team_companies`
--

CREATE TABLE IF NOT EXISTS `fp_team_companies` (
`id` int(10) unsigned NOT NULL,
  `project_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_team_member`
--

CREATE TABLE IF NOT EXISTS `fp_team_member` (
`id` int(10) unsigned NOT NULL,
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_team_project`
--

CREATE TABLE IF NOT EXISTS `fp_team_project` (
`id` int(10) unsigned NOT NULL,
  `team_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_team_project`
--

INSERT INTO `fp_team_project` (`id`, `team_id`, `project_id`, `created_at`, `updated_at`) VALUES
(13, 14, 12, '2016-06-03 06:59:47', '2016-06-03 06:59:47'),
(14, 15, 5, '2016-06-06 06:13:23', '2016-06-06 06:13:23'),
(15, 16, 2, '2016-06-06 06:19:05', '2016-06-06 06:19:05'),
(16, 17, 8, '2016-06-09 23:49:07', '2016-06-09 23:49:07'),
(17, 18, 9, '2016-06-10 00:20:05', '2016-06-10 00:20:05');

-- --------------------------------------------------------

--
-- Table structure for table `fp_template`
--

CREATE TABLE IF NOT EXISTS `fp_template` (
`template_id` int(11) NOT NULL,
  `template_name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `template_subject` text CHARACTER SET latin1 NOT NULL,
  `template_content` text CHARACTER SET latin1 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fp_test`
--

CREATE TABLE IF NOT EXISTS `fp_test` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `length` time NOT NULL,
  `version` double(8,2) NOT NULL,
  `average_score` double(8,2) NOT NULL,
  `test_photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completion_message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `order` double(8,2) NOT NULL,
  `default_time` time NOT NULL,
  `completion_image` text COLLATE utf8_unicode_ci NOT NULL,
  `completion_sound` text COLLATE utf8_unicode_ci NOT NULL,
  `default_tags` text COLLATE utf8_unicode_ci NOT NULL,
  `default_points` double(8,2) NOT NULL DEFAULT '1.00'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_test`
--

INSERT INTO `fp_test` (`id`, `user_id`, `title`, `description`, `length`, `version`, `average_score`, `test_photo`, `start_message`, `completion_message`, `created_at`, `updated_at`, `order`, `default_time`, `completion_image`, `completion_sound`, `default_tags`, `default_points`) VALUES
(1, 18, 'Test', 'Test', '00:00:00', 0.00, 0.00, '', 'Test', 'Test', '2016-04-27 02:30:33', '2016-05-17 05:13:41', 0.00, '00:00:00', '', '', '', 1.00),
(2, 18, 'Test 2', 'Test 2', '00:00:00', 0.00, 0.00, '', 'Test 2', 'Test 2', '2016-04-27 02:32:35', '2016-04-27 02:32:35', 0.00, '00:00:00', '', '', '', 1.00),
(3, 18, 'Test 3', 'Test 3', '00:00:00', 0.00, 0.00, '', 'Test 3', 'Test 3', '2016-04-27 02:41:32', '2016-04-27 02:41:32', 0.00, '00:00:00', '', '', '', 1.00),
(4, 18, 'Test 4', 'Test 4', '00:00:00', 0.00, 0.00, '4.png', 'Test 4', 'Test 4', '2016-04-27 02:58:27', '2016-04-27 02:58:27', 0.00, '00:00:00', '', '', '', 1.00),
(5, 18, 'Test 5', 'Test 5', '00:00:00', 0.00, 0.00, '5.jpg', 'Test 5', 'Test 5', '2016-04-27 03:06:05', '2016-04-27 03:06:05', 0.00, '00:00:00', '', '', '', 1.00),
(6, 18, 'Test 6', 'Testing the Quiz', '00:00:00', 0.00, 0.00, '', 'Test Intro', 'Congratulations!', '2016-05-25 06:37:33', '2016-05-25 06:37:33', 0.00, '00:00:00', '', '', '', 1.00);

-- --------------------------------------------------------

--
-- Table structure for table `fp_test_completed`
--

CREATE TABLE IF NOT EXISTS `fp_test_completed` (
`id` int(10) unsigned NOT NULL,
  `test_id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `belongs_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `score` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_score` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_test_completed`
--

INSERT INTO `fp_test_completed` (`id`, `test_id`, `unique_id`, `belongs_to`, `score`, `total_score`, `created_at`, `updated_at`) VALUES
(1, 5, 9, 'applicant', '1', '1', '2016-06-07 02:55:58', '2016-06-07 02:55:58'),
(2, 6, 9, 'applicant', '1', '2', '2016-06-07 03:14:24', '2016-06-07 03:14:24'),
(28, 5, 8, 'applicant', '1', '1', '2016-06-07 06:18:17', '2016-06-07 06:18:17'),
(29, 6, 8, 'applicant', '1', '2', '2016-06-07 06:19:09', '2016-06-07 06:19:09'),
(30, 5, 7, 'applicant', '1', '1', '2016-06-08 01:06:45', '2016-06-08 01:06:45'),
(38, 6, 7, 'applicant', '2', '2', '2016-06-08 02:07:49', '2016-06-08 02:07:49');

-- --------------------------------------------------------

--
-- Table structure for table `fp_test_feedback`
--

CREATE TABLE IF NOT EXISTS `fp_test_feedback` (
`id` int(10) unsigned NOT NULL,
  `test_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `feedback` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_test_per_applicant`
--

CREATE TABLE IF NOT EXISTS `fp_test_per_applicant` (
`id` int(10) unsigned NOT NULL,
  `test_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_test_per_applicant`
--

INSERT INTO `fp_test_per_applicant` (`id`, `test_id`, `applicant_id`, `created_at`, `updated_at`) VALUES
(1, 6, 4, '2016-06-03 02:12:28', '2016-06-03 02:12:28');

-- --------------------------------------------------------

--
-- Table structure for table `fp_test_per_job`
--

CREATE TABLE IF NOT EXISTS `fp_test_per_job` (
`id` int(10) unsigned NOT NULL,
  `test_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_test_per_job`
--

INSERT INTO `fp_test_per_job` (`id`, `test_id`, `job_id`, `created_at`, `updated_at`) VALUES
(1, 6, 10, '2016-06-06 06:41:43', '2016-06-06 06:41:43'),
(2, 5, 10, '2016-06-07 00:10:37', '2016-06-07 00:10:37');

-- --------------------------------------------------------

--
-- Table structure for table `fp_test_question_tag`
--

CREATE TABLE IF NOT EXISTS `fp_test_question_tag` (
`id` int(10) unsigned NOT NULL,
  `tag` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_test_result`
--

CREATE TABLE IF NOT EXISTS `fp_test_result` (
`id` int(10) unsigned NOT NULL,
  `test_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `belongs_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer` text COLLATE utf8_unicode_ci NOT NULL,
  `result` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `points` double(8,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_test_result`
--

INSERT INTO `fp_test_result` (`id`, `test_id`, `question_id`, `unique_id`, `belongs_to`, `answer`, `result`, `created_at`, `updated_at`, `points`) VALUES
(44, 5, 5, 9, 'applicant', '3', 1, '2016-06-07 02:55:57', '2016-06-07 02:55:57', 0.00),
(45, 6, 6, 9, 'applicant', '4', 0, '2016-06-07 03:14:20', '2016-06-07 03:14:20', 0.00),
(46, 6, 7, 9, 'applicant', '2', 1, '2016-06-07 03:14:22', '2016-06-07 03:14:22', 0.00),
(52, 6, 6, 18, 'employee', '5', 0, '2016-06-07 04:53:45', '2016-06-07 04:53:45', 0.00),
(53, 6, 7, 18, 'employee', '3', 0, '2016-06-07 04:53:46', '2016-06-07 04:53:46', 0.00),
(77, 5, 5, 8, 'applicant', '3', 1, '2016-06-07 06:18:16', '2016-06-07 06:18:16', 0.00),
(78, 6, 6, 8, 'applicant', '4', 0, '2016-06-07 06:19:07', '2016-06-07 06:19:07', 0.00),
(79, 6, 7, 8, 'applicant', '2', 1, '2016-06-07 06:19:08', '2016-06-07 06:19:08', 0.00),
(80, 5, 5, 7, 'applicant', '3', 1, '2016-06-08 01:06:44', '2016-06-08 01:06:44', 0.00),
(95, 6, 6, 7, 'applicant', '0', 1, '2016-06-08 02:07:46', '2016-06-08 02:07:46', 0.00),
(96, 6, 7, 7, 'applicant', '2', 1, '2016-06-08 02:07:48', '2016-06-08 02:07:48', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `fp_test_tag`
--

CREATE TABLE IF NOT EXISTS `fp_test_tag` (
`id` int(10) unsigned NOT NULL,
  `tag_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_ticket`
--

CREATE TABLE IF NOT EXISTS `fp_ticket` (
`ticket_id` int(11) NOT NULL,
  `ticket_subject` varchar(500) NOT NULL,
  `ticket_description` text,
  `ticket_priority` enum('low','medium','high','critical') NOT NULL,
  `file` varchar(100) DEFAULT NULL,
  `ticket_status` enum('open','close') NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` tinytext NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_ticket`
--

INSERT INTO `fp_ticket` (`ticket_id`, `ticket_subject`, `ticket_description`, `ticket_priority`, `file`, `ticket_status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'test12', 'trest test', 'low', NULL, 'open', 0, '2016-03-16 13:58:41', '2016-03-16 05:58:41'),
(2, 'error for roles', 'please fixed it asap.', 'high', NULL, 'open', 0, '2016-03-17 08:22:07', '2016-03-17 00:22:07');

-- --------------------------------------------------------

--
-- Table structure for table `fp_ticketit`
--

CREATE TABLE IF NOT EXISTS `fp_ticketit` (
`id` int(10) unsigned NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `html` longtext COLLATE utf8_unicode_ci,
  `status_id` int(10) unsigned NOT NULL,
  `priority_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `agent_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_ticketit_audits`
--

CREATE TABLE IF NOT EXISTS `fp_ticketit_audits` (
`id` int(10) unsigned NOT NULL,
  `operation` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `ticket_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_ticketit_categories`
--

CREATE TABLE IF NOT EXISTS `fp_ticketit_categories` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_ticketit_categories_users`
--

CREATE TABLE IF NOT EXISTS `fp_ticketit_categories_users` (
  `category_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_ticketit_comments`
--

CREATE TABLE IF NOT EXISTS `fp_ticketit_comments` (
`id` int(10) unsigned NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `html` longtext COLLATE utf8_unicode_ci,
  `user_id` int(10) unsigned NOT NULL,
  `ticket_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_ticketit_priorities`
--

CREATE TABLE IF NOT EXISTS `fp_ticketit_priorities` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_ticketit_settings`
--

CREATE TABLE IF NOT EXISTS `fp_ticketit_settings` (
`id` int(10) unsigned NOT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `default` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_ticketit_settings`
--

INSERT INTO `fp_ticketit_settings` (`id`, `lang`, `slug`, `value`, `default`, `created_at`, `updated_at`) VALUES
(1, NULL, 'main_route', 'tickets', 'tickets', '2016-05-17 19:42:19', '2016-05-17 19:42:19'),
(2, NULL, 'main_route_path', 'tickets', 'tickets', '2016-05-17 19:42:19', '2016-05-17 19:42:19'),
(3, NULL, 'admin_route', 'tickets-admin', 'tickets-admin', '2016-05-17 19:42:19', '2016-05-17 19:42:19'),
(4, NULL, 'admin_route_path', 'tickets-admin', 'tickets-admin', '2016-05-17 19:42:19', '2016-05-17 19:42:19'),
(5, NULL, 'master_template', 'master', 'master', '2016-05-17 19:42:19', '2016-05-17 19:42:19'),
(6, NULL, 'email.template', 'ticketit::emails.templates.ticketit', 'ticketit::emails.templates.ticketit', '2016-05-17 19:42:19', '2016-05-17 19:42:19'),
(7, NULL, 'email.header', 'Ticket Update', 'Ticket Update', '2016-05-17 19:42:19', '2016-05-17 19:42:19'),
(8, NULL, 'email.signoff', 'Thank you for your patience!', 'Thank you for your patience!', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(9, NULL, 'email.signature', 'Your friends', 'Your friends', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(10, NULL, 'email.dashboard', 'My Dashboard', 'My Dashboard', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(11, NULL, 'email.google_plus_link', '#', '#', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(12, NULL, 'email.facebook_link', '#', '#', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(13, NULL, 'email.twitter_link', '#', '#', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(14, NULL, 'email.footer', 'Powered by Ticketit', 'Powered by Ticketit', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(15, NULL, 'email.footer_link', 'https://github.com/thekordy/ticketit', 'https://github.com/thekordy/ticketit', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(16, NULL, 'email.color_body_bg', '#FFFFFF', '#FFFFFF', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(17, NULL, 'email.color_header_bg', '#44B7B7', '#44B7B7', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(18, NULL, 'email.color_content_bg', '#F46B45', '#F46B45', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(19, NULL, 'email.color_footer_bg', '#414141', '#414141', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(20, NULL, 'email.color_button_bg', '#AC4D2F', '#AC4D2F', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(21, NULL, 'default_status_id', '1', '1', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(22, NULL, 'default_close_status_id', '0', '0', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(23, NULL, 'default_reopen_status_id', '0', '0', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(24, NULL, 'paginate_items', '10', '10', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(25, NULL, 'length_menu', 'a:2:{i:0;a:3:{i:0;i:10;i:1;i:50;i:2;i:100;}i:1;a:3:{i:0;i:10;i:1;i:50;i:2;i:100;}}', 'a:2:{i:0;a:3:{i:0;i:10;i:1;i:50;i:2;i:100;}i:1;a:3:{i:0;i:10;i:1;i:50;i:2;i:100;}}', '2016-05-17 19:42:20', '2016-05-17 19:42:20'),
(26, NULL, 'status_notification', '1', '1', '2016-05-17 19:42:21', '2016-05-17 19:42:21'),
(27, NULL, 'comment_notification', '1', '1', '2016-05-17 19:42:21', '2016-05-17 19:42:21'),
(28, NULL, 'queue_emails', '0', '0', '2016-05-17 19:42:21', '2016-05-17 19:42:21'),
(29, NULL, 'assigned_notification', '1', '1', '2016-05-17 19:42:21', '2016-05-17 19:42:21'),
(30, NULL, 'agent_restrict', '0', '0', '2016-05-17 19:42:21', '2016-05-17 19:42:21'),
(31, NULL, 'close_ticket_perm', 'a:3:{s:5:"owner";b:1;s:5:"agent";b:1;s:5:"admin";b:1;}', 'a:3:{s:5:"owner";b:1;s:5:"agent";b:1;s:5:"admin";b:1;}', '2016-05-17 19:42:21', '2016-05-17 19:42:21'),
(32, NULL, 'reopen_ticket_perm', 'a:3:{s:5:"owner";b:1;s:5:"agent";b:1;s:5:"admin";b:1;}', 'a:3:{s:5:"owner";b:1;s:5:"agent";b:1;s:5:"admin";b:1;}', '2016-05-17 19:42:21', '2016-05-17 19:42:21'),
(33, NULL, 'delete_modal_type', 'builtin', 'builtin', '2016-05-17 19:42:21', '2016-05-17 19:42:21'),
(34, NULL, 'editor_enabled', '1', '1', '2016-05-17 19:42:21', '2016-05-17 19:42:21'),
(35, NULL, 'include_font_awesome', '1', '1', '2016-05-17 19:42:21', '2016-05-17 19:42:21'),
(36, NULL, 'summernote_locale', 'en', 'en', '2016-05-17 19:42:21', '2016-05-17 19:42:21'),
(37, NULL, 'editor_html_highlighter', '1', '1', '2016-05-17 19:42:21', '2016-05-17 19:42:21'),
(38, NULL, 'codemirror_theme', 'monokai', 'monokai', '2016-05-17 19:42:21', '2016-05-17 19:42:21'),
(39, NULL, 'summernote_options_json_file', 'vendor/kordy/ticketit/src/JSON/summernote_init.json', 'vendor/kordy/ticketit/src/JSON/summernote_init.json', '2016-05-17 19:42:21', '2016-05-17 19:42:21'),
(40, NULL, 'purifier_config', 'a:3:{s:15:"HTML.SafeIframe";s:4:"true";s:20:"URI.SafeIframeRegexp";s:72:"%^(http://|https://|//)(www.youtube.com/embed/|player.vimeo.com/video/)%";s:18:"URI.AllowedSchemes";a:5:{s:4:"data";b:1;s:4:"http";b:1;s:5:"https";b:1;s:6:"mailto";b:1;s:3:"ftp";b:1;}}', 'a:3:{s:15:"HTML.SafeIframe";s:4:"true";s:20:"URI.SafeIframeRegexp";s:72:"%^(http://|https://|//)(www.youtube.com/embed/|player.vimeo.com/video/)%";s:18:"URI.AllowedSchemes";a:5:{s:4:"data";b:1;s:4:"http";b:1;s:5:"https";b:1;s:6:"mailto";b:1;s:3:"ftp";b:1;}}', '2016-05-17 19:42:21', '2016-05-17 19:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `fp_ticketit_statuses`
--

CREATE TABLE IF NOT EXISTS `fp_ticketit_statuses` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_timer`
--

CREATE TABLE IF NOT EXISTS `fp_timer` (
`timer_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `project_id` int(11) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fp_timezone`
--

CREATE TABLE IF NOT EXISTS `fp_timezone` (
`timezone_id` int(11) NOT NULL,
  `timezone_name` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=420 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_timezone`
--

INSERT INTO `fp_timezone` (`timezone_id`, `timezone_name`) VALUES
(1, 'Africa/Abidjan'),
(2, 'Africa/Accra'),
(3, 'Africa/Addis_Ababa'),
(4, 'Africa/Algiers'),
(5, 'Africa/Asmara'),
(6, 'Africa/Asmera'),
(7, 'Africa/Bamako'),
(8, 'Africa/Bangui'),
(9, 'Africa/Banjul'),
(10, 'Africa/Bissau'),
(11, 'Africa/Blantyre'),
(12, 'Africa/Brazzaville'),
(13, 'Africa/Bujumbura'),
(14, 'Africa/Cairo'),
(15, 'Africa/Casablanca'),
(16, 'Africa/Ceuta'),
(17, 'Africa/Conakry'),
(18, 'Africa/Dakar'),
(19, 'Africa/Dar_es_Salaam'),
(20, 'Africa/Djibouti'),
(21, 'Africa/Douala'),
(22, 'Africa/El_Aaiun'),
(23, 'Africa/Freetown'),
(24, 'Africa/Gaborone'),
(25, 'Africa/Harare'),
(26, 'Africa/Johannesburg'),
(27, 'Africa/Juba'),
(28, 'Africa/Kampala'),
(29, 'Africa/Khartoum'),
(30, 'Africa/Kigali'),
(31, 'Africa/Kinshasa'),
(32, 'Africa/Lagos'),
(33, 'Africa/Libreville'),
(34, 'Africa/Lome'),
(35, 'Africa/Luanda'),
(36, 'Africa/Lubumbashi'),
(37, 'Africa/Lusaka'),
(38, 'Africa/Malabo'),
(39, 'Africa/Maputo'),
(40, 'Africa/Maseru'),
(41, 'Africa/Mbabane'),
(42, 'Africa/Mogadishu'),
(43, 'Africa/Monrovia'),
(44, 'Africa/Nairobi'),
(45, 'Africa/Ndjamena'),
(46, 'Africa/Niamey'),
(47, 'Africa/Nouakchott'),
(48, 'Africa/Ouagadougou'),
(49, 'Africa/Porto-Novo'),
(50, 'Africa/Sao_Tome'),
(51, 'Africa/Timbuktu'),
(52, 'Africa/Tripoli'),
(53, 'Africa/Tunis'),
(54, 'Africa/Windhoek'),
(55, 'America/Adak'),
(56, 'America/Anchorage'),
(57, 'America/Anguilla'),
(58, 'America/Antigua'),
(59, 'America/Araguaina'),
(60, 'America/Argentina/Buenos_Aires'),
(61, 'America/Argentina/Catamarca'),
(62, 'America/Argentina/ComodRivadavia'),
(63, 'America/Argentina/Cordoba'),
(64, 'America/Argentina/Jujuy'),
(65, 'America/Argentina/La_Rioja'),
(66, 'America/Argentina/Mendoza'),
(67, 'America/Argentina/Rio_Gallegos'),
(68, 'America/Argentina/Salta'),
(69, 'America/Argentina/San_Juan'),
(70, 'America/Argentina/San_Luis'),
(71, 'America/Argentina/Tucuman'),
(72, 'America/Argentina/Ushuaia'),
(73, 'America/Aruba'),
(74, 'America/Asuncion'),
(75, 'America/Atikokan'),
(76, 'America/Atka'),
(77, 'America/Bahia'),
(78, 'America/Bahia_Banderas'),
(79, 'America/Barbados'),
(80, 'America/Belem'),
(81, 'America/Belize'),
(82, 'America/Blanc-Sablon'),
(83, 'America/Boa_Vista'),
(84, 'America/Bogota'),
(85, 'America/Boise'),
(86, 'America/Buenos_Aires'),
(87, 'America/Cambridge_Bay'),
(88, 'America/Campo_Grande'),
(89, 'America/Cancun'),
(90, 'America/Caracas'),
(91, 'America/Catamarca'),
(92, 'America/Cayenne'),
(93, 'America/Cayman'),
(94, 'America/Chicago'),
(95, 'America/Chihuahua'),
(96, 'America/Coral_Harbour'),
(97, 'America/Cordoba'),
(98, 'America/Costa_Rica'),
(99, 'America/Creston'),
(100, 'America/Cuiaba'),
(101, 'America/Curacao'),
(102, 'America/Danmarkshavn'),
(103, 'America/Dawson'),
(104, 'America/Dawson_Creek'),
(105, 'America/Denver'),
(106, 'America/Detroit'),
(107, 'America/Dominica'),
(108, 'America/Edmonton'),
(109, 'America/Eirunepe'),
(110, 'America/El_Salvador'),
(111, 'America/Ensenada'),
(112, 'America/Fort_Wayne'),
(113, 'America/Fortaleza'),
(114, 'America/Glace_Bay'),
(115, 'America/Godthab'),
(116, 'America/Goose_Bay'),
(117, 'America/Grand_Turk'),
(118, 'America/Grenada'),
(119, 'America/Guadeloupe'),
(120, 'America/Guatemala'),
(121, 'America/Guayaquil'),
(122, 'America/Guyana'),
(123, 'America/Halifax'),
(124, 'America/Havana'),
(125, 'America/Hermosillo'),
(126, 'America/Indiana/Indianapolis'),
(127, 'America/Indiana/Knox'),
(128, 'America/Indiana/Marengo'),
(129, 'America/Indiana/Petersburg'),
(130, 'America/Indiana/Tell_City'),
(131, 'America/Indiana/Vevay'),
(132, 'America/Indiana/Vincennes'),
(133, 'America/Indiana/Winamac'),
(134, 'America/Indianapolis'),
(135, 'America/Inuvik'),
(136, 'America/Iqaluit'),
(137, 'America/Jamaica'),
(138, 'America/Jujuy'),
(139, 'America/Juneau'),
(140, 'America/Kentucky/Louisville'),
(141, 'America/Kentucky/Monticello'),
(142, 'America/Knox_IN'),
(143, 'America/Kralendijk'),
(144, 'America/La_Paz'),
(145, 'America/Lima'),
(146, 'America/Los_Angeles'),
(147, 'America/Louisville'),
(148, 'America/Lower_Princes'),
(149, 'America/Maceio'),
(150, 'America/Managua'),
(151, 'America/Manaus'),
(152, 'America/Marigot'),
(153, 'America/Martinique'),
(154, 'America/Matamoros'),
(155, 'America/Mazatlan'),
(156, 'America/Mendoza'),
(157, 'America/Menominee'),
(158, 'America/Merida'),
(159, 'America/Metlakatla'),
(160, 'America/Mexico_City'),
(161, 'America/Miquelon'),
(162, 'America/Moncton'),
(163, 'America/Monterrey'),
(164, 'America/Montevideo'),
(165, 'America/Montreal'),
(166, 'America/Montserrat'),
(167, 'America/Nassau'),
(168, 'America/New_York'),
(169, 'America/Nipigon'),
(170, 'America/Nome'),
(171, 'America/Noronha'),
(172, 'America/North_Dakota/Beulah'),
(173, 'America/North_Dakota/Center'),
(174, 'America/North_Dakota/New_Salem'),
(175, 'America/Ojinaga'),
(176, 'America/Panama'),
(177, 'America/Pangnirtung'),
(178, 'America/Paramaribo'),
(179, 'America/Phoenix'),
(180, 'America/Port_of_Spain'),
(181, 'America/Port-au-Prince'),
(182, 'America/Porto_Acre'),
(183, 'America/Porto_Velho'),
(184, 'America/Puerto_Rico'),
(185, 'America/Rainy_River'),
(186, 'America/Rankin_Inlet'),
(187, 'America/Recife'),
(188, 'America/Regina'),
(189, 'America/Resolute'),
(190, 'America/Rio_Branco'),
(191, 'America/Rosario'),
(192, 'America/Santa_Isabel'),
(193, 'America/Santarem'),
(194, 'America/Santiago'),
(195, 'America/Santo_Domingo'),
(196, 'America/Sao_Paulo'),
(197, 'America/Scoresbysund'),
(198, 'America/Shiprock'),
(199, 'America/Sitka'),
(200, 'America/St_Barthelemy'),
(201, 'America/St_Johns'),
(202, 'America/St_Kitts'),
(203, 'America/St_Lucia'),
(204, 'America/St_Thomas'),
(205, 'America/St_Vincent'),
(206, 'America/Swift_Current'),
(207, 'America/Tegucigalpa'),
(208, 'America/Thule'),
(209, 'America/Thunder_Bay'),
(210, 'America/Tijuana'),
(211, 'America/Toronto'),
(212, 'America/Tortola'),
(213, 'America/Vancouver'),
(214, 'America/Virgin'),
(215, 'America/Whitehorse'),
(216, 'America/Winnipeg'),
(217, 'America/Yakutat'),
(218, 'America/Yellowknife'),
(219, 'Antarctica/Casey'),
(220, 'Antarctica/Davis'),
(221, 'Antarctica/DumontDUrville'),
(222, 'Antarctica/Macquarie'),
(223, 'Antarctica/Mawson'),
(224, 'Antarctica/McMurdo'),
(225, 'Antarctica/Palmer'),
(226, 'Antarctica/Rothera'),
(227, 'Antarctica/South_Pole'),
(228, 'Antarctica/Syowa'),
(229, 'Antarctica/Vostok'),
(230, 'Arctic/Longyearbyen'),
(231, 'Asia/Aden'),
(232, 'Asia/Amman'),
(233, 'Asia/Anadyr'),
(234, 'Asia/Aqtau'),
(235, 'Asia/Aqtobe'),
(236, 'Asia/Ashkhabad'),
(237, 'Asia/Baghdad'),
(238, 'Asia/Bahrain'),
(239, 'Asia/Baku'),
(240, 'Asia/Beirut'),
(241, 'Asia/Bishkek'),
(242, 'Asia/Brunei'),
(243, 'Asia/Calcutta'),
(244, 'Asia/Chongqing'),
(245, 'Asia/Chungking'),
(246, 'Asia/Colombo'),
(247, 'Asia/Dacca'),
(248, 'Asia/Dhaka'),
(249, 'Asia/Dili'),
(250, 'Asia/Dubai'),
(251, 'Asia/Dushanbe'),
(252, 'Asia/Harbin'),
(253, 'Asia/Hebron'),
(254, 'Asia/Ho_Chi_Minh'),
(255, 'Asia/Hong_Kong'),
(256, 'Asia/Irkutsk'),
(257, 'Asia/Istanbul'),
(258, 'Asia/Jakarta'),
(259, 'Asia/Jayapura'),
(260, 'Asia/Kabul'),
(261, 'Asia/Kamchatka'),
(262, 'Asia/Karachi'),
(263, 'Asia/Kashgar'),
(264, 'Asia/Katmandu'),
(265, 'Asia/Khandyga'),
(266, 'Asia/Kolkata'),
(267, 'Asia/Krasnoyarsk'),
(268, 'Asia/Kuching'),
(269, 'Asia/Kuwait'),
(270, 'Asia/Macao'),
(271, 'Asia/Macau'),
(272, 'Asia/Makassar'),
(273, 'Asia/Manila'),
(274, 'Asia/Muscat'),
(275, 'Asia/Nicosia'),
(276, 'Asia/Novosibirsk'),
(277, 'Asia/Omsk'),
(278, 'Asia/Oral'),
(279, 'Asia/Phnom_Penh'),
(280, 'Asia/Pyongyang'),
(281, 'Asia/Qatar'),
(282, 'Asia/Qyzylorda'),
(283, 'Asia/Rangoon'),
(284, 'Asia/Saigon'),
(285, 'Asia/Sakhalin'),
(286, 'Asia/Samarkand'),
(287, 'Asia/Seoul'),
(288, 'Asia/Singapore'),
(289, 'Asia/Taipei'),
(290, 'Asia/Tashkent'),
(291, 'Asia/Tbilisi'),
(292, 'Asia/Tel_Aviv'),
(293, 'Asia/Thimbu'),
(294, 'Asia/Thimphu'),
(295, 'Asia/Tokyo'),
(296, 'Asia/Ulaanbaatar'),
(297, 'Asia/Ulan_Bator'),
(298, 'Asia/Urumqi'),
(299, 'Asia/Ust-Nera'),
(300, 'Asia/Vladivostok'),
(301, 'Asia/Yakutsk'),
(302, 'Asia/Yekaterinburg'),
(303, 'Asia/Yerevan'),
(304, 'Atlantic/Azores'),
(305, 'Atlantic/Canary'),
(306, 'Atlantic/Cape_Verde'),
(307, 'Atlantic/Faeroe'),
(308, 'Atlantic/Faroe'),
(309, 'Atlantic/Madeira'),
(310, 'Atlantic/Reykjavik'),
(311, 'Atlantic/South_Georgia'),
(312, 'Atlantic/St_Helena'),
(313, 'Australia/ACT'),
(314, 'Australia/Brisbane'),
(315, 'Australia/Broken_Hill'),
(316, 'Australia/Canberra'),
(317, 'Australia/Currie'),
(318, 'Australia/Eucla'),
(319, 'Australia/Hobart'),
(320, 'Australia/LHI'),
(321, 'Australia/Lindeman'),
(322, 'Australia/Melbourne'),
(323, 'Australia/North'),
(324, 'Australia/NSW'),
(325, 'Australia/Perth'),
(326, 'Australia/South'),
(327, 'Australia/Sydney'),
(328, 'Australia/Tasmania'),
(329, 'Australia/Victoria'),
(330, 'Australia/Yancowinna'),
(331, 'Europe/Amsterdam'),
(332, 'Europe/Athens'),
(333, 'Europe/Belfast'),
(334, 'Europe/Belgrade'),
(335, 'Europe/Berlin'),
(336, 'Europe/Brussels'),
(337, 'Europe/Bucharest'),
(338, 'Europe/Budapest'),
(339, 'Europe/Busingen'),
(340, 'Europe/Copenhagen'),
(341, 'Europe/Dublin'),
(342, 'Europe/Gibraltar'),
(343, 'Europe/Guernsey'),
(344, 'Europe/Isle_of_Man'),
(345, 'Europe/Istanbul'),
(346, 'Europe/Jersey'),
(347, 'Europe/Kaliningrad'),
(348, 'Europe/Lisbon'),
(349, 'Europe/Ljubljana'),
(350, 'Europe/London'),
(351, 'Europe/Luxembourg'),
(352, 'Europe/Malta'),
(353, 'Europe/Mariehamn'),
(354, 'Europe/Minsk'),
(355, 'Europe/Monaco'),
(356, 'Europe/Nicosia'),
(357, 'Europe/Oslo'),
(358, 'Europe/Paris'),
(359, 'Europe/Podgorica'),
(360, 'Europe/Riga'),
(361, 'Europe/Rome'),
(362, 'Europe/Samara'),
(363, 'Europe/San_Marino'),
(364, 'Europe/Simferopol'),
(365, 'Europe/Skopje'),
(366, 'Europe/Sofia'),
(367, 'Europe/Stockholm'),
(368, 'Europe/Tirane'),
(369, 'Europe/Tiraspol'),
(370, 'Europe/Uzhgorod'),
(371, 'Europe/Vaduz'),
(372, 'Europe/Vienna'),
(373, 'Europe/Vilnius'),
(374, 'Europe/Volgograd'),
(375, 'Europe/Warsaw'),
(376, 'Europe/Zaporozhye'),
(377, 'Europe/Zurich'),
(378, 'Indian/Antananarivo'),
(379, 'Indian/Christmas'),
(380, 'Indian/Cocos'),
(381, 'Indian/Comoro'),
(382, 'Indian/Kerguelen'),
(383, 'Indian/Maldives'),
(384, 'Indian/Mauritius'),
(385, 'Indian/Mayotte'),
(386, 'Indian/Reunion'),
(387, 'Pacific/Apia'),
(388, 'Pacific/Chatham'),
(389, 'Pacific/Chuuk'),
(390, 'Pacific/Easter'),
(391, 'Pacific/Efate'),
(392, 'Pacific/Fakaofo'),
(393, 'Pacific/Fiji'),
(394, 'Pacific/Funafuti'),
(395, 'Pacific/Galapagos'),
(396, 'Pacific/Guadalcanal'),
(397, 'Pacific/Guam'),
(398, 'Pacific/Honolulu'),
(399, 'Pacific/Johnston'),
(400, 'Pacific/Kosrae'),
(401, 'Pacific/Kwajalein'),
(402, 'Pacific/Majuro'),
(403, 'Pacific/Marquesas'),
(404, 'Pacific/Nauru'),
(405, 'Pacific/Niue'),
(406, 'Pacific/Norfolk'),
(407, 'Pacific/Noumea'),
(408, 'Pacific/Palau'),
(409, 'Pacific/Pitcairn'),
(410, 'Pacific/Pohnpei'),
(411, 'Pacific/Ponape'),
(412, 'Pacific/Rarotonga'),
(413, 'Pacific/Saipan'),
(414, 'Pacific/Samoa'),
(415, 'Pacific/Tahiti'),
(416, 'Pacific/Tongatapu'),
(417, 'Pacific/Truk'),
(418, 'Pacific/Wake'),
(419, 'Pacific/Wallis');

-- --------------------------------------------------------

--
-- Table structure for table `fp_user`
--

CREATE TABLE IF NOT EXISTS `fp_user` (
`user_id` int(10) unsigned NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `address_1` varchar(255) DEFAULT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `country_id` varchar(255) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `user_status` varchar(255) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ticketit_admin` tinyint(1) NOT NULL DEFAULT '0',
  `ticketit_agent` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fp_user`
--

INSERT INTO `fp_user` (`user_id`, `password`, `name`, `email`, `phone`, `photo`, `resume`, `address_1`, `address_2`, `zipcode`, `country_id`, `skype`, `facebook`, `linkedin`, `user_status`, `notes`, `remember_token`, `created_at`, `updated_at`, `ticketit_admin`, `ticketit_agent`) VALUES
(18, '$2y$10$GSbuei4mSe8CxJIEAFvs9eiurlkYklef4Jw5Uma10ptjZX2o9joEe', 'Jexter Dean Buenaventura', 'projectmanager@hdenergy.ca', '1234567890', 'assets/user\\Snapshot_20160526_2.JPG', '', '#14 A Wakat Suello Road', 'Test', '2600', '185', 'arcblades', 'jexterdean', 'jexterdean', 'Active', '', 'dReoILezN7AXiuFOzffsjN9yjPefM0A52UjiC5K0ZLL1Bmkf8frNd4YqOTcg', '2016-06-17 14:16:40', '2016-06-17 06:16:40', 1, 0),
(19, '$2y$10$fwiJSpCfIwXrIWr8NJjNfeMcSP//2KyjevUbWIrCUVCe4hKdL3Q3y', 'Jane Doe', 'janedoe@gmail.com', '1234567890', 'assets/user/avatar.png', NULL, '', '', '', '185', '', '', '', 'Active', NULL, 'WWnmYFKFr8pAf1Lc4GTEEUC13ANQqRP0WLwSF2i0ZLaCjMYHFrEEfMMTb8yS', '2016-06-16 13:04:33', '2016-06-16 05:04:33', 1, 1),
(20, '$2y$10$DdQx07EpbSBdKtojQENLXOIxRgoUMWCVNYy9fJKeu/cfZEJKHoty2', 'Jane Buenaventura', 'janebuenaventura@gmail.com', '123456789', 'assets/user\\resume_sample_photo.jpg', NULL, 'test', 'test', '2600', '185', '', '', '', 'Active', NULL, 'uJlk1bQMN3Fr2qZ4aUIjLSieNjjagW2SuCAWgW33Fmsoi77rwGvt9Yq3nwma', '2016-06-16 13:12:53', '2016-06-16 05:12:53', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fp_user_payroll_setting`
--

CREATE TABLE IF NOT EXISTS `fp_user_payroll_setting` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `hourly_rate` double(8,2) NOT NULL,
  `paypal_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pay_period_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_videos`
--

CREATE TABLE IF NOT EXISTS `fp_videos` (
`id` int(10) unsigned NOT NULL,
  `unique_id` int(11) NOT NULL,
  `user_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `owner_id` int(11) NOT NULL,
  `owner_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stream_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `video_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `video_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_videos`
--

INSERT INTO `fp_videos` (`id`, `unique_id`, `user_type`, `owner_id`, `owner_type`, `stream_id`, `video_type`, `video_url`, `created_at`, `updated_at`) VALUES
(17, 4, 'applicant', 10, 'job', '305179886519908900', 'local', 'https://laravel.software/recordings/305179886519908900.webm', '2016-06-17 06:50:14', '2016-06-17 06:50:14'),
(18, 4, 'applicant', 10, 'job', '208624051650986080', 'local', 'https://laravel.software/recordings/208624051650986080.webm', '2016-06-17 07:12:56', '2016-06-17 07:12:56');

-- --------------------------------------------------------

--
-- Table structure for table `fp_video_tags`
--

CREATE TABLE IF NOT EXISTS `fp_video_tags` (
`id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `applicant_id` bigint(20) NOT NULL,
  `job_id` bigint(20) NOT NULL,
  `video_id` bigint(20) NOT NULL,
  `tags` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_video_tags`
--

INSERT INTO `fp_video_tags` (`id`, `user_id`, `applicant_id`, `job_id`, `video_id`, `tags`, `created_at`, `updated_at`) VALUES
(1, NULL, 4, 10, 14, 'test,test2,test3,test4,test5,test6,test7,test8', '2016-06-17 05:26:43', '2016-06-17 05:32:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fp_accounts`
--
ALTER TABLE `fp_accounts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_applicants`
--
ALTER TABLE `fp_applicants`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `applicants_email_unique` (`email`);

--
-- Indexes for table `fp_applicant_ratings`
--
ALTER TABLE `fp_applicant_ratings`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_applicant_tags`
--
ALTER TABLE `fp_applicant_tags`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_assigned_roles`
--
ALTER TABLE `fp_assigned_roles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_assigned_user`
--
ALTER TABLE `fp_assigned_user`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_attachment`
--
ALTER TABLE `fp_attachment`
 ADD PRIMARY KEY (`attachment_id`);

--
-- Indexes for table `fp_billing`
--
ALTER TABLE `fp_billing`
 ADD PRIMARY KEY (`billing_id`);

--
-- Indexes for table `fp_bug`
--
ALTER TABLE `fp_bug`
 ADD PRIMARY KEY (`bug_id`), ADD KEY `bug_id` (`bug_id`);

--
-- Indexes for table `fp_client`
--
ALTER TABLE `fp_client`
 ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `fp_comment`
--
ALTER TABLE `fp_comment`
 ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `fp_companies`
--
ALTER TABLE `fp_companies`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_company_divisions`
--
ALTER TABLE `fp_company_divisions`
 ADD PRIMARY KEY (`id`), ADD KEY `company_divisions_company_id_foreign` (`company_id`);

--
-- Indexes for table `fp_country`
--
ALTER TABLE `fp_country`
 ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `fp_events`
--
ALTER TABLE `fp_events`
 ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `fp_item`
--
ALTER TABLE `fp_item`
 ADD PRIMARY KEY (`item_id`), ADD UNIQUE KEY `item_id` (`item_id`);

--
-- Indexes for table `fp_jobs`
--
ALTER TABLE `fp_jobs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_links`
--
ALTER TABLE `fp_links`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_link_categories`
--
ALTER TABLE `fp_link_categories`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `link_categories_slug_unique` (`slug`), ADD UNIQUE KEY `link_categories_name_unique` (`name`);

--
-- Indexes for table `fp_link_tags`
--
ALTER TABLE `fp_link_tags`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `link_tags_name_unique` (`name`);

--
-- Indexes for table `fp_mail_queue`
--
ALTER TABLE `fp_mail_queue`
 ADD PRIMARY KEY (`id`), ADD KEY `mail_queue_queue_reserved_reserved_at_index` (`queue`,`reserved`,`reserved_at`);

--
-- Indexes for table `fp_meeting`
--
ALTER TABLE `fp_meeting`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_meeting_priority`
--
ALTER TABLE `fp_meeting_priority`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_meeting_type`
--
ALTER TABLE `fp_meeting_type`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_message`
--
ALTER TABLE `fp_message`
 ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `fp_newnote`
--
ALTER TABLE `fp_newnote`
 ADD PRIMARY KEY (`note_id`);

--
-- Indexes for table `fp_notes`
--
ALTER TABLE `fp_notes`
 ADD PRIMARY KEY (`note_id`);

--
-- Indexes for table `fp_password_resets`
--
ALTER TABLE `fp_password_resets`
 ADD KEY `password_resets_email_index` (`email`), ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `fp_payment`
--
ALTER TABLE `fp_payment`
 ADD PRIMARY KEY (`payment_id`), ADD UNIQUE KEY `payment_id` (`payment_id`);

--
-- Indexes for table `fp_payment_method`
--
ALTER TABLE `fp_payment_method`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_pay_period`
--
ALTER TABLE `fp_pay_period`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_permissions`
--
ALTER TABLE `fp_permissions`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `permissions_slug_unique` (`slug`);

--
-- Indexes for table `fp_permission_role`
--
ALTER TABLE `fp_permission_role`
 ADD PRIMARY KEY (`id`), ADD KEY `permission_role_permission_id_index` (`permission_id`), ADD KEY `permission_role_role_id_index` (`role_id`);

--
-- Indexes for table `fp_permission_user`
--
ALTER TABLE `fp_permission_user`
 ADD PRIMARY KEY (`id`), ADD KEY `permission_user_permission_id_index` (`permission_id`), ADD KEY `permission_user_user_id_index` (`user_id`);

--
-- Indexes for table `fp_profiles`
--
ALTER TABLE `fp_profiles`
 ADD PRIMARY KEY (`id`), ADD KEY `profiles_user_id_foreign` (`user_id`), ADD KEY `profiles_company_id_foreign` (`company_id`), ADD KEY `profiles_role_id_foreign` (`role_id`);

--
-- Indexes for table `fp_project`
--
ALTER TABLE `fp_project`
 ADD PRIMARY KEY (`project_id`), ADD KEY `project_user_id_foreign` (`user_id`);

--
-- Indexes for table `fp_question`
--
ALTER TABLE `fp_question`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_question_feedback`
--
ALTER TABLE `fp_question_feedback`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_question_tag`
--
ALTER TABLE `fp_question_tag`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_question_type`
--
ALTER TABLE `fp_question_type`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_roles`
--
ALTER TABLE `fp_roles`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `fp_role_user`
--
ALTER TABLE `fp_role_user`
 ADD PRIMARY KEY (`id`), ADD KEY `role_user_role_id_index` (`role_id`), ADD KEY `role_user_user_id_index` (`user_id`);

--
-- Indexes for table `fp_setting`
--
ALTER TABLE `fp_setting`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_share_jobs`
--
ALTER TABLE `fp_share_jobs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_share_jobs_companies`
--
ALTER TABLE `fp_share_jobs_companies`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_share_jobs_companies_permissions`
--
ALTER TABLE `fp_share_jobs_companies_permissions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_task`
--
ALTER TABLE `fp_task`
 ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `fp_task_check_list`
--
ALTER TABLE `fp_task_check_list`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_task_check_list_order`
--
ALTER TABLE `fp_task_check_list_order`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_task_check_list_permissions`
--
ALTER TABLE `fp_task_check_list_permissions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_task_comment`
--
ALTER TABLE `fp_task_comment`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_task_timer`
--
ALTER TABLE `fp_task_timer`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_team`
--
ALTER TABLE `fp_team`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_team_companies`
--
ALTER TABLE `fp_team_companies`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_team_member`
--
ALTER TABLE `fp_team_member`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_team_project`
--
ALTER TABLE `fp_team_project`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_template`
--
ALTER TABLE `fp_template`
 ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `fp_test`
--
ALTER TABLE `fp_test`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_test_completed`
--
ALTER TABLE `fp_test_completed`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_test_feedback`
--
ALTER TABLE `fp_test_feedback`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_test_per_applicant`
--
ALTER TABLE `fp_test_per_applicant`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_test_per_job`
--
ALTER TABLE `fp_test_per_job`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_test_question_tag`
--
ALTER TABLE `fp_test_question_tag`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_test_result`
--
ALTER TABLE `fp_test_result`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_test_tag`
--
ALTER TABLE `fp_test_tag`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_ticket`
--
ALTER TABLE `fp_ticket`
 ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `fp_ticketit`
--
ALTER TABLE `fp_ticketit`
 ADD PRIMARY KEY (`id`), ADD KEY `ticketit_subject_index` (`subject`), ADD KEY `ticketit_status_id_index` (`status_id`), ADD KEY `ticketit_priority_id_index` (`priority_id`), ADD KEY `ticketit_user_id_index` (`user_id`), ADD KEY `ticketit_agent_id_index` (`agent_id`), ADD KEY `ticketit_category_id_index` (`category_id`), ADD KEY `ticketit_completed_at_index` (`completed_at`);

--
-- Indexes for table `fp_ticketit_audits`
--
ALTER TABLE `fp_ticketit_audits`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_ticketit_categories`
--
ALTER TABLE `fp_ticketit_categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_ticketit_comments`
--
ALTER TABLE `fp_ticketit_comments`
 ADD PRIMARY KEY (`id`), ADD KEY `ticketit_comments_user_id_index` (`user_id`), ADD KEY `ticketit_comments_ticket_id_index` (`ticket_id`);

--
-- Indexes for table `fp_ticketit_priorities`
--
ALTER TABLE `fp_ticketit_priorities`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_ticketit_settings`
--
ALTER TABLE `fp_ticketit_settings`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `ticketit_settings_slug_unique` (`slug`), ADD UNIQUE KEY `ticketit_settings_lang_unique` (`lang`), ADD KEY `ticketit_settings_lang_index` (`lang`), ADD KEY `ticketit_settings_slug_index` (`slug`);

--
-- Indexes for table `fp_ticketit_statuses`
--
ALTER TABLE `fp_ticketit_statuses`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_timer`
--
ALTER TABLE `fp_timer`
 ADD PRIMARY KEY (`timer_id`);

--
-- Indexes for table `fp_timezone`
--
ALTER TABLE `fp_timezone`
 ADD PRIMARY KEY (`timezone_id`);

--
-- Indexes for table `fp_user`
--
ALTER TABLE `fp_user`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `fp_user_payroll_setting`
--
ALTER TABLE `fp_user_payroll_setting`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_videos`
--
ALTER TABLE `fp_videos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fp_video_tags`
--
ALTER TABLE `fp_video_tags`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fp_accounts`
--
ALTER TABLE `fp_accounts`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_applicants`
--
ALTER TABLE `fp_applicants`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=231;
--
-- AUTO_INCREMENT for table `fp_applicant_ratings`
--
ALTER TABLE `fp_applicant_ratings`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_applicant_tags`
--
ALTER TABLE `fp_applicant_tags`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `fp_assigned_roles`
--
ALTER TABLE `fp_assigned_roles`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_assigned_user`
--
ALTER TABLE `fp_assigned_user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fp_attachment`
--
ALTER TABLE `fp_attachment`
MODIFY `attachment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_billing`
--
ALTER TABLE `fp_billing`
MODIFY `billing_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fp_bug`
--
ALTER TABLE `fp_bug`
MODIFY `bug_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fp_client`
--
ALTER TABLE `fp_client`
MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fp_comment`
--
ALTER TABLE `fp_comment`
MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `fp_companies`
--
ALTER TABLE `fp_companies`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `fp_company_divisions`
--
ALTER TABLE `fp_company_divisions`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fp_country`
--
ALTER TABLE `fp_country`
MODIFY `country_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=258;
--
-- AUTO_INCREMENT for table `fp_events`
--
ALTER TABLE `fp_events`
MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fp_item`
--
ALTER TABLE `fp_item`
MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fp_jobs`
--
ALTER TABLE `fp_jobs`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `fp_links`
--
ALTER TABLE `fp_links`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fp_link_categories`
--
ALTER TABLE `fp_link_categories`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_link_tags`
--
ALTER TABLE `fp_link_tags`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_mail_queue`
--
ALTER TABLE `fp_mail_queue`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_meeting`
--
ALTER TABLE `fp_meeting`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `fp_meeting_priority`
--
ALTER TABLE `fp_meeting_priority`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fp_meeting_type`
--
ALTER TABLE `fp_meeting_type`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fp_message`
--
ALTER TABLE `fp_message`
MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fp_newnote`
--
ALTER TABLE `fp_newnote`
MODIFY `note_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_notes`
--
ALTER TABLE `fp_notes`
MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `fp_payment`
--
ALTER TABLE `fp_payment`
MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_payment_method`
--
ALTER TABLE `fp_payment_method`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_pay_period`
--
ALTER TABLE `fp_pay_period`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_permissions`
--
ALTER TABLE `fp_permissions`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_permission_role`
--
ALTER TABLE `fp_permission_role`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_permission_user`
--
ALTER TABLE `fp_permission_user`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_profiles`
--
ALTER TABLE `fp_profiles`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `fp_project`
--
ALTER TABLE `fp_project`
MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `fp_question`
--
ALTER TABLE `fp_question`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `fp_question_feedback`
--
ALTER TABLE `fp_question_feedback`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_question_tag`
--
ALTER TABLE `fp_question_tag`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_question_type`
--
ALTER TABLE `fp_question_type`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fp_roles`
--
ALTER TABLE `fp_roles`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `fp_role_user`
--
ALTER TABLE `fp_role_user`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `fp_setting`
--
ALTER TABLE `fp_setting`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fp_share_jobs`
--
ALTER TABLE `fp_share_jobs`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_share_jobs_companies`
--
ALTER TABLE `fp_share_jobs_companies`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `fp_share_jobs_companies_permissions`
--
ALTER TABLE `fp_share_jobs_companies_permissions`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fp_task`
--
ALTER TABLE `fp_task`
MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `fp_task_check_list`
--
ALTER TABLE `fp_task_check_list`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=539;
--
-- AUTO_INCREMENT for table `fp_task_check_list_order`
--
ALTER TABLE `fp_task_check_list_order`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=385;
--
-- AUTO_INCREMENT for table `fp_task_check_list_permissions`
--
ALTER TABLE `fp_task_check_list_permissions`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `fp_task_comment`
--
ALTER TABLE `fp_task_comment`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_task_timer`
--
ALTER TABLE `fp_task_timer`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `fp_team`
--
ALTER TABLE `fp_team`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `fp_team_companies`
--
ALTER TABLE `fp_team_companies`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_team_member`
--
ALTER TABLE `fp_team_member`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_team_project`
--
ALTER TABLE `fp_team_project`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `fp_template`
--
ALTER TABLE `fp_template`
MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_test`
--
ALTER TABLE `fp_test`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `fp_test_completed`
--
ALTER TABLE `fp_test_completed`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `fp_test_feedback`
--
ALTER TABLE `fp_test_feedback`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_test_per_applicant`
--
ALTER TABLE `fp_test_per_applicant`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fp_test_per_job`
--
ALTER TABLE `fp_test_per_job`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fp_test_question_tag`
--
ALTER TABLE `fp_test_question_tag`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_test_result`
--
ALTER TABLE `fp_test_result`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `fp_test_tag`
--
ALTER TABLE `fp_test_tag`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_ticket`
--
ALTER TABLE `fp_ticket`
MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fp_ticketit`
--
ALTER TABLE `fp_ticketit`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_ticketit_audits`
--
ALTER TABLE `fp_ticketit_audits`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_ticketit_categories`
--
ALTER TABLE `fp_ticketit_categories`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_ticketit_comments`
--
ALTER TABLE `fp_ticketit_comments`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_ticketit_priorities`
--
ALTER TABLE `fp_ticketit_priorities`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_ticketit_settings`
--
ALTER TABLE `fp_ticketit_settings`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `fp_ticketit_statuses`
--
ALTER TABLE `fp_ticketit_statuses`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_timer`
--
ALTER TABLE `fp_timer`
MODIFY `timer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_timezone`
--
ALTER TABLE `fp_timezone`
MODIFY `timezone_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=420;
--
-- AUTO_INCREMENT for table `fp_user`
--
ALTER TABLE `fp_user`
MODIFY `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `fp_user_payroll_setting`
--
ALTER TABLE `fp_user_payroll_setting`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fp_videos`
--
ALTER TABLE `fp_videos`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `fp_video_tags`
--
ALTER TABLE `fp_video_tags`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `fp_company_divisions`
--
ALTER TABLE `fp_company_divisions`
ADD CONSTRAINT `company_divisions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `fp_companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fp_permission_role`
--
ALTER TABLE `fp_permission_role`
ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `fp_permissions` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `fp_roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fp_permission_user`
--
ALTER TABLE `fp_permission_user`
ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `fp_permissions` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `fp_user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `fp_profiles`
--
ALTER TABLE `fp_profiles`
ADD CONSTRAINT `profiles_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `fp_companies` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `profiles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `fp_roles` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `fp_user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `fp_project`
--
ALTER TABLE `fp_project`
ADD CONSTRAINT `project_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `fp_user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `fp_role_user`
--
ALTER TABLE `fp_role_user`
ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `fp_roles` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `fp_user` (`user_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
