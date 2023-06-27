module.exports = [
  {
    uuid: '5dc2c983-3932-5bc7-b246-dc5f088c212e',
    name: 'FUNIBER',
    fullname: 'Fundación Universitaria Iberoamericana',
    abbreviation: 'FBR',
    domain: 'funiber.org',
    token: 'ccd2e5fb82c4ab110c036680d320244e',
    website: 'http://localhost/campus',
    rest_path: '/webservice/rest/server.php',
    modality: 'virtual',
    translations: JSON.stringify({
      en_US: 'Iberoamerican University Foundation',
      pt_BR: 'Fundação Universitária Iberoamericana',
      pt_PT: 'Fundação Universitária Iberoamericana',
      fr_FR: 'Fondation Universitaire Ibéro-américaine',
      it_IT: 'Fondazione Universitaria Iberoamericana',
      zh_CN: '伊比利亚美洲大学基金会',
    }),
    created_at: new Date(),
    campus_uuid: '1a8e759c-e427-4d00-94f2-4b4d16b3a893', // match service = uuid institution db

    updated_at: new Date(),
  },
  {
    uuid: '57699b8b-60a1-53a6-bd28-e0fd5f3ea9a9',
    name: 'UNEATLANTICO',
    fullname: 'Universidad Europea del Atlántico',
    abbreviation: 'UEA',
    domain: 'uneatlantico.es',
    token: 'ccd2e5fb82c4ab110c036680d320244e',
    website: 'http://localhost/campus',
    rest_path: '/webservice/rest/server.php',
    modality: 'virtual',
    translations: JSON.stringify({
      en_US: 'European University of the Atlantic',
      pt_BR: 'Universidade Europeia do Atlântico',
      pt_PT: 'Universidade Europeia do Atlântico',
      fr_FR: "Université européenne de l'Atlantique",
      it_IT: "Università Europea dell'Atlantico",
      zh_CN: '大西洋欧洲大学',
    }),
    created_at: new Date(),
    campus_uuid: '1a8e759c-e427-4d00-94f2-4b4d16b3a893', // match service = uuid institution db

    updated_at: new Date(),
  },
  {
    uuid: 'bbed52e6-5a60-56ad-940f-be6e6d8fe8a5',
    name: 'UNIB',
    fullname: 'Universidad Internacional Iberoamericana',
    abbreviation: 'UNIB',
    domain: 'unib.org',
    token: '637dab935fc582901b644c9485f88292',
    website: 'http://localhost/campus',
    rest_path: '/webservice/rest/server.php',
    modality: 'virtual',
    translations: JSON.stringify({
      en_US: 'International Ibero-American University',
      pt_BR: 'Universidade Internacional Iberoamericana',
      pt_PT: 'Universidade Internacional Iberoamericana',
    }),
    campus_uuid: '1a8e759c-e427-4d00-94f2-4b4d16b3a893', // match service = uuid institution db
    created_at: new Date(),
    updated_at: new Date(),
  },
  {
    uuid: '4fc725b9-e2b6-54dc-ac5d-ba9e5cdba862',
    name: 'UNINI',
    fullname: 'Universidad Internacional Iberoamericana',
    abbreviation: 'UNINIMX',
    domain: 'unini.edu.mx',
    token: 'ccd2e5fb82c4ab110c036680d320244e',
    website: 'http://localhost/campus',
    rest_path: '/webservice/rest/server.php',
    modality: 'virtual',
    translations: JSON.stringify({
      en_US: 'International Ibero-American University',
      pt_BR: 'Universidade Internacional Iberoamericana',
      pt_PT: 'Universidade Internacional Iberoamericana',
    }),
    created_at: new Date(),
    campus_uuid: '1a8e759c-e427-4d00-94f2-4b4d16b3a893', // match service = uuid institution db

    updated_at: new Date(),
  },
  {
    uuid: 'd72ebd7f-3766-5f24-a3ff-f6c3bf56eb81',
    name: 'UNINCOL',
    fullname: 'Fundación Universitaria Internacional de Colombia',
    abbreviation: 'UNINCOL',
    domain: 'unincol.edu.co',
    token: 'ccd2e5fb82c4ab110c036680d320244e',
    website: 'http://localhost/campus',
    rest_path: '/webservice/rest/server.php',
    modality: 'virtual',
    translations: JSON.stringify({
      en_US: 'International University Foundation of Colombia',
      pt_PT: 'Fundação Universitária Internacional da Colômbia',
      pt_BR: 'Fundação Universitária Internacional da Colômbia',
    }),
    created_at: new Date(),
    campus_uuid: '1a8e759c-e427-4d00-94f2-4b4d16b3a893', // match service = uuid institution db

    updated_at: new Date(),
  },







  // ======= in my moodle
  {
    uuid: 'b905084c-75c3-5738-a4f0-e8cd73aef0c5',
    name: 'UNIC',
    fullname: 'Universidade Internacional do Cuanza',
    abbreviation: 'UNIC',
    domain: 'unic.co.ao',


    token: 'ccd2e5fb82c4ab110c036680d320244e',
    website: 'http://localhost/campus',


    rest_path: '/webservice/rest/server.php',

    modality: 'presential', // moodle - local message broker

    translations: JSON.stringify({
      en_US: 'International University of Cuanza',
      es_ES: 'Universidad Internacional de Cuanza',
    }),
    
    campus_uuid: '1a8e759c-e427-4d00-94f2-4b4d16b3a893', // match service = uuid institution db + institution abreviation event  <- campus_reference
    
    created_at: new Date(),
    updated_at: new Date(),
  },





  

  {
    uuid: '4f72cec2-fc61-5f68-89ff-c6da026d89f8',
    name: 'UNIROMANA',
    fullname: 'Universidad de la Romana',
    abbreviation: 'UNIROMANA',
    domain: 'uniromana.do',
    token: 'ccd2e5fb82c4ab110c036680d320244e',
    website: 'http://localhost/campus',
    rest_path: '/webservice/rest/server.php',
    modality: 'virtual',
    translations: JSON.stringify({
      en_US: 'University of la Romana',
      es_ES: 'Universidad de la Romana',
    }),
    created_at: new Date(),
    campus_uuid: '1a8e759c-e427-4d00-94f2-4b4d16b3a893', // match service = uuid institution db

    updated_at: new Date(),
  },
];
