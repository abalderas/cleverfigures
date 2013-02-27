-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `parameter` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  PRIMARY KEY (`parameter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregables`
--

CREATE TABLE IF NOT EXISTS `entregables` (
  `ent_id` int(11) NOT NULL AUTO_INCREMENT,
  `ent_entregable` varchar(250) NOT NULL,
  `ent_description` varchar(255) NOT NULL,
  PRIMARY KEY (`ent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones`
--

CREATE TABLE IF NOT EXISTS `evaluaciones` (
  `eva_id` int(11) NOT NULL AUTO_INCREMENT,
  `eva_user` int(11) NOT NULL,
  `eva_revisor` int(11) NOT NULL,
  `eva_revision` int(11) NOT NULL,
  `eva_time` int(11) NOT NULL,
  PRIMARY KEY (`eva_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones_entregables`
--

CREATE TABLE IF NOT EXISTS `evaluaciones_entregables` (
  `eva_id` int(11) NOT NULL,
  `ent_id` int(11) NOT NULL,
  `ee_nota` int(11) NOT NULL,
  `ee_comentario` varchar(250) NOT NULL,
  PRIMARY KEY (`eva_id`,`ent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `replies`
--

CREATE TABLE IF NOT EXISTS `replies` (
  `rep_id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_read` int(11) NOT NULL,
  `rep_new` int(11) NOT NULL,
  PRIMARY KEY (`rep_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

