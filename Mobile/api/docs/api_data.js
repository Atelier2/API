define({ "api": [
  {
    "type": "post",
    "url": "https://51.91.8.97:18343/users/:id/pictures/",
    "title": "Créer",
    "group": "Pictures",
    "description": "<p>Ajoute une image à la bibliothèque du User.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>La description de l'image.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "latitude",
            "description": "<p>La latitude de l'image.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "longitude",
            "description": "<p>La longitude de l'image.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "link",
            "description": "<p>Le lien où est hébergée l'image.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\n  \"description\": \"Place Stanislas\",\n  \"latitude\": \"38\",\n  \"longitude\": \"53\",\n  \"link\": \"https://www.imageshoster.com/image_1\n}",
          "type": "json"
        }
      ]
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Le token du User.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Bearer Token:",
          "content": "{\n  \"Authorization\": \"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 201 CREATED\n{\n  \"type\": \"resources\",\n  \"picture\": {\n    \"id\": \"18d0bca6-756a-4edb-94de-e7a764f562cc\",\n    \"description\": \"Place Stanislas\",\n    \"latitude\": \"38\",\n    \"longitude\": \"53\",\n    \"link\": \"https://www.imageshoster.com/image_1,\n    \"created_at\": \"2020-03-20 00:25:29\",\n    \"updated_at\": \"2020-03-20 00:25:29\",\n    \"id_user\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n  },\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>Le UUID ne correspond à aucun User.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidToken",
            "description": "<p>Le Token du User est invalide, il doit se reconnecter.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound-Response:",
          "content": "HTTP/1.1 404 NOT FOUND\n{\n  \"type\": \"error\",\n  \"error\": 404,\n  \"message\": \"User with ID db0913fa-934b-4981-9280-dc3bed19adb3 doesn't exist.\"\n}",
          "type": "json"
        },
        {
          "title": "InvalidToken-Response:",
          "content": "HTTP/1.1 401 UNAUTHORIZED\n{\n  \"type\": \"error\",\n  \"error\": 401,\n  \"message\": \"Token expired.\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "src/control/PictureController.php",
    "groupTitle": "Pictures",
    "name": "PostHttps519189718343UsersIdPictures"
  },
  {
    "type": "post",
    "url": "https://51.91.8.97:18343/users/:id_user/series/:id_series/pictures/",
    "title": "Ajouter à une Series",
    "group": "Pictures",
    "description": "<p>Ajoute une image à une Series du User.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>La description de l'image.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "latitude",
            "description": "<p>La latitude de l'image.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "longitude",
            "description": "<p>La longitude de l'image.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "link",
            "description": "<p>Le lien où est hébergée l'image.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\n  \"description\": \"Place Stanislas\",\n  \"latitude\": \"38\",\n  \"longitude\": \"53\",\n  \"link\": \"https://www.imageshoster.com/image_1\n}",
          "type": "json"
        }
      ]
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Le token du User.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Bearer Token:",
          "content": "{\n  \"Authorization\": \"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 201 CREATED\n{\n  \"type\": \"resources\",\n  \"picture\": {\n    \"id\": \"18d0bca6-756a-4edb-94de-e7a764f562cc\",\n    \"description\": \"Place Stanislas\",\n    \"latitude\": \"38\",\n    \"longitude\": \"53\",\n    \"link\": \"https://www.imageshoster.com/image_1,\n    \"created_at\": \"2020-03-20 00:25:29\",\n    \"updated_at\": \"2020-03-20 00:25:29\",\n    \"id_user\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n  },\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>Le UUID ne correspond à aucun User.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "SeriesDoesNotBelongToUser",
            "description": "<p>La Series n'appartient pas au User.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidToken",
            "description": "<p>Le Token du User est invalide, il doit se reconnecter.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound-Response:",
          "content": "HTTP/1.1 404 NOT FOUND\n{\n  \"type\": \"error\",\n  \"error\": 404,\n  \"message\": \"User with ID db0913fa-934b-4981-9280-dc3bed19adb3 doesn't exist.\"\n}",
          "type": "json"
        },
        {
          "title": "SeriesDoesNotBelongToUser-Response:",
          "content": "HTTP/1.1 401 UNAUTHORIZED\n{\n  \"type\": \"error\",\n  \"error\": 401,\n  \"message\": \"This series doesn't belong this user.\"\n}",
          "type": "json"
        },
        {
          "title": "InvalidToken-Response:",
          "content": "HTTP/1.1 401 UNAUTHORIZED\n{\n  \"type\": \"error\",\n  \"error\": 401,\n  \"message\": \"Token expired.\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "src/control/PictureController.php",
    "groupTitle": "Pictures",
    "name": "PostHttps519189718343UsersId_userSeriesId_seriesPictures"
  },
  {
    "type": "get",
    "url": "https://51.91.8.97:18343/users/:id/series/",
    "title": "Liste",
    "group": "Series",
    "description": "<p>Récupère les Series d'un User.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Le token du User.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Bearer Token:",
          "content": "{\n  \"Authorization\": \"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"type\": \"resources\",\n  \"series\": [\n    {\n      \"id\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\",\n      \"city\": \"Nancy\",\n      \"distance\": 100,\n      \"latitude\": \"38\",\n      \"longitude\": \"53\",\n      \"zoom\": 7,\n      \"nb_pictures\": 2,\n      \"created_at\": \"2020-03-20 00:25:29\",\n      \"updated_at\": \"2020-03-20 00:25:29\",\n      \"id_user\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n    },\n    {\n      \"id\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\",\n      \"city\": \"Paris\",\n      \"distance\": 80,\n      \"latitude\": \"52\",\n      \"longitude\": \"65\",\n      \"zoom\": 9,\n      \"nb_pictures\": 7,\n      \"created_at\": \"2020-03-21 00:25:29\",\n      \"updated_at\": \"2020-03-21 00:25:29\",\n      \"id_user\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>Le UUID ne correspond à aucun User.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidToken",
            "description": "<p>Le Token du User est invalide, il doit se reconnecter.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound-Response:",
          "content": "HTTP/1.1 404 NOT FOUND\n{\n  \"type\": \"error\",\n  \"error\": 404,\n  \"message\": \"User with ID db0913fa-934b-4981-9280-dc3bed19adb3 doesn't exist.\"\n}",
          "type": "json"
        },
        {
          "title": "InvalidToken-Response:",
          "content": "HTTP/1.1 401 UNAUTHORIZED\n{\n  \"type\": \"error\",\n  \"error\": 401,\n  \"message\": \"Token expired.\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "src/control/SeriesController.php",
    "groupTitle": "Series",
    "name": "GetHttps519189718343UsersIdSeries"
  },
  {
    "type": "post",
    "url": "https://51.91.8.97:18343/users/:id/series/",
    "title": "Créer",
    "group": "Series",
    "description": "<p>Crée une Series pour un User.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city",
            "description": "<p>Le nom de ville de la Series.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "distance",
            "description": "<p>Le marge d'erreur sur la précision de la Series.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "latitude",
            "description": "<p>La latitude de la Series.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "longitude",
            "description": "<p>La longitude de la Series.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "zoom",
            "description": "<p>Le zoom de la carte de la Series.</p>"
          },
          {
            "group": "Parameter",
            "type": "Mumber",
            "optional": false,
            "field": "nb_pictures",
            "description": "<p>Le nombre d'images dans la Series.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\n  \"city\": \"Nancy\",\n  \"distance\": 100,\n  \"latitude\": \"38\",\n  \"longitude\": \"53\",\n  \"zoom\": 7,\n  \"nb_pictures\": 2\n}",
          "type": "json"
        }
      ]
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Le token du User.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Bearer Token:",
          "content": "{\n  \"Authorization\": \"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 201 CREATED\n{\n  \"type\": \"resources\",\n  \"series\": {\n    \"id\": \"18d07ca6-7562-4a3b-9d9e-e7a264f562cc\",\n    \"city\": \"Nancy\",\n    \"distance\": 100,\n    \"latitude\": \"38\",\n    \"longitude\": \"53\",\n    \"zoom\": 7,\n    \"nb_pictures\": 2,\n    \"created_at\": \"2020-03-20 00:25:29\",\n    \"updated_at\": \"2020-03-20 00:25:29\",\n    \"id_user\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n  },\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>Le UUID ne correspond à aucun User.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidToken",
            "description": "<p>Le Token du User est invalide, il doit se reconnecter.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "UserNotFound-Response:",
          "content": "HTTP/1.1 404 NOT FOUND\n{\n  \"type\": \"error\",\n  \"error\": 404,\n  \"message\": \"User with ID db0913fa-934b-4981-9280-dc3bed19adb3 doesn't exist.\"\n}",
          "type": "json"
        },
        {
          "title": "InvalidToken-Response:",
          "content": "HTTP/1.1 401 UNAUTHORIZED\n{\n  \"type\": \"error\",\n  \"error\": 401,\n  \"message\": \"Token expired.\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "src/control/SeriesController.php",
    "groupTitle": "Series",
    "name": "PostHttps519189718343UsersIdSeries"
  },
  {
    "type": "post",
    "url": "https://51.91.8.97:18343/users/signin/",
    "title": "Connecter",
    "group": "Users",
    "description": "<p>Connecte un User.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>L'adresse e-mail et le mot de passe en Basic Auth.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Basic Auth:",
          "content": "{\n  \"Authorization\": \"Basic QWxhZGRpbjpPcGVuU2VzYW1l\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"type\": \"resource\",\n  \"user\": {\n    \"id\": \"db0916fa-934b-4981-9980-d53bed190db3\",\n    \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA\",\n    \"firstname\": \"Albert\",\n    \"lastname\": \"Einstein\",\n    \"email\": \"albert.einstein@physics.com\",\n    \"phone\": \"0612345678\",\n    \"street_number\": 2,\n    \"street\": \"Boulevard Charlemagne\",\n    \"city\": \"Nancy\",\n    \"zip_code\": 54000\n    \"created_at\": \"2020-03-24 13:05:51\",\n    \"updated_at\": \"2020-03-24 13:06:51\"\n  }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidCredentials",
            "description": "<p>L'adresse e-mail ou le mot de passe sont incorrects.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "InvalidCredentials-Response:",
          "content": "HTTP/1.1 401 UNAUTHORIZED\n{\n  \"type\": \"error\",\n  \"error\": 401,\n  \"message\": \"Email or password are incorrect.\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "src/control/UserController.php",
    "groupTitle": "Users",
    "name": "PostHttps519189718343UsersSignin"
  },
  {
    "type": "post",
    "url": "https://51.91.8.97:18343/users/signup/",
    "title": "Créer",
    "group": "Users",
    "description": "<p>Crée un User.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "firstname",
            "description": "<p>Le prénom du User.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lastname",
            "description": "<p>Le nom de famille du User.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>L'addresse e-mail du User.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>Le mot de passe du User.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "phone",
            "description": "<p>Le numéro de téléphone du User.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "street_number",
            "description": "<p>Le numéro de la rue du User.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "street",
            "description": "<p>Le nom de la rue du User.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city",
            "description": "<p>Le nom de la ville du User.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "zip_code",
            "description": "<p>Le code postal du User.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\n  \"firstname\": \"Albert\",\n  \"lastname\": \"Einstein\",\n  \"email\": \"albert.einstein@physics.com\",\n  \"password\": \"physics\",\n  \"phone\": \"0612345678\",\n  \"street_number\": 2,\n  \"street\": \"Boulevard Charlemagne\",\n  \"city\": \"Nancy\",\n  \"zip_code\": 54000\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 201 CREATED\n{\n  \"type\": \"resource\",\n  \"user\": {\n    \"id\": \"db0916fa-934b-4981-9980-d53bed190db3\",\n    \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA\",\n    \"firstname\": \"Albert\",\n    \"lastname\": \"Einstein\",\n    \"email\": \"albert.einstein@physics.com\",\n    \"phone\": \"0612345678\",\n    \"street_number\": 2,\n    \"street\": \"Boulevard Charlemagne\",\n    \"city\": \"Nancy\",\n    \"zip_code\": 54000\n    \"created_at\": \"2020-03-24 13:05:51\",\n    \"updated_at\": \"2020-03-24 13:05:51\"\n  }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "EmailAlreadyTaken",
            "description": "<p>L'adresse e-mail est déjà utilisée.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "EmailAlreadyTaken-Response:",
          "content": "HTTP/1.1 401 UNAUTHORIZED\n{\n  \"type\": \"error\",\n  \"error\": 401,\n  \"message\": \"This e-mail address is already taken.\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "src/control/UserController.php",
    "groupTitle": "Users",
    "name": "PostHttps519189718343UsersSignup"
  }
] });
