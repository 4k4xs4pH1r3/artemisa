<?php
require_once('../../funciones/clases/fpdf/font/makefont/makefont.php');
MakeFont('UniversityRomanBoldBT.ttf','UniversityRomanBoldBT.afm','cp1252');
/*$type='TrueType';
$name='UniversityRomanBT-Bold';
$desc=array('Ascent'=>913,'Descent'=>-287,'CapHeight'=>639,'Flags'=>32,'FontBBox'=>'[-167 -287 1280 913]','ItalicAngle'=>0,'StemV'=>120,'MissingWidth'=>600);
$up=-127;
$ut=47;
$cw=array(
	chr(0)=>600,chr(1)=>600,chr(2)=>600,chr(3)=>600,chr(4)=>600,chr(5)=>600,chr(6)=>600,chr(7)=>600,chr(8)=>600,chr(9)=>600,chr(10)=>600,chr(11)=>600,chr(12)=>600,chr(13)=>600,chr(14)=>600,chr(15)=>600,chr(16)=>600,chr(17)=>600,chr(18)=>600,chr(19)=>600,chr(20)=>600,chr(21)=>600,
	chr(22)=>600,chr(23)=>600,chr(24)=>600,chr(25)=>600,chr(26)=>600,chr(27)=>600,chr(28)=>600,chr(29)=>600,chr(30)=>600,chr(31)=>600,' '=>308,'!'=>213,'"'=>331,'#'=>769,'$'=>426,'%'=>641,'&'=>674,'\''=>170,'('=>292,')'=>292,'*'=>421,'+'=>833,
	','=>213,'-'=>278,'.'=>213,'/'=>312,'0'=>616,'1'=>275,'2'=>380,'3'=>396,'4'=>421,'5'=>391,'6'=>435,'7'=>366,'8'=>449,'9'=>435,':'=>213,';'=>213,'<'=>833,'='=>833,'>'=>833,'?'=>387,'@'=>986,'A'=>451,
	'B'=>514,'C'=>620,'D'=>674,'E'=>421,'F'=>396,'G'=>685,'H'=>509,'I'=>250,'J'=>394,'K'=>495,'L'=>391,'M'=>565,'N'=>493,'O'=>752,'P'=>625,'Q'=>752,'R'=>644,'S'=>528,'T'=>454,'U'=>477,'V'=>451,'W'=>648,
	'X'=>463,'Y'=>463,'Z'=>410,'['=>292,'\\'=>312,']'=>292,'^'=>1000,'_'=>500,'`'=>500,'a'=>373,'b'=>523,'c'=>417,'d'=>523,'e'=>486,'f'=>199,'g'=>394,'h'=>380,'i'=>181,'j'=>187,'k'=>380,'l'=>187,'m'=>528,
	'n'=>380,'o'=>505,'p'=>523,'q'=>523,'r'=>296,'s'=>361,'t'=>287,'u'=>380,'v'=>343,'w'=>486,'x'=>366,'y'=>338,'z'=>370,'{'=>500,'|'=>500,'}'=>500,'~'=>833,chr(127)=>600,chr(128)=>600,chr(129)=>600,chr(130)=>600,chr(131)=>600,
	chr(132)=>600,chr(133)=>600,chr(134)=>600,chr(135)=>600,chr(136)=>600,chr(137)=>600,chr(138)=>600,chr(139)=>600,chr(140)=>600,chr(141)=>600,chr(142)=>600,chr(143)=>600,chr(144)=>600,chr(145)=>600,chr(146)=>600,chr(147)=>600,chr(148)=>600,chr(149)=>600,chr(150)=>600,chr(151)=>600,chr(152)=>600,chr(153)=>600,
	chr(154)=>600,chr(155)=>600,chr(156)=>600,chr(157)=>600,chr(158)=>600,chr(159)=>600,chr(160)=>308,chr(161)=>213,chr(162)=>435,chr(163)=>428,chr(164)=>600,chr(165)=>463,chr(166)=>528,chr(167)=>421,chr(168)=>361,chr(169)=>822,chr(170)=>280,chr(171)=>340,chr(172)=>833,chr(173)=>278,chr(174)=>822,chr(175)=>500,
	chr(176)=>329,chr(177)=>833,chr(178)=>251,chr(179)=>261,chr(180)=>410,chr(181)=>547,chr(182)=>500,chr(183)=>213,chr(184)=>370,chr(185)=>182,chr(186)=>379,chr(187)=>340,chr(188)=>819,chr(189)=>898,chr(190)=>463,chr(191)=>387,chr(192)=>451,chr(193)=>451,chr(194)=>451,chr(195)=>451,chr(196)=>451,chr(197)=>451,
	chr(198)=>630,chr(199)=>620,chr(200)=>421,chr(201)=>421,chr(202)=>421,chr(203)=>421,chr(204)=>250,chr(205)=>250,chr(206)=>250,chr(207)=>250,chr(208)=>674,chr(209)=>493,chr(210)=>752,chr(211)=>752,chr(212)=>752,chr(213)=>752,chr(214)=>752,chr(215)=>833,chr(216)=>752,chr(217)=>477,chr(218)=>477,chr(219)=>477,
	chr(220)=>477,chr(221)=>463,chr(222)=>625,chr(223)=>509,chr(224)=>373,chr(225)=>373,chr(226)=>373,chr(227)=>373,chr(228)=>373,chr(229)=>373,chr(230)=>720,chr(231)=>417,chr(232)=>486,chr(233)=>486,chr(234)=>486,chr(235)=>486,chr(236)=>181,chr(237)=>181,chr(238)=>181,chr(239)=>181,chr(240)=>505,chr(241)=>380,
	chr(242)=>505,chr(243)=>505,chr(244)=>505,chr(245)=>505,chr(246)=>505,chr(247)=>833,chr(248)=>505,chr(249)=>380,chr(250)=>380,chr(251)=>380,chr(252)=>380,chr(253)=>338,chr(254)=>523,chr(255)=>338);
$enc='UTF-85';
$diff='128 /.notdef 130 /.notdef /.notdef /.notdef /.notdef /.notdef /.notdef /.notdef /.notdef /.notdef /.notdef /.notdef 142 /.notdef 145 /.notdef /.notdef /.notdef /.notdef /.notdef /.notdef /.notdef /.notdef /.notdef /.notdef /.notdef /.notdef 158 /.notdef /.notdef 164 /Euro 166 /Scaron 168 /scaron 180 /Zcaron 184 /zcaron 188 /OE /oe /Ydieresis';
$file='UniversityRomanBoldBT.ttf';
$originalsize=47088;
?>
