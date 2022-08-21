<p align="center"><img src="./storage/app/public/logos/logo_small.png" width="100"></p>


# Game Platform project

## Description
This Project is a simple Game platform where an admin can upload games as zip files for guests or registered users to play

## Features

### Roles
Depending on the role *guest*, *user*, or *admin* there are different features available:

#### Using the platform as a guest

guests can play the games that are on the platform, but the scores of the games they play won't be stored on the server.

#### Using the platform as registered user

You can register an account with your email address and choose a unique user name (max. 30 characters long).  
After registration you can play games right away but your scores will only be stored after you verify your email.
As a registered user you have a profile page.
On that page you can:
- change your profile picture
- delete your profile
- change your username
- change your password
- see a list of all games you played and how your rank is amongst all other users who played that game

#### Using the platform as admin

Admins cannot play games, they only have one overview page where they can  
- upload game files (only .zip)
- delete user profiles
- delete games
- change their admin password


### Playing Games

You can choose a game to play from a list.
When playing a game the current score is displayed on the left and the current ranking of all games is displayed on the right.
The ranking is updated after a game over and changes can be seen after refreshing the page

The games are embedded in the game page using iframes.

### Backend 

These are the things are implemented on the backend:
- email registration (users)
- email verification (users)
- username change
- profile picture change
- profile deletion
- game deletion
- game upload
- password change (admin, users) 
- different guards for authentication depending on role (admin or user)
- file archive extraction
- file deletion
- file storage
- file upload (pictures, games)
- database operations for changing/creating/deleting/updating data 

There are 4 tables (excluding default laravel tables and columns):
- admin (name, email, password)
- users (username, email, picture (path), password)
- highscores (username, game, score)
- games (name, path, creator)

There are migrations for all tables and all tables can be filled via seeding


## Game Licenses

I did not program my own games, but used free to use games and modified them.
The games I used are distributed under the MIT license, as can be seen in their respective source files in the folders of this project



