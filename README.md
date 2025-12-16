php-mvc-auth/
├── app/
│   ├── config/
│   │   ├── config.php
│   │   └── database.php
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── UserController.php
│   │   └── AdminController.php
│   ├── core/
│   │   ├── Router.php
│   │   ├── Controller.php
│   │   ├── Model.php
│   │   └── Database.php
│   ├── models/
│   │   ├── User.php
│   │   ├── Role.php
│   │   └── Permission.php
│   ├── views/
│   │   ├── auth/
│   │   │   ├── login.php
│   │   │   └── register.php
│   │   ├── dashboard/
│   │   │   └── index.php
│   │   ├── users/
│   │   │   ├── index.php
│   │   │   ├── create.php
│   │   │   └── edit.php
│   │   ├── admin/
│   │   │   ├── roles.php
│   │   │   └── permissions.php
│   │   └── layout/
│   │       ├── header.php
│   │       ├── footer.php
│   │       └── sidebar.php
│   └── helpers/
│       ├── AuthHelper.php
│       └── Session.php
├── public/
│   ├── index.php
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── main.js
│   └── assets/
│       └── images/
├── .htaccess
└── database.sql