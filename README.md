# comp2245-finalproject

Final Assignment for Group B - Melissa Knight, Trevern Lamontagne, and Aidan Francis

### Project Structure

| File/Folder              | Description                                      |
|--------------------------|--------------------------------------------------|
| index.html               | Login page (frontend)                            |
| login.php                | Backend login handler (validates credentials)    |
| logout.php               | Session destroy (logs user out)                  |
| dashboard.html           | Dashboard layout (frontend view of CRM home)     |
| contacts.html            | New contact form (frontend for adding contacts)  |
| Users.html               | Users page (frontend layout for user list)       |
| users.php                | Backend users handler (fetches/manages user data)|
| register.html            | Registration form (frontend for new user signup) |
| contact.php              | Contact details page (view contact, notes, assignment, type switching) |
| get_contacts.php         |used by dashboard/contacts JS|
| get_users.php            |           |
| add_contacts.php         | Backend handler for new contact (inserts into DB)|
| assign_contact.php       | Assign contact to user (updates assigned_to field)|
| switch_type.php          | Update contact type (Sales Lead to Support, and vice versa)       |
| add_note.php             | Add note to contact (inserts note into DB)       |
| config.php               | Database connection (PDO setup, session start)   |
| assets/css/styles.css    | General styles                                   |
| assets/css/styles1.css   | other styles                         |
| assets/css/registerstyles.css | Styles for registration page                |
| assets/css/contact_detailsstyles.css | Styles for contact details page      |
| assets/js/dashboard.js   | Dashboard interactivity (fetch/display contacts) |
| assets/js/contacts.js    | Contact form logic (validation, submission)      |
| assets/js/usrscripts.js  | User page scripts (fetch/manage users)           |
| assets/js/login.js       | Login form interactivity (validation, feedback)  |
| assets/images/dolphin.png| Dolphin CRM logo                                 |
