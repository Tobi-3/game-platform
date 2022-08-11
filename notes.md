# Laravel Game Platform

---

## Data in general
username  
email address  
highscores  
profile picture (path)  
games (path)  
passwords  


---

## Tables

DB name:  game-platform

 - [x] Gamescores: (username foreign key, game foreign key, score int)  
 - [x] user data: (username primary key, email, profile picture path, pwdhash)  
 - [x] games: (name, path text(, creator)) <!-- erst einmal kein creator -->  
 - [ ] (passwords: (username, pwdhash)  ) <!-- eher nicht -->

## functions

getHighscores(game(s), username=''):  
  - get *n* order by desc limit 10\


getRanks(username):
- returns current rank for all games the user played

---

## Views

- game with highscore
- user profile
- admin page
- games page
- login
- signup
- email verification
- verification succesful
- password reset
- password reset succesful