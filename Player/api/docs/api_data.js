define({ "api": [
  {
    "type": "get",
    "url": "http://51.91.8.97:18180/games/:id/",
    "title": "Obtenir",
    "group": "Games",
    "description": "<p>Récupère une Game.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>Le UUID de la Game.</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Le token de la game.</p>"
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
          "content": "HTTP/1.1 200 OK\n{\n  \"type\": \"resource\",\n  \"links\": {\n    \"leaderboard\": {\n      \"href\": \"http://51.91.8.97:18180/games/leaderboard/\"\n    }\n  },\n  \"game\": {\n    \"id\": \"5a005636-4514-45cc-a6d5-496847b0adbf\",\n    \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA\",\n    \"score\": 0,\n    \"pseudo\": \"Albert Einstein\",\n    \"id_status\": 0,\n    \"id_series\": \"8d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n  }\n}",
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
            "field": "GameNotFound",
            "description": "<p>Le UUID de la Game n'a pas été trouvé.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidToken",
            "description": "<p>Le Token de la Game est invalide, elle n'est donc pas accessible.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "GameNotFound-Response:",
          "content": "HTTP/1.1 404 NOT FOUND\n{\n  \"type\": \"error\",\n  \"error\": 404,\n  \"message\": \"Game with ID 5a005626-4514-45cc-a5d5-496847bdadbf not found.\"\n}",
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
    "filename": "src/control/GameController.php",
    "groupTitle": "Games",
    "name": "GetHttp519189718180GamesId"
  },
  {
    "type": "get",
    "url": "http://51.91.8.97:18180/games/leaderboard?page=:page&size=:size",
    "title": "Leaderboard",
    "group": "Games",
    "description": "<p>Récupère toutes les Games classées par le score.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": true,
            "field": "page",
            "description": "<p>Le numéro de la page à afficher.</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": true,
            "field": "size",
            "description": "<p>Le nombre de Games à affciher par page.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"type\": \"resources\",\n  \"links\": {\n    \"next\": {\n      \"href\": \"http://51.91.8.97:18180/games/leaderboard?page=2&size=2\"\n    },\n    \"prev\": {\n      \"href\": \"http://51.91.8.97:18180/games/leaderboard?page=0&size=2\"\n    },\n    \"last\": {\n      \"href\": \"http://51.91.8.97:18180/games/leaderboard?page=5&size=2\"\n    },\n    \"first\": {\n      \"href\": \"http://51.91.8.97:18180/games/leaderboard?page=1&size=2\"\n    }\n  },\n  \"games\": [\n    {\n      \"id\": \"5a005636-4514-45cc-a6d5-496847b0adbf\",\n      \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA\",\n      \"score\": 1500,\n      \"pseudo\": \"Albert Einstein\",\n      \"id_status\": 2,\n      \"id_series\": \"8d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n    },\n    {\n      \"id\": \"5a705236-4414-45fc-aed5-496j47b0adbf\",\n      \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA\",\n      \"score\": 1000,\n      \"pseudo\": \"Albert Einstein\",\n      \"id_status\": 2,\n      \"id_series\": \"8d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "src/control/GameController.php",
    "groupTitle": "Games",
    "name": "GetHttp519189718180GamesLeaderboardPagePageSizeSize"
  },
  {
    "type": "post",
    "url": "http://51.91.8.97:18180/games/",
    "title": "Créer",
    "group": "Games",
    "description": "<p>Crée une Game.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<p>Le pseudo du joueur.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "id_series",
            "description": "<p>Le UUID de la Series.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\n  \"username\": \"Albert Einstein\",\n  \"id_series\": \"8d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 201 CREATED\n{\n  \"type\": \"resource\",\n  \"game\": {\n    \"id\": \"5a005636-4514-45cc-a6d5-496847b0adbf\",\n    \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA\",\n    \"score\": 0,\n    \"pseudo\": \"Albert Einstein\",\n    \"id_status\": 0,\n    \"id_series\": \"8d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n  }\n}",
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
            "field": "SeriesNotFound",
            "description": "<p>Le UUID de la Series n'a pas été trouvé.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "SeriesNotFound-Response:",
          "content": "HTTP/1.1 404 NOT FOUND\n{\n  \"type\": \"error\",\n  \"error\": 404,\n  \"message\": \"Series with ID 8d0eca6-756a-433b-9dde-e7ad64f562cc not found.\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "src/control/GameController.php",
    "groupTitle": "Games",
    "name": "PostHttp519189718180Games"
  },
  {
    "type": "put",
    "url": "http://51.91.8.97:18180/games/:id/",
    "title": "Modifier",
    "group": "Games",
    "description": "<p>Modifie une Game existante.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>Le UUID de la Game.</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": true,
            "field": "score",
            "description": "<p>Le nouveau score de la Game.</p>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "allowedValues": [
              "0",
              "1",
              "2"
            ],
            "optional": true,
            "field": "id_status",
            "description": "<p>Le nouveau status de la Game.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\n  \"score\": 1000,\n  \"id_status\": 1\n}",
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
            "description": "<p>Le token de la game.</p>"
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
          "content": "HTTP/1.1 200 OK\n{\n  \"type\": \"resource\",\n  \"game\": {\n    \"id\": \"5a005636-4514-45cc-a6d5-496847b0adbf\",\n    \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA\",\n    \"score\": 1000,\n    \"pseudo\": \"Albert Einstein\",\n    \"id_status\": 1,\n    \"id_series\": \"8d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n  }\n}",
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
            "field": "GameNotFound",
            "description": "<p>Le UUID de la Game n'a pas été trouvé.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "InvalidToken",
            "description": "<p>Le Token de la Game est invalide, elle n'est donc pas accessible.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "GameNotFound-Response:",
          "content": "HTTP/1.1 404 NOT FOUND\n{\n  \"type\": \"error\",\n  \"error\": 404,\n  \"message\": \"Game with ID 5a005636-4514-45cc-a6d5-496847b0adbf not found.\"\n}",
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
    "filename": "src/control/GameController.php",
    "groupTitle": "Games",
    "name": "PutHttp519189718180GamesId"
  },
  {
    "type": "get",
    "url": "http://51.91.8.97:18180/series/",
    "title": "Liste",
    "group": "Series",
    "description": "<p>Récupère toutes les Series.</p>",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"type\": \"resources\",\n  \"links\": {\n    \"one_series\": {\n      \"href\": \"http://51.91.8.97:18180/series/18d0eca6-756a-4e3b-9dde-e7a664f562cc/\"\n    }\n  },\n  \"series\": [\n    {\n      \"id\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\",\n      \"city\": \"Nancy\",\n      \"distance\": 100,\n      \"latitude\": 38,\n      \"longitude\": 53,\n      \"zoom\": 7,\n      \"nb_pictures\": 2,\n      \"created_at\": \"2020-03-20 00:25:29\",\n      \"updated_at\": \"2020-03-20 00:25:29\",\n      \"id_user\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n    },\n    {\n      \"id\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\",\n      \"city\": \"Paris\",\n      \"distance\": 80,\n      \"latitude\": 52,\n      \"longitude\": 65,\n      \"zoom\": 9,\n      \"nb_pictures\": 7,\n      \"created_at\": \"2020-03-21 00:25:29\",\n      \"updated_at\": \"2020-03-21 00:25:29\",\n      \"id_user\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "src/control/SeriesController.php",
    "groupTitle": "Series",
    "name": "GetHttp519189718180Series"
  },
  {
    "type": "get",
    "url": "http://51.91.8.97:18180/series/:id/",
    "title": "Obtenir",
    "group": "Series",
    "description": "<p>Récupère une Series.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>Le UUID de la Series.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"type\": \"resource\",\n  \"links\": {\n    \"pictures\": {\n      \"href\": \"http://51.91.8.97:18180/series/18d0eca6-756a-4e3b-9dde-e7a664f562cc/pictures/\"\n    },\n    \"all_series\": {\n      \"href\": \"http://51.91.8.97:18180/series/\"\n    }\n  },\n  \"series\": {\n    \"id\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\",\n    \"city\": \"Nancy\",\n    \"distance\": 100,\n    \"latitude\": 38,\n    \"longitude\": 53,\n    \"zoom\": 7,\n    \"nb_pictures\": 2,\n    \"created_at\": \"2020-03-20 00:25:29\",\n    \"updated_at\": \"2020-03-20 00:25:29\",\n    \"id_user\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n  }\n}",
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
            "field": "SeriesNotFound",
            "description": "<p>Le UUID de la Series n'a pas été trouvé.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 NOT FOUND\n{\n  \"type\": \"error\",\n  \"error\": 404,\n  \"message\": \"Series with ID 18d0eca6-756a-484b-9dde-e7ab64f562cc not found.\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "src/control/SeriesController.php",
    "groupTitle": "Series",
    "name": "GetHttp519189718180SeriesId"
  },
  {
    "type": "get",
    "url": "http://51.91.8.97:18180/series/:id/pictures/",
    "title": "Photos",
    "group": "Series",
    "description": "<p>Récupère les photos d'une Series.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>Le UUID de la Series.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"type\": \"resources\",\n  \"links\": {\n    \"series\": {\n      \"href\": \"http://51.91.8.97:18180/series/18d0eca6-756a-4e3b-9dde-e7a664f562cc/\"\n    },\n    \"all_series\": {\n      \"href\": \"http://51.91.8.97:18180/series/\"\n    }\n  },\n  \"pictures\": [\n    {\n      \"id\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\",\n      \"description\": \"photo 1\",\n      \"latitude\": 25,\n      \"longitude\": 35,\n      \"link\": \"http://www.example.fr/photo1.png\",\n      \"created_at\": \"2020-03-20 00:25:29\",\n      \"updated_at\": \"2020-03-20 00:25:29\",\n      \"id_user\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n    },\n    {\n      \"id\": \"18d02ca6-746a-4e3b-9dfe-e7h664f562cc\",\n      \"description\": \"photo 2\",\n      \"latitude\": 24,\n      \"longitude\": 35,\n      \"link\": \"http://www.example.fr/photo2.png\",\n      \"created_at\": \"2020-03-20 00:25:29\",\n      \"updated_at\": \"2020-03-20 00:25:29\",\n      \"id_user\": \"18d0eca6-756a-4e3b-9dde-e7a664f562cc\"\n    }\n  ]\n}",
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
            "field": "SeriesNotFound",
            "description": "<p>Le UUID de la Series n'a pas été trouvé.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 NOT FOUND\n{\n  \"type\": \"error\",\n  \"error\": 404,\n  \"message\": \"Series with ID 18d0eca6-756a-484b-9dde-e7ab64f562cc not found.\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "src/control/SeriesController.php",
    "groupTitle": "Series",
    "name": "GetHttp519189718180SeriesIdPictures"
  }
] });
