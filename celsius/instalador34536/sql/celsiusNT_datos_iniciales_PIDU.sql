-- TODO DEBERIA SER UN PIDU COMO EL DEL DIRECTORIO

-- phpMyAdmin SQL Dump
-- version 2.8.0.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generaci�n: 18-01-2007 a las 10:04:06
-- Versi�n del servidor: 4.1.18
-- Versi�n de PHP: 4.4.2-pl1
-- 
-- Base de datos: `celsiusoriginal`
-- 

-- --------------------------------------------------------

-- 
-- Volcar la base de datos para la tabla `dependencias`
-- 

INSERT INTO `dependencias` (`Id`, `Codigo_Institucion`, `Nombre`, `Direccion`, `Telefonos`, `Figura_Portada`, `Es_LibLink`, `Hipervinculo1`, `Hipervinculo2`, `Hipervinculo3`, `Comentarios`, `esCentralizado`) VALUES 
(10001, 10001, 'Facultad de Ciencias Exactas', '', '', 0, 1, '', '', '', '', 0),
(10004, 10001, 'Facultad de Ingenier�a', '', '', 0, 1, '', '', '', '', 0),
(10006, 10001, 'RECTORADO', NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 0),
(10007, 10003, 'Centennial Science and Engineering Library', '', '', 1, 1, 'http://libros.unm.edu/', '', '', 'La biblioteca Centennial recibe muchos de los pedidos realizados desde el PrEBi y desde el link que figura abajo puede accederse a la consulta de sus publicaciones. Sus cat�logos se hallan en la web.', 0),
(10009, 10001, 'Facultad de Ciencias Naturales y Museo', '', '', 0, 1, '', '', '', '', 0),
(10013, 10003, 'Health Sciences Center Library', '', '', 0, 0, '', '', '', '', 0),
(10014, 10004, 'Biblioteca da �rea de Engenharia e Arquitetura', '', '', 0, 1, '', '', '', '', 0),
(10015, 10005, 'Centro de Informaci�n', '', '', 0, 1, '', '', '', '', 0),
(10016, 10006, 'Instituto De Qu�mica De S�o Carlos', '', '', 0, 0, '', '', '', '', 0),
(10017, 10004, 'Instituto de Biologia', '', '', 0, 0, '', '', '', '', 0),
(10130, 10001, 'Facultad de Arquitectura y Urbanismo', '', '', 0, 1, '', '', '', '', 0),
(10019, 10004, 'Instituto de F�sica Gleb Wataghin', '', '', 0, 0, '', '', '', '', 0),
(10020, 10004, 'Instituto de Qu�mica', '', '', 0, 0, '', '', '', '', 0),
(10022, 10006, 'Escola Polit�cnica Biblioteca De Engenharia De Eletricidade', '', '', 0, 0, '', '', '', '', 0),
(10023, 10004, 'Instituto de Matem�tica, Estat�stica e Computa��o Cient�fica', '', '', 0, 0, '', '', '', '', 0),
(10025, 10001, 'Facultad de Inform�tica', '', '', 0, 1, '', '', '', '', 0),
(10027, 10001, 'Facultad de Ciencias M�dicas', '', '', 0, 1, '', '', '', '', 0),
(10132, 10033, 'CIENCIAS FORESTALES', '', '', 0, 0, '', '', '', '', 0),
(10029, 10003, 'Delphion Intellectual Property Network', '', '', 0, 0, '', '', '', '', 0),
(10030, 10001, 'Facultad de Ciencias Agrarias y Forestales', '', '', 0, 1, '', '', '', '', 0),
(10031, 10003, 'Zimmerman Library', '', '', 0, 0, '', '', '', '', 0),
(10032, 10003, 'William J. Parish Memorial Business & Economics Library', '', '', 0, 0, '', '', '', '', 0),
(10034, 10001, 'Facultad de Odontolog�a', '', '', 0, 1, '', '', '', '', 0),
(10036, 10006, 'Escola de Engenharia de S�o Carlos', '', '', 0, 0, '', '', '', '', 0),
(10039, 10003, 'Los Alamos Branch', '', '', 0, 0, '', '', '', '', 0),
(10040, 10006, 'Escola Polit�cnica Biblioteca Central', '', '', 0, 0, '', '', '', '', 0),
(10041, 10001, 'Facultad de Veterinaria', '', '', 0, 1, '', '', '', '', 0),
(10042, 10014, 'Centro de Ci�ncias F�sicas e Matem�ticas', '', '', 0, 1, '', '', '', '', 0),
(10043, 10001, 'Facultad de Ciencias Astron�micas y Geof�sicas', '', '', 0, 1, '', '', '', '', 0),
(10044, 10006, 'Escola Polit�cnica', '', '', 0, 0, '', '', '', '', 0),
(10046, 10015, 'Biblioteca Central', '', '', 0, 0, '', '', '', '', 0),
(10048, 10006, 'Escola Polit�cnica  Biblioteca De Engenharia Metal�rgica', '', '', 0, 0, '', '', '', '', 0),
(10049, 10006, 'Escola Polit�cnica  Biblioteca De Engenharia Qu�mica', '', '', 0, 0, '', '', '', '', 0),
(10052, 10006, 'Escola de Enfermagem de Ribeir�o Preto', '', '', 0, 0, '', '', '', '', 0),
(10054, 10001, 'Instituto Argentino de Radioastronom�a', '', '', 0, 0, '', '', '', '', 0),
(10057, 10004, 'Faculdade de Ci�ncias M�dicas', '', '', 0, 1, '', '', '', '', 0),
(10067, 10001, 'Facultad de Bellas Artes', '', '', 0, 1, '', '', '', '', 0),
(10704, 0, '', '', '', 0, 0, '', '', '', '', 0),
(10071, 10006, 'Escola Polit�cnica Biblioteca de Engenharia Mec�nica, Naval e Oce�nica', '', '', 0, 0, '', '', '', '', 0),
(10072, 10005, 'Centro At�mico Constituyentes', '', '', 0, 1, '', '', '', '', 0),
(10073, 10006, 'Faculdade De Medicina Veterin�ria E Zootecnia', '', '', 0, 0, '', '', '', '', 0),
(10074, 10014, 'Centro de Ci�ncias Agr�rias', '', '', 0, 1, '', '', '', '', 0),
(10078, 10005, 'Centro At�mico Ezeiza', '', '', 0, 1, '', '', '', '', 0),
(10079, 10005, 'Centro At�mico Bariloche', '', '', 0, 1, '', '', '', '', 0),
(10080, 10005, 'OTRA (VE)', '', '', 0, 1, '', '', '', '', 0),
(10082, 10014, 'Centro de Ci�ncias Biol�gicas', '', '', 0, 1, '', '', '', '', 0),
(10084, 10014, 'Centro Tecnol�gico', '', '', 0, 1, '', '', '', '', 0),
(10085, 10013, 'Biblioteca Central Irm�o Jos� Ot�o', '', '', 0, 1, '', '', '', '', 0),
(10088, 10003, 'New Mexico Tech Skeen Library', '', '', 0, 0, '', '', '', '', 0),
(10091, 10022, 'Colegio de Ciencias y Humanidades Azcapotzalco', '', '', 0, 0, '', '', '', '', 0),
(10094, 10011, 'Biblioteca de la E.T.S. de Ingenier�a Inform�tica y Telecomunicaci�n', '', '', 0, 0, '', '', '', '', 0),
(10095, 10011, 'Biblioteca de la Facultad de Ciencias', '', '', 0, 0, '', '', '', '', 0),
(10153, 10001, 'PrEBi', '', '', 0, 0, '', '', '', '', 0),
(10106, 10013, 'Biblioteca da Faculdade de Medicina', '', '', 0, 0, '', '', '', '', 0),
(10108, 10001, 'Facultad de Humanidades y Ciencias de la Educaci�n', '', '', 0, 1, 'www.fahce.unlp.edu.ar', 'www.fahce.unlp.edu.ar/gmpp', '', 'Desde el primero de los hiperv�nculos se accede a la biblioteca, desde el segundo al Cat�logo Colectivo de Publicaciones Peri�dicas.', 0),
(10111, 10021, 'Centro De Tecnologia', '', '', 0, 1, '', '', '', '', 0),
(10117, 10006, 'Escola Polit�cnica Biblioteca De Engenharia De Minas', '', '', 0, 0, '', '', '', '', 0),
(10118, 10033, 'ULA', NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 0),
(10120, 10070, 'Sistema de Bibliotecas', '', '', 0, 1, '', '', '', '', 0),
(10122, 10014, 'Centro de Ci�ncias da Sa�de', '', '', 0, 1, '', '', '', '', 0),
(10123, 10011, 'Biblioteca de la Facultad de Farmacia', '', '', 0, 0, '', '', '', '', 0),
(10124, 10004, 'Faculdade de Engenharia Mec�nica', '', '', 0, 0, '', '', '', '', 0),
(10131, 10003, 'ON LINE', '', '', 0, 1, '', '', '', '', 0),
(10126, 10004, 'Faculdade de Engenharia de Alimentos', '', '', 0, 0, '', '', '', '', 0),
(10127, 10001, 'PRESIDENCIA, BACHILLERATO DE BELLAS ARTES', '', '', 0, 0, '', '', '', '', 0),
(10129, 10001, 'Facultad de Periodismo y Comunicaci�n Social', '', '', 0, 1, '', '', '', '', 0),
(10133, 10045, 'ESTUDIOS AMBIENTALES', '', '', 0, 0, '', '', '', '', 0),
(10134, 10045, 'FISICA', '', '', 0, 0, '', '', '', '', 0),
(10137, 10006, 'Faculdade De Odontologia', '', '', 0, 0, '', '', '', '', 0),
(10702, 10013, 'Biblioteca Central Campus Viam�o', '', '', 0, 0, '', '', '', '', 0),
(10143, 10011, 'Biblioteca de la Facultad de Psicolog�a', '', '', 0, 0, '', '', '', '', 0),
(10144, 10045, 'Biblioteca Central', '', '', 0, 0, '', '', '', '', 0),
(10145, 10042, 'INSTITUTO DE QUIMICA BIOLOGICA / ELECTROQUIMICA', '', '', 0, 0, '', '', '', '', 0),
(10147, 10009, 'Biblioteca Central', '', '', 0, 0, '', '', '', '', 0),
(10148, 10027, 'Biblioteca Central', '', '', 0, 0, '', '', '', '', 0),
(10152, 10053, 'Biblioteca Central', '', '', 0, 0, '', '', '', '', 0),
(10155, 10008, 'Biblioteca Central', '', '', 0, 0, '', '', '', '', 0),
(10158, 10011, 'ONLINE', '', '', 0, 0, '', '', '', '', 0),
(10159, 10042, 'CENTRAL', '', '', 0, 0, '', '', '', '', 0),
(10160, 10058, 'Biblioteca', '', '', 0, 0, '', '', '', '', 0),
(10162, 10011, 'Biblioteca del Colegio M�ximo. (Facultad de Comunicaci�n y Documentaci�n y Facultad de Odontolog�a)', '', '', 0, 0, '', '', '', '', 0),
(10163, 10014, 'Biblioteca Universit�ria', '', '', 0, 0, '', '', '', '', 0),
(10164, 10048, 'BIBLIOTECA CENTRAL', '', '', 0, 0, '', '', '', '', 0),
(10165, 10006, 'Museu De Zoologia', '', '', 0, 0, '', '', '', '', 0),
(10167, 10006, 'Faculdade De Filosofia, Letras E Ci�ncias Humanas', '', '', 0, 0, '', '', '', '', 0),
(10171, 10011, 'otra', '', '', 0, 0, '', '', '', '', 0),
(10172, 10023, 'Departamento de Inform�tica', '', '', 0, 0, '', '', '', '', 0),
(10173, 10023, 'Centro T�cnico Cient�fico', '', '', 0, 0, '', '', '', '', 0),
(10174, 10023, 'Se��o de Refer�ncia', '', '', 0, 0, '', '', '', '', 0),
(10175, 10011, 'Biblioteca de la Facultad de Filosof�a y Letras', '', '', 0, 0, '', '', '', '', 0),
(10177, 10015, 'Biblioteca de Ingenier�a', '', '', 0, 0, '', '', '', '', 0),
(10181, 10001, 'Facultad de Ciencias Econ�micas', '6 y 48', '', 0, 1, '', '', '', '', 0),
(10182, 10020, 'Biblioteca de Ciencias', '', '', 0, 0, '', '', '', '', 0),
(10183, 10020, 'Biblioteca de Medicina', '', '', 0, 0, '', '', '', '', 0),
(10184, 10020, 'Biblioteca de Humanidades Jos� Mercado Ure�a', '', '', 0, 0, '', '', '', '', 0),
(10187, 10020, 'Escuela T�cnica Superior de Ingenier�a de Telecomunicaci�n', '', '', 0, 0, '', '', '', '', 0),
(10189, 10027, 'Biblioteca de Salud Publica', '', '', 0, 0, '', '', '', '', 0),
(10191, 10001, 'Facultad de Ciencias Jur�dicas y Sociales', '', '', 0, 1, '', '', '', '', 0),
(10193, 10033, 'SALUD', '', '', 0, 0, '', '', '', '', 0),
(10194, 10006, 'Instituto de Bioci�ncias', '', '', 0, 0, '', '', '', '', 0),
(10195, 10035, 'Centro T�cnico Aeroespacial', '', '', 0, 0, '', '', '', '', 0),
(10196, 10027, 'Facultad de Odontolog�a', '', '', 0, 0, '', '', '', '', 0),
(10197, 10003, 'Fine Arts and Design Library', '', '', 0, 0, '', '', '', '', 0),
(10198, 10087, 'Biblioteca General', '', '', 0, 0, '', '', '', '', 0),
(10199, 10067, 'Servi�o De Informa��o E Documenta��o', '', '', 0, 0, '', '', '', '', 0),
(10200, 10020, 'OTRA', '', '', 0, 0, '', '', '', '', 0),
(10204, 10090, 'Biblioteca', '', '', 0, 0, '', '', '', '', 0),
(10205, 10033, 'Ciencia y Tecnolog�a', '', '', 0, 0, '', '', '', '', 0),
(10209, 10011, 'Biblioteca de Medicina y CC de la Salud', '', '', 0, 0, '', '', '', '', 0),
(10211, 10081, 'Biblioteca', '', '', 0, 0, '', '', '', '', 0),
(10216, 10103, 'TAMPA', '', '', 0, 0, '', '', '', '', 0),
(10217, 10098, 'Biblioteca De Humanidades', '', '', 0, 0, '', '', '', '', 0),
(10220, 10103, 'TAMPA periodicals', '', '', 0, 0, '', '', '', '', 0),
(10221, 10072, 'Divisi�n de Bibliotecas', '', '', 0, 0, '', '', '', '', 0),
(10222, 10100, 'Biblioteca Mayor de Filosof�a y Educaci�n', '', '', 0, 0, '', '', '', '', 0),
(10223, 10098, 'CAMPUS RIO SAN PEDRO', '', '', 0, 0, '', '', '', '', 0),
(10224, 10100, 'Biblioteca Mayor de Recursos Naturales', '', '', 0, 0, '', '', '', '', 0),
(10225, 10100, 'Biblioteca de Ingenieria', '', '', 0, 0, '', '', '', '', 0),
(10226, 10102, 'BIBLIOTECA CENTRAL', '', '', 0, 0, '', '', '', '', 0),
(10231, 10020, 'Biblioteca General', '', '', 0, 0, '', '', '', '', 0),
(10232, 10027, 'Biblioteca de Zootecnia, Veterinaria, Nutrici�n y deportes', '', '', 0, 0, '', '', '', '', 0),
(10233, 10071, 'Biblioteca', '', '', 0, 1, '', '', '', '', 0),
(10237, 10072, 'ONLINE', '', '', 0, 0, '', '', '', '', 0),
(10239, 10098, 'ONLINE', '', '', 0, 1, '', '', '', '', 0),
(10240, 10048, 'ONLINE', '', '', 0, 1, '', '', '', '', 0),
(10243, 10078, 'Biblioteca', '', '', 0, 0, '', '', '', '', 0),
(10248, 10006, 'Escola Superior De Agricultura "Luiz De Queiroz" Campus Luiz De Queiroz', '', '', 0, 1, '', '', '', '', 0),
(10250, 10011, 'Biblioteca de la Facultad de Ciencias Pol�ticas y Sociolog�a y Centro de Documentaci�n Cient�fica', '', '', 0, 1, '', '', '', '', 0),
(10252, 10006, 'Conjunto das Qu�micas', '', '', 0, 1, '', '', '', '', 0),
(10253, 10052, 'Campus Cuernavaca', '', '', 0, 1, '', '', '', '', 0),
(10256, 10006, 'Faculdade De Medicina De Ribeir�o Preto', '', '', 0, 1, '', '', '', '', 0),
(10258, 10006, 'Faculdade De Sa�de P�blica', '', '', 0, 1, '', '', '', '', 0),
(10261, 10093, 'Biblioteca', '', '', 0, 0, '', '', '', '', 0),
(10263, 10098, 'Biblioteca de Ciencias de la Salud', '', '', 0, 1, '', '', '', '', 0),
(10265, 10129, 'Biblioteca', '', '', 0, 0, '', '', '', '', 0),
(10267, 10020, 'Biblioteca de Ciencias de la Educaci�n y Psicolog�a', '', '', 0, 1, '', '', '', '', 0),
(10269, 10006, 'Faculdade De Zootecnia E Engenharia De Alimentos', '', '', 0, 1, '', '', '', '', 0),
(10277, 10006, 'Faculdade De Medicina', '', '', 0, 1, '', '', '', '', 0),
(10278, 10135, 'Biblioteca', '', '', 0, 0, '', '', '', '', 0),
(10280, 10047, '.', '', '', 0, 0, '', '', '', '', 0),
(10282, 10136, 'Biblioteca', '', '', 0, 0, '', '', '', '', 0),
(10286, 10006, 'Escola de Comunica�oes e Artes', '', '', 0, 1, '', '', '', '', 0),
(10291, 10142, 'Biblioteca', '', '', 0, 0, '', '', '', '', 0),
(10299, 10003, 'Parish Business and Economics Library', '', '', 0, 1, '', '', '', '', 0),
(10300, 10146, 'Biblioteca Central', 'Campus Samambaia - Caixa Postal 411 // 74001-970 - Goi�s', '062  821-1116', 0, 1, '', '', '', '', 0),
(10302, 10148, 'Badham Library', '', '', 0, 1, '', '', '', '', 0),
(10304, 10149, 'Biblioteca', '', '', 0, 1, '', '', '', '', 0),
(10306, 10151, 'Centro de Investigaci�n', '', '', 0, 1, '', '', '', '', 0),
(10307, 10053, 'Sistema Nacional de Bibliotecas', '', '', 0, 1, '', '', '', 'Enviado el: mi�rcoles, 07 de septiembre de 2005 14:08\r\n\r\nBuenas tardes Manrique,\r\n \r\nRespecto de sus inquietudes le informo que el Sinab -Sistema Nacional de\r\nBibliotecas- es una dependencia de la Universidad Nacional de Colombia, y\r\nque la Conmutaci�n Bibliografica ahora comenzar a ser manejada desde esta\r\ndependencia.\r\n \r\nEl nombre de la persona responsable es Marta Elena Mu�oz, el e-mail sigue\r\nsiendo bibconmuta_bog@unal.edu.co.\r\n\r\nCordialmente;\r\nIng. Juan Carlos Garc�a S�enz\r\nConmutaci�n Bibliografica\r\nSistema Nacional de Bibliotecas \r\nUNIVERSIDAD NACIONAL DE COLOMBIA', 0),
(10308, 10049, 'Biblioteca', '', '', 0, 1, '', '', '', '', 0),
(10311, 10006, 'Instituto De Geoci�ncias', '', '', 0, 1, '', '', '', '', 0),
(10313, 10011, 'Biblioteca de la Facultad de Traducci�n e Interpretaci�n', '', '', 0, 1, '', '', '', '', 0),
(10314, 10154, 'Biblioteca Monse�or Marcos Gregorio McGrath', '', '', 0, 1, 'http://www.usma.ac.pa/biblioteca/index.html', '', '', '', 0),
(10315, 10033, 'Centro de Referencia de Cs. Sociales', '', '', 0, 1, '', '', '', '', 0),
(10318, 10008, 'Sala Virtual y de Actualidad', '', '', 0, 1, '', '', '', '', 0),
(10320, 10158, 'Unidad Acad�mica Santa Cruz', 'Km.9 Carretera al Norte', 'Telefono Piloto (591-3)3442999  Fax interno 119', 0, 1, 'http://www.ucbscz.edu.bo/portal/', '', '', '', 0),
(10322, 10160, 'Biblioteca', 'Biblioteca', '', 0, 1, '', '', '', '', 0),
(10327, 10006, 'Instituto Oceanogr�fico', '', '', 0, 1, '', '', '', '', 0),
(10336, 10015, 'Hemeroteca de Ingenier�a', '', '', 0, 1, '', '', '', '', 0),
(10339, 10127, 'Biblioteca Central', '', '', 0, 1, '', '', '', '', 0),
(10340, 10127, 'Escola de Veterin�ria', '', '', 0, 1, '', '', '', '', 0),
(10341, 10168, 'Biblioteca Central', '', '', 0, 1, '', '', '', '', 0),
(10342, 10034, 'Biblioteca Central', '', '(61) 307-2416 , (61) 340-2012', 0, 1, 'http://www.bce.unb.br', '', '', '', 0),
(10343, 10033, 'FACULTAD DE MEDICINA', '', '', 0, 0, '', '', '', '', 0),
(10349, 10022, 'Biblioteca Central', '', '', 0, 1, '', '', '', '', 0),
(10352, 10127, 'Instituto de Ciencias Biologicas', '', '', 0, 1, '', '', '', '', 0),
(10353, 10168, 'ONLINE', '', '', 0, 1, '', '', '', '', 0),
(10355, 10127, 'Facultad de Medicina', '', '', 0, 1, '', '', '', '', 0),
(10359, 10177, 'Biblioteca Pedro Grases', '', '', 0, 0, '', '', '', '', 0),
(10360, 10178, 'Centro Interactivo de Recursos de Informaci�n y Aprendizaje', 'Sta. Catarina M�rtir, San Andr�s Cholula, Puebla', '(01-2) 2-29-22-57', 0, 1, 'http://ciria.udlap.mx/', '', '', 'fax: (01-2) 2-29-20-78', 0),
(10361, 10098, 'Escuela Polit�cnica Superior Algeciras', '', '', 0, 1, '', '', '', '', 0),
(10362, 10004, 'Faculdade De Educa��o F�sica', '', '', 0, 1, '', '', '', '', 0),
(10364, 10102, 'Biblioteca de la Escuela Polit�cnica Superior de Alcoy', '', '', 0, 1, '', '', '', '', 0),
(10366, 10006, 'Instituto De Astronomia, Geof�sica E Ci�ncias Atmosf�rica', '', '', 0, 1, '', '', '', 'Instituto de Astronomia, Geofisica e Ciencias Atmosfericas', 0),
(10367, 10006, 'Instituto De F�sica E Qu�mica De S�o Carlos', '', '', 0, 1, '', '', '', 'Instituto de Fisica de Sao Carlos', 0),
(10368, 10001, 'Biblioteca P�blica de la Universidad Nacional de La Plata', '', '', 0, 1, '', '', '', '', 0),
(10369, 10040, 'BINAME - CENDIM (Hospital de Cl�nicas)', '', '', 0, 1, '', '', '', '', 0),
(10370, 10033, 'Biblioteca de Investigaci�n y Postgrado "Jos� Vicente Scorza"', 'Trujillo. Edo. Trujillo', '', 0, 1, '', '', '', '', 0),
(10371, 10181, 'Biblioteca "Juan Lucio"', '', '', 0, 1, '', '', '', '', 0),
(10377, 10001, 'Facultad de Trabajo Social', '', '', 0, 1, '', '', '', '', 0),
(10379, 10185, 'Biblioteca Central', '', '', 0, 1, '', '', '', '', 0),
(10382, 10151, 'Biblioteca Virtual', '', '', 0, 1, '', '', '', '', 0),
(10383, 10188, 'Biblioteca Virtual', '', '', 0, 1, '', '', '', '', 0),
(10384, 10189, 'Instituto de Ecolog�a', '', '', 0, 1, '', '', '', '', 0),
(10385, 10006, 'Museu de Arqueologia e Etnologia', '', '', 0, 1, '', '', '', '', 0),
(10387, 10001, 'Facultad de Humanidades', '', '', 0, 1, '', '', '', '', 0),
(10390, 10189, 'Biblioteca', '', '', 0, 1, '', '', '', '', 0),
(10392, 10027, 'Facultad de Ciencias Agrarias', '', '', 0, 1, '', '', '', '', 0),
(10393, 10194, 'BIBLIOTECA GENERAL', '', '', 0, 1, '', '', '', '', 0),
(10426, 10221, 'Biblioteket', '', '', 0, 1, '', '', '', '', 0),
(10458, 10255, 'Sede Junin', '', '', 0, 1, '', '', '', '', 0),
(10459, 10255, 'Sede Pergamino', '', '', 0, 1, '', '', '', '', 0),
(10468, 10004, 'Faculdade De Odontologia De Piracicaba', 'Av. Limeira, S/N - Caixa Postal 6109', '', 0, 1, 'http://www.fop.unicamp.br/biblioteca', '', '', '', 0),
(10474, 10263, 'The Aerospace Institute - Charles C. Lauritsen Library', '', '', 0, 1, 'http://www.aero.org/', '', '', '', 0),
(10475, 10023, 'Biblioteca Central', '', '', 0, 1, '', '', '', '', 0),
(10484, 10004, 'Instituto de Filosofia e Ciencias Humanas', '', '', 0, 1, '', '', '', '', 0),
(10490, 10003, 'Eastern New Mexico University Golden Library', '', '', 0, 1, '', '', '', '', 0),
(10506, 10263, 'Library', '', '', 0, 1, '', '', '', '', 0),
(10529, 10006, 'Instituto De F�sica', '', '', 0, 0, '', '', '', '', 0),
(10530, 10020, 'Biblioteca de  Derecho', '', '', 0, 1, '', '', '', '', 0),
(10546, 10006, 'Centro de Energia Nuclear na Agricultura', '', '', 0, 0, '', '', '', '', 0),
(10563, 10011, 'Biblioteca de la Facultad de Ciencias de la Educaci�n', '', '', 0, 0, '', '', '', '', 0),
(10570, 10011, 'Biblioteca de la Facultad de Bellas Artes', '', '', 0, 0, '', '', '', '', 0),
(10603, 10004, 'Centro de Logica, Epistemologia e Historia da Ciencia', '', '', 0, 0, '', '', '', '', 0),
(10631, 10067, 'Biblioteca Central', '', '', 0, 0, '', '', '', '', 0),
(10632, 10020, 'Biblioteca de Ciencias Econ�micas y Empresariales', '', '', 0, 0, '', '', '', '', 0),
(10640, 10413, 'Tecnolog�a Inform�tica', '', '', 0, 0, '', '', '', '', 0),
(10661, 10006, 'Instituto de Psicologia', '', '', 0, 0, '', '', '', '', 0),
(10662, 10052, 'Campus Ciudad de Mexico', '', '', 0, 0, '', '', '', '', 0),
(10666, 10006, 'Faculdade de Economia, Administra��o e Contabilidade', '', '', 0, 0, '', '', '', '', 0),
(10667, 10011, 'Biblioteca de la Facultad de Ciencias Econ�micas y Empresariales', '', '', 0, 0, '', '', '', '', 0),
(10668, 10011, 'Biblioteca de la Facultad de Derecho', '', '', 0, 0, '', '', '', '', 0),
(10682, 10006, 'Instituto de Matematica e Estatistica.', '', '', 0, 0, '', '', '', '', 0),
(10687, 10004, 'Centro De Documenta��o Do Instituto De Economia', '', '', 0, 0, '', '', '', '', 0),
(10705, 10469, 'Facultad de Qu�mica', '', '', 0, 0, '', '', '', '', 0);

