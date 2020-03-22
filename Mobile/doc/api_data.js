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
    "filename": "./doc/main.js",
    "group": "/var/www/html/Atelier2/API/Mobile/doc/main.js",
    "groupTitle": "/var/www/html/Atelier2/API/Mobile/doc/main.js",
    "name": ""
  },
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
    "filename": "./src/control/main.js",
    "group": "/var/www/html/Atelier2/API/Mobile/src/control/main.js",
    "groupTitle": "/var/www/html/Atelier2/API/Mobile/src/control/main.js",
    "name": ""
  },
  {
    "type": "post",
    "url": "http://api.mobile.local:19380/picture",
    "title": "Ajouter une photo",
    "name": "addPicture",
    "group": "Pictures",
    "examples": [
      {
        "title": "Example test:",
        "content": "curl -X POST http://api.mobile.local:19380/picture",
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
            "description": "<p>liens de la photo vers Cloudinary.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "    {\n\"description\" : \"Place Stanislas\",\n\"latitude\" : \"23.5487° E\",\n\"longitude\" : \"5.2136° E\",\n\"link\" : \"https://google.com\"\n    }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"picture saved\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./src/control/MobileController.php",
    "groupTitle": "Pictures"
  },
  {
    "type": "get",
    "url": "/picture/:id",
    "title": "Récupère une photo",
    "name": "getPictureId",
    "group": "Pictures",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i  http://api.mobile.local:19380/picture/id",
        "type": "json"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la photo.</p>"
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
            "field": "City",
            "description": "<p>Ville correspondant à la photo.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Distance",
            "description": "<p>De la photo.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Latitude",
            "description": "<p>coordonnées gps latitude.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Longitude",
            "description": "<p>coordonnées gps longitude.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Zoom",
            "description": "<p>l'indice de zoom.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Link",
            "description": "<p>Lien vers cloudinary.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "./src/control/MobileController.php",
    "groupTitle": "Pictures"
  },
  {
    "type": "get",
    "url": "/picture",
    "title": "Récupère toutes les photos",
    "name": "getPictures",
    "group": "Pictures",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i  http://api.mobile.local:19380/picture",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "City",
            "description": "<p>Ville correspondant à la photo.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Distance",
            "description": "<p>De la photo.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Latitude",
            "description": "<p>coordonnées gps latitude.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Longitude",
            "description": "<p>coordonnées gps longitude.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Zoom",
            "description": "<p>l'indice de zoom.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Link",
            "description": "<p>Lien vers cloudinary.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "./src/control/MobileController.php",
    "groupTitle": "Pictures"
  },
  {
    "type": "post",
    "url": "http://api.mobile.local:19380/series",
    "title": "Creer une Serie.",
    "name": "createSerie",
    "group": "Series",
    "examples": [
      {
        "title": "Example:",
        "content": "curl -X POST http://api.mobile.local:19380/series",
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
          "content": "    {\n       \"city\" : \"Nancy\",\n\"distance\" : 300,\n\"latitude\" : \"48.8566° N\",\n\"longitude\" : \"2.3522° E\",\n\"zoom\" : 3,\n\"nb_pictures\" : 2\n    }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"Nouvelle serie ajoutée\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./src/control/MobileController.php",
    "groupTitle": "Series"
  },
  {
    "type": "get",
    "url": "/series/:id",
    "title": "Récupère une série",
    "name": "getSerieId",
    "group": "Series",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i  http://api.mobile.local:19380/series/id",
        "type": "json"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la serie.</p>"
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
            "field": "City",
            "description": "<p>Ville correspondant à la série.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Distance",
            "description": "<p>De la serie.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Latitude",
            "description": "<p>coordonnées gps latitude.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Longitude",
            "description": "<p>coordonnées gps longitude.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Zoom",
            "description": "<p>l'indice de zoom.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "nb_pictures",
            "description": "<p>Le nombre de photos associe à la série.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "./src/control/MobileController.php",
    "groupTitle": "Series"
  },
  {
    "type": "get",
    "url": "/series/",
    "title": "Récupérer les séries",
    "name": "getSeries",
    "group": "Series",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -i  http://api.mobile.local:19380/series",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la serie.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "City",
            "description": "<p>Ville correspondant à la série.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Distance",
            "description": "<p>De la serie.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Latitude",
            "description": "<p>coordonnées gps latitude.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "Longitude",
            "description": "<p>coordonnées gps longitude.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "Zoom",
            "description": "<p>l'indice de zoom.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "nb_pictures",
            "description": "<p>Le nombre de photos associe à cette série.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "./src/control/MobileController.php",
    "groupTitle": "Series"
  },
  {
    "type": "post",
    "url": "http://api.mobile.local:19280/user/signin",
    "title": "Se connecter.",
    "name": "userSignin",
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
    "filename": "./src/control/MobileController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "http://api.mobile.local:19280/user/signup",
    "title": "Création d'un utilisateur.",
    "name": "userSignup",
    "group": "User",
    "examples": [
      {
        "title": "Example usage:",
        "content": "curl -X POST http://api.mobile.local:19380/user/signup",
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
          "content": "    {\n\"firstname\": \"ok\",\n\"lastname\": \"ok\",\n\"email\": \"ok@gmail.com\",\n\"password\": \"ok\",\n\"phone\": \"06060606\",\n\"street_number\": 23,\n\"street\": \"rue des hibiscus\",\n\"city\": \"Nancy\",\n\"zip_code\": 54000\n}",
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
    "filename": "./src/control/MobileController.php",
    "groupTitle": "User"
  }
] });
