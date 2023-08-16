# Simple CRM System for Managing Clients

The System  manage Clients, Projects, Tasks with CRUD operations.

The System implements the following:

- Implements Authentication with JWT.

- Implements Authorization with Spatie Permissions package.

- Implements Polymorphic relationships with Spatie Media Library package to add avatar for users.

- Implements Email Verification.

- It sends emails and notifications(via email and telegram). 

### To use the system:
- Clone the repo, Then run php artisan migrate --seed

- use this user to login (Its the super admin user) :
email: GeneralManager@mail.com
password: admin123
