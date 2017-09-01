<h1>Net Nutrition 2.0</h1>

<h3>Project Set Up</h3>
  <h4>Server Set Up</h4>
  1) Download the respective WAMP, LAMP, or MAMP for the given operating system. (WAMP = Windows, Apache, MySQL, PHP; LAMP = Linux, Apache, MySQL, PHP; MAMP = Mac, Apache, MySQL, PHP)<br>
  2) Add a vhost to the vhost config file. Regardless of operating system it should look like the following...
  ```apacheconfig
  <VirtualHost *:80>
      DocumentRoot "/var/www/netnutrition.dev"
      ServerName netnutrition.dev
      ErrorLog "/etc/apache2/logs/netnutrition.dev.log"
      CustomLog "/etc/apache2/logs/netnutrition.dev.log" common
      <Directory  "/var/www/netnutrition.dev">
          AllowOverride All
          Options Indexes FollowSymLinks
          Require local
      </Directory>
  </VirtualHost>
  ```
  3) Add the following lines to your hosts file
  ```bash
  127.0.0.1 netnutrition.dev
  ::1 netnutrition.dev
  ```
  
<ol>
  <h4>Code Set Up</h4>
  <li>
  Execute <code>git clone https://git.linux.iastate.edu/309Fall2017/YT_B_5_NetNutrition2.0.git netnutrition</code> to download the project
  </li>
  <li>
  Execute <code>composer install</code> to download all project server side dependencies
  </li>
  <li>
  Execute <code>npm install</code> to download all project client side dependencies
  </li>
  <li>
  For up to date app.js and app.css files execute <code>npm run dev</code>
  </li>
  <li>
  Create a .env file under the base folder structure. Simply copy the contents of .env.example and change items as nessessary
  </li>
  <li>
  Execute <code>php artisan key:generate</code> to generate a csrf key cypher seed
  </li>
  <li>
  Execute <code>php artisan migrate --seed</code> to generate the database structure and seed with test data
  </li>
</ol>