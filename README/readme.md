This guide explains how to set up, use, and manage the staff and search system in an easy way.

 # Overview
This system allows users to:
1. View a list of staff members 
2. Search by name and filter by job title 
3. View detailed staff profiles 
4. See staff photos, job titles, contact info, and biographies 
5. Search for academic programs 

# files and folders
 Project Structure
  /student_course_hub
   |-/staff
       |--staff.php
       |--staff_details.php
    |   |--staff_photo
     |--/README
         |--readme.md
    |--/student_course_hub.sql
 # What Each File Does

  - Staff Management
      staff.php → Shows all staff with a search bar and filters.

     staff_details.php → Displays full details of a staff member (photo, bio, contact).

     staff_photos/ → Folder where staff profile pictures are stored.

- Other Files
     readme.md → This guide to help set up and use the system.

     student_course_hub.sql → Database file containing staff and program details.

# Setting Up the System
1️. Install the Database
     Open phpMyAdmin.

     Create a new database: student_course_hub.

     Import the file student_course_hub.sql into the database.

2️. Upload Staff Photos
      Create a folder named staff_photo/ in your project directory.

     Upload all staff images into this folder (e.g., alice.jpg, Brian.jpg).

     Make sure the image names match the Photo column in the database.

3️. Run the Website
     Move the project folder into XAMPP's htdocs/ directory.

     Start Apache and MySQL in XAMPP.

     Open http://localhost/staff/staff.php to view staff members.
     
# How to Use the System

1. Viewing Staff
     Open staff.php to see all staff members.

     Search for a staff member by name or filter by job title.

2. Viewing a Staff Profile
     Click "View Profile" to open their full details.

     You will see their photo, job title, biography, email, and phone number.



     