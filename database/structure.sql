SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `Browsers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Version` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `Elements` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Type` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `Properties` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Display` int(11) NOT NULL DEFAULT '1',
  `Value` varchar(255) NOT NULL,
  `ElementID` int(11) NOT NULL,
  `BrowserID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


SET FOREIGN_KEY_CHECKS = 1;
