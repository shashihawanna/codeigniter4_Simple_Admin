# codeigniter4_Simple_Admin
Access control logic for two user types: administrators and super administrators.
Multi-user login with permissions

How to run

1.Added database file in root/db => talentedge.sql

2.changes  database connection and app path in .env file
database.default.hostname = localhost
 database.default.database = talentedge
 database.default.username = root
 database.default.password = root
 database.default.DBDriver = MySQLi
 app.baseURL = 'http://talentedge.test'

3.not added vendor folder in code run => composer update

4. open application url in browser
