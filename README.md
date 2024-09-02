# RecipeBook
**Description**
The Recipe Book Website is a dynamic web application where users can register, log in, and manage their recipes. The application allows users to add, view, edit, and delete recipes, with search and filter functionalities based on keywords and categories.

**Features**  
User Authentication: Secure user registration, login, and logout functionalities.
Recipe Management: Add, view, edit, and delete recipes.
Image Upload: Upload and display images for each recipe.
Search and Filter: Search recipes by keywords or filter them by category.
Responsive Design: The website is responsive and accessible on various devices.

**Technologies Used**
Frontend: HTML, CSS, JavaScript
Backend: PHP
Database: MySQL
Server: Apache (XAMPP)

**File Structure**  
/RecipeBook  
│  
├── /css  
│   └── assign2.css            # Stylesheet for the website  
│  
├── /uploads                   # Directory for uploaded recipe images  
│  
├── /server  
│   ├── db.php                 # Database connection file  
│   ├── recipeDAO.php          # Data Access Object for recipes  
│   ├── recipeClass.php        # Recipe class definition  
│   ├── recipe.php             # Main page for viewing and managing recipes  
│   ├── recipeEdit.php         # Page for editing/updating recipes  
│   ├── navigation.php         # Navigation bar  
│   └── login.php              # User login page  
│  
├── /README.md                 # Project documentation  
└── /index.php                 # Entry point of the website  

**Installation**  
1. Clone the repository:  

git clone https://github.com/ScarletWQ/RecipeBook.git

2. Move into the project directory:

cd RecipeBook

3. Set up the database:

  Import the recipe_book.sql file located in the server directory into your MySQL database.
  Update the db.php file with your database credentials.

4. Start the Apache server using XAMPP or similar.

5. Access the project via http://localhost/RecipeBook/ in your browser.

**Usage**
Register: Create a new account to manage your recipes.
Login: Access your account to view, add, edit, or delete recipes.
Search & Filter: Use the search bar or category filter to find specific recipes.
Future Enhancements
Implement user roles and permissions.
Add social media sharing features.
Enhance the UI/UX with modern design frameworks.
Contributing
Contributions are welcome! Please fork the repository and create a pull request with a detailed description of your changes.

**License**
This project is licensed under the MIT License. See the LICENSE file for more details.
