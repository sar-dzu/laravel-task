# Auth REST API

## AuthController

### Registrácia používateľa

#### POST /api/auth/register
![POST /api/auth/register](screenshots/sc2/POST-auth-register.png)

---

### Zmena hesla

#### POST /api/auth/change-password
![POST /api/auth/change-password](screenshots/sc2/POST-auth-change-password.png)

---

### Úprava profilu používateľa

#### PATCH /api/auth/profile
![PATCH /api/auth/profile](screenshots/sc2/POST-auth-update-profile.png)

---

### Odhlásenie zo všetkých zariadení

#### POST /api/auth/logout-all
![POST /api/auth/logout-all](screenshots/sc2/POST-auth-lougout-all.png)

---

## Neúspešné operácie

### Neplatná požiadavka (422)

#### PATCH /api/auth/profile
![PATCH /api/auth/profile error](screenshots/sc2/POST-auth-update-422.png)



# Notes REST API

## NoteController

### GET /api/notes/1
![GET /api/notes/1](screenshots/GET-notes-1.png)

### GET /api/notes/404
![GET /api/notes/404](screenshots/GET-notes-404.png)

---

## CategoryController CRUD

### GET /api/categories
![GET /api/categories](screenshots/GET-categories.png)

### POST /api/categories
![POST /api/categories](screenshots/POST-categories.png)

### GET /api/categories/2
![GET /api/categories/2](screenshots/GET-categories-2.png)

### PUT /api/categories/5
![PUT /api/categories/5](screenshots/PUT-categories-5.png)

### DELETE /api/categories/5
![DELETE /api/categories/5](screenshots/DELETE-categories-5.png)

### Neúspešná validácia - POST /api/categories
![POST /api/categories error](screenshots/POST-categories-error.png)

### Neexistujúci záznam - GET /api/categories/25
![GET /api/categories/25](screenshots/GET-categories-25.png)

### Neexistujúci záznam - PUT /api/categories/55
![PUT /api/categories/55](screenshots/PUT-categories-55.png)

### Neexistujúci záznam - DELETE /api/categories/55
![DELETE /api/categories/55](screenshots/DELETE-categories-55.png)


## TaskController CRUD

### Úspešné operácie

#### GET /api/notes/1/tasks
![GET](screenshots/GET-notes-1-tasks.png)

#### GET /api/notes/1/tasks/2
![GET one](screenshots/GET-notes-1-tasks-2.png)

#### PUT /api/notes/1/tasks/2
![PUT](screenshots/PUT-notes-1-tasks-2.png)

#### DELETE /api/notes/1/tasks/2
![DELETE](screenshots/DELETE-notes-1-tasks-2.png)

---

### Neúspešné operácie

#### GET /api/notes/123/tasks (note neexistuje)
![404 note](screenshots/GET-notes-123-tasks.png)

#### GET /api/notes/1/tasks/12 (task neexistuje)
![404 task](screenshots/GET-notes-1-tasks-12.png)

#### POST /api/notes/123/tasks (error)
![POST error](screenshots/POST-notes-123-tasks.png)
