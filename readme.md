/Team-Red
    /src
        /css                      # Custom styles, Tailwind configurations
            input.css                      
        /js                       # JavaScript files for front-end functionality (e.g., form handling, dynamic content)
        /php                      # PHP files (backend logic, database connections, etc.)
            /includes            # Includes (e.g., header, footer, database connections)
            /functions           # Helper functions (e.g., for task management, authentication)
                /quicklinks
                    add_links.php
            /models               # Models for interacting with the database (e.g., tasks, users)
        /views                    # HTML or PHP templates for different pages (e.g., dashboard.php, settings.php)
            /componenents
                quicklinks_card.php
                weather.php
            quicklink_page.php
            dashboard.php
    /public
        /assets                   # Public assets like images and fonts
            styles.css            #tailwind styles
        index.php                 # Main entry point (could be your dashboard or home page) 
    /config
        config.php                # Configuration file for environment variables, database settings
        .gitignore
        .env
    /sql
    /docs                         # Project documentation (e.g., setup instructions)
    package-lock.json
    package.json
    tailwind.config.js



## Project Setup

This project uses Tailwind CSS, and the following files are excluded from version control:

- **`package-lock.json`**: This allows each team member to manage their own version of dependencies. Please run `npm install` to set up the dependencies on your local machine.
- **`styles.css`**: This is a generated file (compiled from `input.css`). Please run `npm run build` to regenerate the CSS file if you make any changes to the styles.
