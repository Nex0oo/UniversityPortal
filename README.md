# UniversityPortal
This project is a university portal developed using PostgreSQL and PHP, designed to support the daily operations of students, faculty members, and administrative staff. The system allows students to register for exams, view course information, and manage their academic records. Professors can organize and publish exams, while the university's administration can oversee enrollments and manage academic data. The backend is powered by a relational database modeled through an Entity-Relationship diagram, ensuring consistency and integrity of the information.

## User Manual
To use the application, follow these steps:

- Make sure you have PostgreSQL, PHP, and Apache installed (Apache can be used via XAMPP). You will need to modify some files in the XAMPP folder — specifically, edit the php.ini file to enable support for PostgreSQL.

- Download the package containing the folder with the web application source files and the database dump. Move the source folder into the htdocs directory inside the XAMPP installation.

- Create a connection to PostgreSQL and import the database dump (the dump already includes some records to test the application).

- Access the application by entering the following URL in your browser: localhost/folder_name (Replace folder_name with the name of the folder containing the source files.)

Once done, you can start using the application by logging in.
Depending on the type of user, a different homepage will be shown, providing access to the corresponding features.

## ER diagram
![ER diagram](img/Schema_ER.jpg)