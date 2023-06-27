
SELECT persona.nombre as firstname,
           persona.apellido as lastname,
           persona.id as id,
           credencial_persona.username as login,
           credencial_persona.password as password,
           persona_email.email as email,
           pais.iso3166_code2 as country,
           poblacion.nombre as city,
           ic.abreviatura_iso_639_1 as language,
           pi.abreviatura as course,
           vi.version as course_version,
           ico.abreviatura_iso_639_1 as course_language,
           inscripcion.fecha_inscripcion as course_enroldate,
           inscripcion.fecha_inicio_programa as course_startdate,
           inscripcion.fecha_fin_prorroga as course_enddate,
           organizacion.sigla as course_institution,
           inscripcion.grupo_panal as course_group,
           e.es_ES as course_status,
           i.es_ES as course_event,
           pe.abreviatura as optative,
           ve.version as optative_version
      FROM inscripcion
INNER JOIN persona
           ON inscripcion.persona_id = persona.id
INNER JOIN credencial_persona
           ON persona.id = credencial_persona.persona_id
           AND credencial_persona.habilitado = '1'
 LEFT JOIN persona_email
           ON persona.id = persona_email.persona_id
           AND persona_email.nacceso = 'publico'
 LEFT JOIN pais
           ON persona.pais_id = pais.id
 LEFT JOIN poblacion
           ON persona.poblacion_id = poblacion.id
INNER JOIN entidad_idioma eca
           ON inscripcion.id = eca.class_id
           AND eca.class = 'Inscripcion'
           AND eca.tipo = '_CAMPUS'
INNER JOIN idioma ic
           ON eca.idioma_id = ic.id
INNER JOIN entidad_idioma eco
           ON inscripcion.id = eco.class_id
           AND eco.class = 'Inscripcion'
           AND eco.tipo = '_CONTENIDO'
INNER JOIN idioma ico
           ON eco.idioma_id = ico.id
INNER JOIN programa pi
           ON inscripcion.programa_id = pi.id
INNER JOIN programa_version vi
           ON inscripcion.programa_version_id = vi.id
INNER JOIN estado
           ON inscripcion.estado_id = estado.id
 LEFT JOIN incidencia
           ON inscripcion.incidencia_id = incidencia.id
INNER JOIN titulacion
           ON inscripcion.id = titulacion.inscripcion_id
           AND titulacion.nacceso = 'publico'
INNER JOIN resolucion
           ON titulacion.resolucion_id = resolucion.id
INNER JOIN i18n_texto r
           ON resolucion.nombre_titulacion = r.id
INNER JOIN i18n_texto e
           ON estado.nombre = e.id
INNER JOIN i18n_texto i
           ON incidencia.nombre = i.id
INNER JOIN convenio
           ON resolucion.convenio_id = convenio.id
INNER JOIN organizacion
           ON convenio.organizacion_id = organizacion.id
 LEFT JOIN especializacion
           ON inscripcion.id = especializacion.inscripcion_id
           AND especializacion.nacceso = 'publico'
 LEFT JOIN programa_version ve
           ON especializacion.programa_version_id = ve.id
 LEFT JOIN programa pe
           ON ve.programa_id = pe.id
     WHERE inscripcion.nacceso = 'publico'
       AND inscripcion.persona_id = :idpersona
  GROUP BY inscripcion.id,
           organizacion.id,
           especializacion.id,
           persona_email.email;