-- 
-- Volcar la base de datos para la tabla `instituciones`
-- 

INSERT INTO `instituciones` (`Codigo`, `Nombre`, `Abreviatura`, `Direccion`, `Codigo_Pais`, `Codigo_Localidad`, `Participa_Proyecto`, `Telefono`, `Sitio_Web`, `Comentarios`, `Codigo_Pedidos`, `tipo_pedido_nuevo`, `esCentralizado`, `habilitado_crear_pedidos`, `habilitado_crear_usuarios`) VALUES 
(10001, 'UNIVERSIDAD NACIONAL DE LA PLATA', 'UNLP', '', 10001, 1, 1, '', 'http://www.unlp.edu.ar', 'El sitio web de la Universidad Nacional de La Plata permite acceder a la informaci�n de distintas facultades, dependencias, laboratorios y museos de la instituci�n a trav�s del portal Roble: <a href="http://www.roble.unlp.edu.ar" target="_top">http://www.roble.unlp.edu.ar</a>', 0, 1, 0, 1, 1),
(10003, 'University of New Mexico', 'UNM', '', 10002, 4, 1, '', 'http://www.unm.edu', 'La Universidad de Nuevo M�xico situada en el estado del mismo nombre, participa del proyecto ISTEC y pone a disposici�n sus cat�logos de libros y publicaciones peri�dicas de la web.', 0, 2, 0, 1, 1),
(10004, 'Universidade Estadual de Campinas', 'UNIC', '', 10003, 12, 1, '', '', '', 0, 2, 0, 1, 1),
(10005, 'Comision Nacional de Energ�a At�mica', 'CNEA', 'http:www.cnea.gov.ar', 10001, 1, 1, '', '', '', 0, 2, 0, 1, 1),
(10006, 'Universidade de S�o Paulo', 'USP', '', 10003, 30, 1, '', '', '', 0, 2, 0, 1, 1),
(10008, 'Universidad de los Andes', 'UNIA', '', 10004, 10, 0, '', '', '', 0, 2, 0, 1, 1),
(10009, 'Pontificia Universidad Javeriana Bogot�', 'JAVE', '', 10004, 10, 1, '', '', '', 0, 2, 0, 1, 1),
(10011, 'Universidad de Granada', 'UGR', 'http://www.ugr.es/', 10005, 73, 1, '', '', '', 0, 2, 0, 1, 1),
(10013, 'Pontif�cia Universidade Cat�lica do Rio Grande do Sul', 'UCRS', '', 10003, 12, 1, '', '', '', 0, 2, 0, 1, 1),
(10014, 'Universidade Federal de Santa Catarina', 'UFSC', '', 10003, 12, 1, '', '', '', 0, 2, 0, 1, 1),
(10015, 'Pontificia Universidad Cat�lica del Per�', 'PUCP', '', 10007, 66, 1, '', '', '', 0, 2, 0, 1, 1),
(10020, 'Universidad de M�laga', 'UMA', '', 10005, 8, 1, '', '', '', 0, 2, 0, 1, 1),
(10021, 'Universidade Federal do Rio de Janeiro', 'UFRJ', '', 10003, 12, 1, '', '', '', 0, 2, 0, 1, 1),
(10022, 'Universidad Nacional Aut�noma de M�xico', 'UNAM', '', 10010, 99, 1, '', '', '', 0, 2, 0, 1, 1),
(10023, 'Pontif�cia Universidade Cat�lica do Rio de Janeiro', 'UCRJ', '', 10003, 28, 1, '', '', '', 0, 2, 0, 1, 1),
(10027, 'Universidad de Antioquia', 'ANTI', '', 10004, 10, 1, '', '', '', 0, 2, 0, 1, 1),
(10033, 'Universidad de Los Andes', 'ULA', '', 10008, 29, 1, '', '', '', 0, 2, 0, 1, 1),
(10034, 'Universidade de Bras�lia', 'UNB', 'Campus Universitario Darcy Ribeiro, Asa Norte, Brasilia - DF, CEP: 70910900', 10003, 64, 1, '(61) 307-2416 , (61) 340-2012 // (61) 273-7237', 'http://www.bce.unb.br', '', 0, 2, 0, 1, 1),
(10035, 'Instituto Tecnologico de Aeronautica', 'ITA', '', 10003, 12, 1, '', '', '', 0, 2, 0, 1, 1),
(10045, 'Universidad Sim�n Bol�var', 'USB', '', 10008, 29, 1, '', 'http://159.90.80.10:8991/', '', 0, 2, 0, 1, 1),
(10048, 'Universidad de Vigo', 'UVIG', '', 10005, 8, 1, '', '', '', 0, 2, 0, 1, 1),
(10051, 'Campus de Morelos', 'More', '', 10010, 19, 1, '', '', '', 0, 2, 0, 1, 1),
(10052, 'Instituto Tecnologico y de Estudios Superiores de Monterrey', 'ITES', '', 10010, 19, 1, '', '', '', 0, 2, 0, 1, 1),
(10053, 'Universidad Nacional de Colombia', 'UNAL', '', 10004, 10, 1, '', '', '', 0, 2, 0, 1, 1),
(10058, 'CENTRO DE INVESTIGACIONES BIOL�GICAS DEL NOROESTE', 'CIBN', 'Mar Bermejo No. 195, Col. Playa Palo de Santa Rita, AP 128 La Paz, Baja California Sur, 23090', 10010, 19, 1, '+ 52 612 (12) 3 84 84 ext 3192', 'http://www.cibnor.mx', '', 0, 2, 0, 1, 1),
(10067, 'Instituto Nacional de Pesquisas Espaciais', 'INPE', '', 10003, 12, 1, '', '', '', 0, 2, 0, 1, 1),
(10068, 'Universidad de Carabobo', 'UC', '', 10008, 15, 0, '', 'http://www.uc.edu.ve/', '', 0, 2, 0, 1, 1),
(10069, 'Universidad de La Sabana', 'UNIS', '', 10004, 10, 1, '', '', '', 0, 2, 0, 1, 1),
(10070, 'Universidad de Costa Rica', 'UCR', '', 10015, 58, 1, '', '', '', 0, 2, 0, 1, 1),
(10071, 'Universidad Jorge Tadeo Lozano', 'UTAD', '', 10004, 10, 1, '', '', '', 0, 2, 0, 1, 1),
(10072, 'Universidad de Cauca', 'UCAU', '', 10004, 10, 1, '', '', '', 0, 2, 0, 1, 1),
(10074, 'Universidad de Monterrey', 'UDEM', '', 10010, 99, 1, '', '', '', 0, 2, 0, 1, 1),
(10077, 'Universidad An�huac', 'ANA', '', 10010, 31, 1, '', '', '', 0, 2, 0, 1, 1),
(10078, 'Pontificia Universidad Javeriana Cali', 'PUJ', '', 10004, 36, 1, '', '', '', 0, 2, 0, 1, 1),
(10079, 'Universidad Aut�noma de Bucaramanga', 'UNAB', '', 10004, 37, 1, '', '', '', 0, 2, 0, 1, 1),
(10080, 'Escuela Colombiana de Ingenier�a', 'ECI', '', 10004, 37, 1, '', '', '', 0, 2, 0, 1, 1),
(10081, 'Universidad Aut�noma de Occidente', 'UAO', '', 10004, 37, 1, '', '', '', 0, 2, 0, 1, 1),
(10087, 'Universidad del Norte', 'UNIN', '', 10004, 37, 1, '', '', '', 0, 2, 0, 1, 1),
(10090, 'Universidad EAFIT', 'EAFI', 'Carrera 49 - 7 Sur 50', 10004, 37, 0, '(57) (4) - 2619500', 'http://www.eafit.edu.co', '', 0, 2, 0, 1, 1),
(10095, 'Universidad Tecnol�gica Equinoccial', 'UTE', '', 10019, 60, 1, '', '', '', 0, 2, 0, 1, 1),
(10098, 'Universidad de C�diz', 'UCA', '', 10005, 47, 1, '', '', '', 0, 2, 0, 1, 1),
(10099, 'Universidad Apec', 'APEC', '', 10021, 62, 1, '', '', '', 0, 2, 0, 1, 1),
(10100, 'Pontificia Universidad Cat�lica de Valpara�so', 'UCV', '', 10020, 57, 1, '', '', '', 0, 2, 0, 1, 1),
(10102, 'Universidad Polit�cnica de Valencia', 'UPV', '', 10005, 50, 1, '', '', '', 0, 2, 0, 1, 1),
(10103, 'University of South Florida', 'USF', '', 10002, 51, 1, '', '', '', 0, 2, 0, 1, 1),
(10127, 'Universidade Federal de Minas Gerais', 'UFMG', '', 10003, 64, 1, '', '', '', 0, 2, 0, 1, 1),
(10129, 'Universidad T�cnica Particular de Loja.', 'UTPL', '', 10019, 67, 1, '(593-7) 2570-275', 'http://www.utpl.edu.ec/', '', 0, 2, 0, 0, 1),
(10135, 'Universidad del Rosario', 'UR', '', 10004, 10, 0, '', '', '', 0, 1, 0, 1, 1),
(10142, 'Universidad del Valle', 'UDV', '', 10004, 36, 0, '', '', '', 1, 0, 0, 1, 1),
(10146, 'Universidade Federal de Goi�s', 'UFGO', '', 10003, 75, 1, '', '', '', 0, 2, 0, 1, 1),
(10149, 'Instituto Nacional de Astrof�sica, Optica y Electr�nica', 'INAO', 'Luis Enrique Erro N0. 1. Tonantzintla, Puebla Mex.', 10010, 77, 1, '01-2222-66-31-00 Ext:7053', '', '', 0, 2, 0, 1, 1),
(10151, 'Escuela Militar de Ingenier�a', 'EMI', 'Zona Alto Irpavi', 10027, 79, 1, '2799369 ? 2793155 - 2793144', 'http://www.emi.edu.bo/', '', 0, 1, 0, 1, 1),
(10158, 'UNIVERSIDAD CATOLICA BOLIVIANA SAN PABLO', 'UCB', '', 10027, 86, 1, '', '', '', 0, 2, 0, 1, 1),
(10160, 'Universidade Do Vale Do Paraiba', 'UNIV', '', 10003, 20, 1, '', '', '', 0, 2, 0, 1, 1),
(10168, 'Universidad de Talca', 'UTAL', '', 10020, 95, 1, '', '', '', 0, 1, 0, 1, 1),
(10177, 'Universidad Metropolitana', 'UNIM', '', 10008, 29, 0, '', '', '', 0, 2, 0, 1, 1),
(10178, 'Universidad de las Am�ricas', 'UDLA', '', 10010, 77, 1, '', 'http://info.pue.udlap.mx/', '', 0, 2, 0, 1, 1),
(10181, 'UNIVERSIDAD FRAY LUCA PACCIOLI', 'UFLP', 'ZARCO # 8 COL. CENTRO', 10010, 106, 1, '7773121055', '', '', 0, 2, 0, 1, 1),
(10185, 'Escuela Polit�cnica Nacional', 'EPN', '', 10019, 60, 1, '', '', '', 0, 2, 0, 1, 1),
(10188, 'Fundaci�n Tarija Digital', 'FTD', '', 10027, 114, 1, '', '', '', 0, 2, 0, 1, 1),
(10189, 'Universidad Mayor de San Andr�s', 'UMSA', '', 10027, 79, 1, '', '', '', 0, 2, 0, 1, 1),
(10194, 'Universidad Centroamericana', 'UCA', '', 10033, 116, 1, '', 'http://www.uca.edu.ni/', '', 0, 2, 0, 1, 1),
(10255, 'Universidad Nacional del Noroeste de la Provincia de Buenos Aires', 'UNNO', '', 10001, 59, 0, '', '', '', 0, 2, 0, 1, 1),
(10413, 'Universidad Privada Boliviana', 'UPD', '-', 10027, 0, 1, '-', 'www.upb.edu', '', 0, 2, 0, 1, 1),
(10469, 'Universidad de la Rep�blica', 'UDEL', 'Av. 18 de Julio 1968', 10014, 18, 1, '(598 2) 4009201', 'http://www.universidad.edu.uy/index.php', '', 0, 2, 0, 1, 1);

