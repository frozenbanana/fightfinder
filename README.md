# FightFinder
Your app to find BJJ gyms all over the world!

## Database

**gyms**
| Column | Type |
|--------|------|
| id     | int  |
| name   | text |
| description   | text |
| address| text |
| user_id | foreign_key |

**users**
| Column | Type |
|--------|------|
| id     | int  |
| name   | text |
| email  | text |
| password| text |

## Routes
- GET
    - home [ huvudsida, se alla gym ] [OK]
    - users/:username/ [ Se inloggad användares profil och gym]
    - gyms/add [ Inloggad användare se add sida ]
    - gyms/edit [ inloggad användare se edit sida ]
    - gyms/:gym_name [ användare se all info om spec. gym]
    - comments/gym/:gym_id [ se lista av comments spec. Gym ]
    - comments/user/:user_id [ se lista av comments spec. User ]
    - login [ se login sida ] [OK]
    - register [ se register sida ] [OK]
- POST
    - gyms/add [ inloggad användare skapa nytt gym ] [OK]
    - login [ användare loggar in ] [OK]
    - register [ användare registrerar sig ] [OK]
    - admin/comments/add [ inloggad användare skapar ny comment ]
- PUT
    - admin/gyms/edit [ inloggad användare editerar gym ]
- DELETE
    - admin/gyms/delete [ inloggad användare ta bort gym ]
