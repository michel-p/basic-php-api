#Installation Steps

## 1 - MySQL 

### Import
You can find the mysql import sql file in the docs folder (deezer.sql)

### Configuration
Configure database setting in the file /database/config.php

I used PHP PDO so that any further changes of database can be done more quickly.


## 2 - API calls

I used POSTMAN Chrome extension to test my API Calls

###List of available call for Users

#### GET

##### get the basic user informations
/api/user/:id 

##### get the favorite song of a user
/api/user/favorite/:id 

#### POST
##### add a pre-existing song to the favorite playlist of a user
/api/user/favorite/:user_id/:song_id

#### DELETE
##### delete a pre-existing song to the favorite playlist of a user
/api/user/favorite/:user_id/:song_id

###List of available call for Songs

#### GET
/api/song/:id

#Architecture guidelines

AbstractAPI contains all the basic stuff of an API. It analyses the Request and calls the method
which has the same name. Example : /api/user ==> BaseAPI will try to call a function named user().

There is also the possibility to define a specific action for the endpoint.
Example : /api/user/favorite

Therefore, a specific behavior can be implemented in the user() function by analysing the end point action (if not null)

So basically we have : /api/{end point}/{optionnal end point action}/{arg1}/{arg2}....

DeezerAPI is a child of BaseAPI and provides all necessary endpoints functions such as
+ user()
+ song()
+ ... to be implemented

You only have to create your own functions to handle new API calls
In each one, GET, POST, PUT, DELETE are matched. 
There are also specific conditions for the end point actions.


DeezerAPI returns a JSONResponse object, so all responses are similar.
Example : /api/user/1 (GET)

`
{
  "status": "success",
  "data": {
    "user": {
      "id": "1",
      "name": "michel",
      "email": "michel.parreno@gmail.com"
    }
  },
  "message": null
}
`

#What I would have used normally
+ Symfony Framework
+ Swagger
+ Nelmio apidoc bundle