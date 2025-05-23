# Dashboard manager

This product was built using PHP, CSS, HTML, JavaScript, and a database(MySQL).

## Installation

There are several components required in order for the project to run.

### Web Server
The codebase requires you to run a web server. To do so visit the following based on your operating system:
Windows:  [XAMPP](https://www.apachefriends.org)
Mac:      [MAMP](https://www.mamp.info/en)

### Database Setup
The following username and password should be created in order to use this product:

    > Username: csc350
    > Password: xampp

    It is recommended to only allow this user ALL privellages in "Data" and "Structure", no Administration prvilleaes should be granted.

    The database will initialize empty so there are several files to import into the database:
1. The schema is built by importing: `sql/team_red_db_setup.sql` and must be imported before any other SQL files.
2. There are sample users and data availible by importing: `sql/data_insert.sql`. 


## Deployment
To deploy this project after downloading or cloning ensure the project name is 'team-red'. This is important as some parts of the project are hard coded and will break if not named exactly 'team-red'. Copy the whole 'team-red' folder that has been downloaded or cloned to the server, ensure that the project is not copied into a sub folder as there are hardcoded paths that require to be in its own directory under no sub folders.

## Using Team Reds product
After the project has been copied to the server, open a web browser and naviagte to 'team-red' and click on it or type the following without quotes if you are using your local machine:
`localhost/team-red/`
 You should see another folder called 'public'. Click on it and you should be automatically redirected to the landing page, there is no need for index.html or index.php. After importing the data you can access the accounts below with the folowing information:
1. 

    Username: testUser
	Password: TeamRed!
2. 

	Username: studentBlah
	Password: TotallyNotTeamRed!
    
## How to sign Up
    If you sign up please ensure you are using one of these domains: 'gmail.com', 'yahoo.com', 'outlook.com','bmcc.cuny.edu','stu.bmcc.cuny.edu', 'teamred.com'. The site ONLY allows these domains. 
    Also, be sure to check that:
        -Your username is 3-12 characters long
        -Your password is 3-64 characters long
        -Your domain is in the allowed domains above.
