<h1>Net Nutrition 2.0</h1>

<h3>Set Up</h3>
<ol>
  <li>
  Execute "git clone https://git.linux.iastate.edu/309Fall2017/YT_B_5_NetNutrition2.0.git" to download the project
  </li>
  <li>
  Execute "composer install" to download all project server side dependencies
  </li>
  <li>
  Execute "npm install" to download all project client side dependencies
  </li>
  <li>
  For up to date app.js and app.css files execute "npm run dev"
  </li>
  <li>
  Create a .env file under the base folder structure. Simply copy the contents of .env.example and change items as nessessary
  </li>
  <li>
  Execute "php artisan key:generate" to generate a csrf key cypher seed
  </li>
  <li>
  Execute "php artisan migrate --seed" to generate the database structure and seed with test data
  </li>