# Dev Back : API avec Symfony et API Platform
___
You only have access to route ```/api``` which is the API Documentation, but you can not send requests without a Bearer Token.
## Postman :

**Headers :**

```sh
Content-Type : application/x-www-form-url-encoded
Content-Type : application/merge-patch+json 
Accept : application/json
```
### First step : Register
**Body :**
Choose ```form-data```
```sh
username (key): your username (value)
password (key): your password (value)
```
Make a POST request on ```'ngrok-url'/register```

**Response** : User ```your username``` successfully created / Error if user already exists.

### Second step : Ask for a token

**Headers :**
Change ```Content-Type : application/x-www-form-url-encoded``` to ```Content-Type : application/json```

**Body :**
Choose ```raw```
```sh
{
 "username": "your username"
 "password": "your password"
}
```
Make a POST request on ```'ngrok-url'/login_check```

**Response** : Token lasting 3600 seconds / Error if invalid credentials

### Third step : access to API

Copy the token without the quotes in Postman / Authorization / Choose type : ```Bearer Token``` and paste it in the ```token input``` on the right.

```Postman :``` Test the routes indicated in API Documentation. (You can see the tables schemas for your requests at the end of the page on /api)

```Browser :``` When on ```/api```. Click on Authorize on the top right / Copy and paste the token as such : ```Bearer your-token``` / Make sure you have written Bearer before and click on Authorize / Test the routes indicated in API Documentation.

**Beware :** ```You have to send a JSON body for POST, PUT and PATCH request```.

**Beware :** ```There are links between tables, for example if you want to post a new Actor you have to fill his movies line in JSON with movies paths that exist in the API, otherwise it won't work```.

