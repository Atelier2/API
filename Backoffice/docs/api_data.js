define({ "api": [
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "varname1",
            "description": "<p>No type.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "varname2",
            "description": "<p>With type.</p>"
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./docs/main.js",
    "group": "/var/www/html/Atelier2/API/Backoffice/docs/main.js",
    "groupTitle": "/var/www/html/Atelier2/API/Backoffice/docs/main.js",
    "name": ""
  },
  {
    "type": "post",
    "url": "http://api.backoffice.local:19280/picture",
    "title": "Envoyer une photo.",
    "name": "insertPicture",
    "group": "Picture",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X POST http://api.backoffice.local:19280/picture",
        "type": "curl"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "BearerToken",
            "description": "<p>JWT de l'utilisateur connecte.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Description",
            "description": "<p>description de la photo.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Latitude",
            "description": "<p>coordonnées gps latitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Longitude",
            "description": "<p>coordonnées gps longitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "URL",
            "optional": false,
            "field": "Link",
            "description": "<p>liens de la photo vers Clodinary.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "    {\n\"description\" : \"Tour Eiffel\",\n\"latitude\" : \"48.8584° N\",\n\"longitude\" : \"2.2945° E\",\n\"link\" : \"https://www.w3schools.com/php/filter_sanitize_url.asp\"\n    }",
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
    "filename": "./src/control/BackofficeController.php",
    "groupTitle": "Picture"
  },
  {
    "type": "put",
    "url": "http://api.backoffice.local:19280/picture/{id}",
    "title": "Modifier une photo.",
    "name": "updatePicture",
    "group": "Picture",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X PUT http://api.backoffice.local:19280/picture/3a192e17-e853-41af-80b7-c457e860e166",
        "type": "curl"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "BearerToken",
            "description": "<p>JWT de l'utilisateur connecte.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "Id",
            "description": "<p>id de la photo a modifié.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Description",
            "description": "<p>description de la photo.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Latitude",
            "description": "<p>coordonnées gps latitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Longitude",
            "description": "<p>coordonnées gps longitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "URL",
            "optional": false,
            "field": "Link",
            "description": "<p>liens de la photo vers Clodinary.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "    {\n\"description\" : \"Arc de Triomphe\",\n\"latitude\" : \"48.8738° N\",\n\"longitude\" : \"2.2950° E\",\n\"link\" : \"https://www.w3schools.com/php/filter_sanitize_url.asp\"\n    }",
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
    "filename": "./src/control/BackofficeController.php",
    "groupTitle": "Picture"
  },
  {
    "type": "post",
    "url": "http://api.backoffice.local:19280/series",
    "title": "Creer une Serie.",
    "name": "insertSerie",
    "group": "Serie",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X POST http://api.backoffice.local:19280/series",
        "type": "curl"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "BearerToken",
            "description": "<p>JWT de l'utilisateur connecte.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "City",
            "description": "<p>La ville de la serie.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "Distance",
            "description": "<p>De la serie.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Latitude",
            "description": "<p>coordonnées gps latitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Longitude",
            "description": "<p>coordonnées gps longitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "Zoom",
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
          "content": "    {\n       \"city\" : \"Paris\",\n\"distance\" : 1000,\n\"latitude\" : \"48.8566° N\",\n\"longitude\" : \"2.3522° E\",\n\"zoom\" : 7,\n\"nb_pictures\" : 4\n    }",
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
    "filename": "./src/control/BackofficeController.php",
    "groupTitle": "Serie"
  },
  {
    "type": "post",
    "url": "http://api.backoffice.local:19280/series/{id}/pictures",
    "title": "Associer des photos a des series.",
    "name": "seriesPictures",
    "group": "Series",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X POST http://api.backoffice.local:19280/series/53e5def2-63ee-4531-ac9f-d12a80af9247/pictures",
        "type": "curl"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "BearerToken",
            "description": "<p>JWT de l'utilisateur connecte.</p>"
          }
        ]
      }
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
    "filename": "./src/control/BackofficeController.php",
    "groupTitle": "Series"
  },
  {
    "type": "put",
    "url": "http://api.backoffice.local:19280/series/{id}",
    "title": "Modifier une Serie.",
    "name": "updateSerie",
    "group": "Serie",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X PUT http://api.backoffice.local:19280/series/5451d518-6863-409b-af77-0c29119b931c",
        "type": "curl"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "BearerToken",
            "description": "<p>JWT de l'utilisateur connecte.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "Id",
            "description": "<p>id de la série a modifié.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "City",
            "description": "<p>La ville de la serie.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "Distance",
            "description": "<p>De la serie.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Latitude",
            "description": "<p>coordonnées gps latitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "Longitude",
            "description": "<p>coordonnées gps longitude.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "Zoom",
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
          "content": "    {\n       \"city\" : \"Bordeaux\",\n\"distance\" : 1000,\n\"latitude\" : \"44.8378° N\",\n\"longitude\" : \"0.5792° W\",\n\"zoom\" : 7,\n\"nb_pictures\" : 7\n    }",
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
    "filename": "./src/control/BackofficeController.php",
    "groupTitle": "Serie"
  },
  {
    "type": "post",
    "url": "http://api.backoffice.local:19280/user/signin",
    "title": "Creer un membre.",
    "name": "userSignin",
    "group": "User",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X POST http://api.backoffice.local:19280/user/signin",
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
    "filename": "./src/control/BackofficeController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "http://api.backoffice.local:19280/user/signup",
    "title": "se connecter avec un membre.",
    "name": "userSignup",
    "group": "User",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "BasicAuth",
            "description": "<p>user_email  &amp; user_password.</p>"
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
    "filename": "./src/control/BackofficeController.php",
    "groupTitle": "User"
  }
] });