-- 
-- Volcar la base de datos para la tabla `paises`
-- 

INSERT INTO `paises` (`Id`, `Nombre`, `Abreviatura`, `permite_revista`, `permite_libro`, `permite_tesis`, `permite_patente`, `permite_congreso`, `esCentralizado`) VALUES 
(10001, 'ARGENTINA', 'ARG', 0, 0, 0, 0, 0, 0),
(10002, 'USA', 'USA', 0, 0, 0, 1, 0, 0),
(10003, 'BRASIL', 'BR', 0, 0, 0, 0, 0, 0),
(10004, 'COLOMBIA', 'COL', 0, 0, 0, 0, 0, 0),
(10005, 'ESPA�A', 'ESP', 0, 0, 0, 0, 0, 0),
(10007, 'PERU', 'PER', 0, 0, 0, 0, 0, 0),
(10008, 'VENEZUELA', 'VE', 0, 0, 0, 0, 0, 0),
(10010, 'MEXICO', 'MEX', 0, 0, 0, 0, 0, 0),
(10015, 'COSTA RICA', 'CR', 0, 0, 0, 0, 0, 0),
(10014, 'URUGUAY', 'UY', 0, 0, 0, 0, 0, 0),
(10034, 'FRANCIA', 'FR', 0, 0, 0, 0, 0, 0),
(10018, 'NORUEGA', 'NOR', 0, 0, 0, 0, 0, 0),
(10019, 'ECUADOR', 'ECU', 0, 0, 0, 0, 0, 0),
(10020, 'CHILE', 'CHI', 0, 0, 0, 0, 0, 0),
(10021, 'REPUBLICA DOMINICANA', 'DOM', 0, 0, 0, 0, 0, 0),
(10027, 'BOLIVIA', 'BOL', 0, 0, 0, 0, 0, 0),
(10033, 'NICARAGUA', 'NIC', 0, 0, 0, 0, 0, 0);


