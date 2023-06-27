SELECT inscripcion.persona_id
      FROM inscripcion
INNER JOIN persona
           ON inscripcion.persona_id = persona.id
INNER JOIN credencial_persona
           ON persona.id = credencial_persona.persona_id
           AND credencial_persona.habilitado = '1'
 LEFT JOIN persona_email
           ON persona.id = persona_email.persona_id
           AND persona_email.nacceso = 'publico'
INNER JOIN titulacion
           ON inscripcion.id = titulacion.inscripcion_id
           AND titulacion.nacceso = 'publico'
INNER JOIN entidad_idioma
           ON inscripcion.id = entidad_idioma.class_id
           AND entidad_idioma.class = 'Inscripcion'
           AND entidad_idioma.tipo IN ('_CAMPUS', '_CONTENIDO')
 LEFT JOIN especializacion
           ON inscripcion.id = especializacion.inscripcion_id
           AND especializacion.nacceso = 'publico'
     WHERE DATE(persona.fecha_modificacion) BETWEEN DATE_SUB(CURDATE(), INTERVAL 4 DAY) AND CURDATE()
        OR DATE(credencial_persona.fecha_creacion) BETWEEN DATE_SUB(CURDATE(), INTERVAL 4 DAY) AND CURDATE()
        OR DATE(credencial_persona.fecha_modificacion) BETWEEN DATE_SUB(CURDATE(), INTERVAL 4 DAY) AND CURDATE()
        OR DATE(persona_email.fecha_creacion) BETWEEN DATE_SUB(CURDATE(), INTERVAL 4 DAY) AND CURDATE()
        OR DATE(persona_email.fecha_modificacion) BETWEEN DATE_SUB(CURDATE(), INTERVAL 4 DAY) AND CURDATE()
        OR DATE(inscripcion.fecha_modificacion) BETWEEN DATE_SUB(CURDATE(), INTERVAL 4 DAY) AND CURDATE()
        OR DATE(inscripcion.fecha_inicio_programa) BETWEEN DATE_SUB(CURDATE(), INTERVAL 4 DAY) AND CURDATE()
        OR DATE(inscripcion.fecha_cambio_estado) BETWEEN DATE_SUB(CURDATE(), INTERVAL 4 DAY) AND CURDATE()
        OR DATE(titulacion.fecha_creacion) BETWEEN DATE_SUB(CURDATE(), INTERVAL 4 DAY) AND CURDATE()
        OR DATE(titulacion.fecha_modificacion) BETWEEN DATE_SUB(CURDATE(), INTERVAL 4 DAY) AND CURDATE()
        OR DATE(titulacion.fecha_cambio_estado) BETWEEN DATE_SUB(CURDATE(), INTERVAL 4 DAY) AND CURDATE()
        OR DATE(entidad_idioma.fecha_modificacion) BETWEEN DATE_SUB(CURDATE(), INTERVAL 4 DAY) AND CURDATE()
        OR DATE(especializacion.fecha_creacion) BETWEEN DATE_SUB(CURDATE(), INTERVAL 4 DAY) AND CURDATE()
        OR DATE(especializacion.fecha_modificacion) BETWEEN DATE_SUB(CURDATE(), INTERVAL 4 DAY) AND CURDATE()
  GROUP BY inscripcion.persona_id;