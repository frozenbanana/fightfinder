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
    - home [ huvudsida, se alla gym ]
    - admin/gyms [ Se inloggad användares gym]
    - admin/gyms/add [ Inloggad användare se add sida ]
    - admin/gyms/edit [ inloggad användare se edit sida ]
    - gyms/:gym_name [ användare se all info om spec. gym]
    - comments/gym/:gym_id [ se lista av comments spec. Gym ]
    - comments/user/:user_id [ se lista av comments spec. User ]
    - login [ se login sida ]
    - register [ se register sida ]
- POST
    - admin/gyms/add [ inloggad användare skapa nytt gym ] 
    - login [ användare loggar in ]
    - register [ användare registrerar sig ]
    - admin/comments/add [ inloggad användare skapar ny comment ]
- PUT
    - admin/gyms/edit [ inloggad användare editerar gym ]
- DELETE
    - admin/gyms/delete [ inloggad användare ta bort gym ]