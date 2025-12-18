# comp2245-finalproject

Final Assignment for Group B - Melissa Knight, Trevern Lamontagne, and Aidan Francis

comp2245-finalproject/
│
├── index.html            ← Login page (frontend)
├── login.php             ← Backend login handler (validates credentials, starts session)
├── logout.php            ← Session destroy (logs user out, clears session)
├── dashboard.html        ← Dashboard layout (frontend view of CRM home)
├── contacts.html         ← New contact form (frontend for adding contacts)
├── Users.html            ← Users page (frontend layout for user list)
├── users.php             ← Backend users handler (fetches/manages user data)
├── register.html         ← Registration form (frontend for new user signup)
├── contact.php           ← Contact details page (view contact, notes, assignment, type switching)
│
├── get_contacts.php      ← Returns contacts JSON (used by dashboard/contacts JS)
├── get_users.php         ← Returns users JSON (used by users JS)
├── add_contacts.php      ← Backend handler for new contact (inserts into DB)
├── assign_contact.php    ← Assign contact to user (updates assigned_to field)
├── switch_type.php       ← Update contact type (Sales Lead to Support, and vice versa)
├── add_note.php          ← Add note to contact (inserts note into DB)
│
├── config.php            ← Database connection (PDO setup, session start)
│
├── assets/
│   ├── css/
│   │   ├── styles.css              ← General styles
│   │   ├── styles1.css             ← Alternate/general styles
│   │   ├── registerstyles.css      ← Styles for registration page
│   │   └── contact_detailsstyles.css ← Styles for contact details page
│   ├── js/
│   │   ├── dashboard.js            ← Dashboard interactivity (fetch/display contacts)
│   │   ├── contacts.js             ← Contact form logic (validation, submission)
│   │   ├── usrscripts.js           ← User page scripts (fetch/manage users)
│   │   └── login.js                ← Login form interactivity (validation, feedback)
│   └── images/
│       └── dolphin.png             ← Dolphin CRM logo
│
└── README.md             ← explain structure and group members
