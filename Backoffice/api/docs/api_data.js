define({ "api": [
  {
    "type": "get",
    "url": "http://51.91.8.97:18280/serie/{id}/pictures",
    "title": "Récupérer toutes les photos pas associée à une série.",
    "name": "dede",
    "group": "Picture",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl http://51.91.8.97:18280/serie/163effe5-b150-4e2d-8b65-91fef987dcb2/pictures",
        "type": "curl"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "BearerToken",
            "optional": false,
            "field": "Authorization",
            "description": "<p>JWT de l'utilisateur connecte.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n     \"Token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ19\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "Id",
            "description": "<p>id de la série dans laquelle est cherché.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n\"type\": \"collection\",\n\"pictures\": [\n     {\n         \"id\": \"6770cc1c-49dc-48e0-8822-5ce6e72151f8\"\n     },\n     {\n         \"id\": \"6770cc1c-49dc-48e0-8822-5ce6e72151f9\"\n     }\n  ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "../src/control/BackofficeController.php",
    "groupTitle": "Picture"
  },
  {
    "type": "post",
    "url": "http://51.91.8.97:18280/pictures",
    "title": "Envoyer une photo.",
    "name": "insertPicture",
    "group": "Picture",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X POST http://51.91.8.97:18280/pictures",
        "type": "curl"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "BearerToken",
            "optional": false,
            "field": "Authorization",
            "description": "<p>JWT de l'utilisateur connecte.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n     \"Token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ19\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>description de la photo.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "latitude",
            "description": "<p>coordonnées gps latitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "longitude",
            "description": "<p>coordonnées gps longitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "URL",
            "optional": false,
            "field": "link",
            "description": "<p>liens de la photo vers ImgBB.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "    {\n\"description\" : \"Tour Eiffel\",\n\"latitude\" : 48.8584,\n\"longitude\" : 2.2945,\n\"link\" : \"https://www.w3schools.com/php/filter_sanitize_url.asp\"\n    }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"la photo a bien été ajoutee\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "../src/control/BackofficeController.php",
    "groupTitle": "Picture"
  },
  {
    "type": "get",
    "url": "http://51.91.8.97:18280/serie/{id}/pics",
    "title": "Récupérer toutes les photos associée à une série.",
    "name": "pepe",
    "group": "Picture",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl http://51.91.8.97:18280/serie/163effe5-b150-4e2d-8b65-91fef987dcb2/pics",
        "type": "curl"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "BearerToken",
            "optional": false,
            "field": "Authorization",
            "description": "<p>JWT de l'utilisateur connecte.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n     \"Token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ19\".\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "Id",
            "description": "<p>id de la série.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n  \"type\": \"collection\",\n  \"count\": 1\n  \"pictures\": [\n        {\n          \"id\": \"09dc81ea-d6b7-460d-a9cb-a50bf7b2a132\",\n          \"description\": \"atsumare\",\n          \"latitude\": 48.8738,\n          \"longitude\": 2.2950,\n          \"link\": \"https://www.w3schools.com/php/filter_sanitize_url.asp\",\n          \"created_at\": \"2020-03-25 21:39:58\",\n          \"updated_at\": \"2020-03-25 21:39:58\",\n          \"id_user\": \"d2b66cbc-a1f9-4e80-bb22-65b07455433c\",\n        }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "../src/control/BackofficeController.php",
    "groupTitle": "Picture"
  },
  {
    "type": "put",
    "url": "http://51.91.8.97:18280/pictures/{id}",
    "title": "Modifier une photo.",
    "name": "updatePicture",
    "group": "Picture",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X PUT http://51.91.8.97:18280/pictures/3a192e17-e853-41af-80b7-c457e860e166",
        "type": "curl"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "BearerToken",
            "optional": false,
            "field": "Authorization",
            "description": "<p>JWT de l'utilisateur connecte.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n     \"Token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ19\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>id de la photo a modifié.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>description de la photo.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "latitude",
            "description": "<p>coordonnées gps latitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "longitude",
            "description": "<p>coordonnées gps longitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "URL",
            "optional": false,
            "field": "link",
            "description": "<p>liens de la photo vers ImgBB.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "    {\n\"description\" : \"Arc de Triomphe\",\n\"latitude\" : 48.8738,\n\"longitude\" : 2.2950,\n\"link\" : \"https://www.w3schools.com/php/filter_sanitize_url.asp\"\n    }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"la photo a bien été modifiee\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "../src/control/BackofficeController.php",
    "groupTitle": "Picture"
  },
  {
    "type": "get",
    "url": "http://51.91.8.97:18280/series/{id}",
    "title": "Récupérer une serie.",
    "name": "getSerie",
    "group": "Serie",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl http://51.91.8.97:18280/series/163effe5-b150-4e2d-8b65-91fef987dcb2",
        "type": "curl"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "BearerToken",
            "optional": false,
            "field": "Authorization",
            "description": "<p>JWT de l'utilisateur connecte.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n     \"Token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ19\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>identifiant de la série recherchée.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n\"type\": \"collection\",\n\"serie\": {\n\"id\": \"163effe5-b150-4e2d-8b65-91fef987dcb2\",\n\"city\": \"test\",\n\"distance\": 2121,\n\"latitude\": 48.8566,\n\"longitude\": 48.8566,\n\"zoom\": 7,\n\"nb_pictures\": 4,\n\"created_at\": \"2020-03-21 13:22:55\",\n\"updated_at\": \"2020-03-21 13:22:55\",\n\"id_user\": \"d2b66cbc-a1f9-4e80-bb22-65b07455433c\"\n}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "../src/control/BackofficeController.php",
    "groupTitle": "Serie"
  },
  {
    "type": "get",
    "url": "http://51.91.8.97:18280/series",
    "title": "Récupérer toutes les series.",
    "name": "getSeries",
    "group": "Serie",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl http://51.91.8.97:18280/series",
        "type": "curl"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "BearerToken",
            "optional": false,
            "field": "Authorization",
            "description": "<p>JWT de l'utilisateur connecte.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n     \"Token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ19\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n\"type\": \"collection\",\n\"series\": [\n{\n\"id\": \"163effe5-b150-4e2d-8b65-91fef987dcb2\",\n\"city\": \"test\",\n\"distance\": 2121,\n\"latitude\": 48.8566,\n\"longitude\": 2.2950,\n\"zoom\": 7,\n\"nb_pictures\": 4,\n\"created_at\": \"2020-03-21 13:22:55\",\n\"updated_at\": \"2020-03-21 13:22:55\",\n\"id_user\": \"d2b66cbc-a1f9-4e80-bb22-65b07455433c\"\n},\n{\n\"id\": \"52e70cc6-68fe-4de3-ada3-e59c3c2b5f2f\",\n\"city\": \"test\",\n\"distance\": 2121,\n\"latitude\": 48.8566,\n\"longitude\": 2.2950,\n\"zoom\": 7,\n\"nb_pictures\": 4,\n\"created_at\": \"2020-03-21 18:56:38\",\n\"updated_at\": \"2020-03-21 18:56:38\",\n\"id_user\": \"d2b66cbc-a1f9-4e80-bb22-65b07455433c\"\n}\n]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "../src/control/BackofficeController.php",
    "groupTitle": "Serie"
  },
  {
    "type": "post",
    "url": "http://51.91.8.97:18280/series",
    "title": "Creer une Serie.",
    "name": "insertSerie",
    "group": "Serie",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X POST http://51.91.8.97:18280/series",
        "type": "curl"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "BearerToken",
            "optional": false,
            "field": "Authorization",
            "description": "<p>JWT de l'utilisateur connecte.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n     \"Token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ19\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city",
            "description": "<p>La ville de la serie.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "distance",
            "description": "<p>De la serie.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "latitude",
            "description": "<p>coordonnées gps latitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "longitude",
            "description": "<p>coordonnées gps longitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "zoom",
            "description": "<p>l'indice de zoom.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "nb_pictures",
            "description": "<p>Le nombre de photos associe à cette série.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "    {\n       \"city\" : \"Paris\",\n\"distance\" : 1000,\n\"latitude\" : 48.8566,\n\"longitude\" : 2.3522,\n\"zoom\" : 7,\n\"nb_pictures\" : 4\n    }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"une nouvelle serie a bien été crée\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "../src/control/BackofficeController.php",
    "groupTitle": "Serie"
  },
  {
    "type": "post",
    "url": "http://51.91.8.97:18280/serie/{id}/picture",
    "title": "Associer une photo a une serie.",
    "name": "seriePicture",
    "group": "Series",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X POST http://51.91.8.97:18280/serie/53e5def2-63ee-4531-ac9f-d12a80af9247/picture",
        "type": "curl"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "BearerToken",
            "optional": false,
            "field": "Authorization",
            "description": "<p>JWT de l'utilisateur connecte.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n     \"Token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ19\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>id de la série a associé.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "Id",
            "description": "<p>Id de la photo a associé.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\n   \"id\": \"6770cc1c-49dc-48e0-8822-5ce6e72151f9\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"cette photo a bien ete associe a cette serie.\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "../src/control/BackofficeController.php",
    "groupTitle": "Series"
  },
  {
    "type": "post",
    "url": "http://51.91.8.97:18280/series/{id}/pictures",
    "title": "Associer des photos a une series.",
    "name": "seriesPictures",
    "group": "Series",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X POST http://51.91.8.97:18280/series/53e5def2-63ee-4531-ac9f-d12a80af9247/pictures",
        "type": "curl"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "BearerToken",
            "optional": false,
            "field": "Authorization",
            "description": "<p>JWT de l'utilisateur connecte.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n     \"Token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ19\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "Id",
            "description": "<p>id de la série a associé.</p>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "Pictures",
            "description": "<p>Tableau contenant les Ids des photos a associé.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "     {\n\"pictures\": [{\n\"id\": \"3a192e17-e853-41af-80b7-c457e860e166\"\n},\n{\n\"id\": \"6770cc1c-49dc-48e0-8822-5ce6e72151f9\"\n}\n]\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"les photos ont bien été associées à cette série.\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "../src/control/BackofficeController.php",
    "groupTitle": "Series"
  },
  {
    "type": "put",
    "url": "http://51.91.8.97:18280/series/{id}",
    "title": "Modifier une Serie.",
    "name": "updateSerie",
    "group": "Serie",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X PUT http://51.91.8.97:18280/series/5451d518-6863-409b-af77-0c29119b931c",
        "type": "curl"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "BearerToken",
            "optional": false,
            "field": "Authorization",
            "description": "<p>JWT de l'utilisateur connecte.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n     \"Token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ19\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>id de la série a modifié.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city",
            "description": "<p>La ville de la serie.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "distance",
            "description": "<p>De la serie.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "latitude",
            "description": "<p>coordonnées gps latitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "longitude",
            "description": "<p>coordonnées gps longitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "zoom",
            "description": "<p>l'indice de zoom.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "nb_pictures",
            "description": "<p>Le nombre de photos associe à cette série.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "    {\n       \"city\" : \"Bordeaux\",\n\"distance\" : 1000,\n\"latitude\" : 44.8378,\n\"longitude\" : 0.5792,\n\"zoom\" : 7,\n\"nb_pictures\" : 7\n    }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"la serie a bien été modifie\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "../src/control/BackofficeController.php",
    "groupTitle": "Serie"
  },
  {
    "type": "post",
    "url": "http://51.91.8.97:18280/user/signin",
    "title": "se connecter avec un membre.",
    "name": "userSignin",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "Basic_Auth",
            "optional": false,
            "field": "Authorization",
            "description": "<p>email et mot de passe de l'utilisateur.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "JWT",
            "description": "<p>token de session.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n   \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkuYmFja29mZmljZS5sb2NhbCIsImF1ZCI6Imh0dHA6XC9cL2FwaS5iYWNrb2ZmaWNlLmxvY2FsIiwiaWF0IjoxNTg0ODc0NjY4LCJleHAiOjE1ODQ4NzgyNjgsInVpZCI6ImRlYWFjMGE5LTE5ZmEtNDU2OS05YzNjLTZkNDk4N2EyZDJhMCIsImx2bCI6MX0.UzEOK9IdobzxZboV9JNa6nYHXWNRv7dpANYYq1GFJMfxqzMTyk3N-f60k1FGNyk1GwU5PLwGcHSSHNIRM3VZwA\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "../src/control/BackofficeController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "http://51.91.8.97:18280/user/signup",
    "title": "Creer un membre.",
    "name": "userSignup",
    "group": "User",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X POST http://51.91.8.97:18280/user/signup",
        "type": "curl"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "firstname",
            "description": "<p>Le prenom du membre.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lastname",
            "description": "<p>Le nom du membre.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>l'addresse email du membre.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>Le mot de passe.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>Le numero de telephone du memebre.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "street_number",
            "description": "<p>Le numero de la rue.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "street",
            "description": "<p>Le nom de la rue.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city",
            "description": "<p>Le nom de la ville.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "zip_code",
            "description": "<p>Le code postal.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "    {\n\"firstname\": \"test\",\n\"lastname\": \"test\",\n\"email\": \"test@gmail.com\",\n\"password\": \"test\",\n\"phone\": \"0612345678\",\n\"street_number\": 23,\n\"street\": \"rue de la paix\",\n\"city\": \"Paris\",\n\"zip_code\": 75000\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"votre compte utilisateur a bien été crée\"\n}.",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "../src/control/BackofficeController.php",
    "groupTitle": "User"
  }
] });
