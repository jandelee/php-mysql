## CloudFoundry PHP and MySQL Example Application

This is an example PHP application which can be run on CloudFoundry with MySQL.

### Usage

1. Clone the app (i.e. this repo).

   ```bash
   git clone https://github.com/jandelee/php-mysql
   cd php-mysql
   ```

1. If you don't have one already, create a MySQL service.

   ```bash
   cf create-service p.mysql db-medium mysql-test
   ```

1. If the service name for the MySQL service is not p.mysql, make sure to change the value that the service_name variable is set to in read.php, around line #7.  The service name is what is displayed in the "service" column when executing the "cf marketplace" command.

1. In the MySQL service, create a database with the name "test", and with columns id, firstname, lastname, and email.  Populate several rows of data into this table; this data will be displayed by the application.

1. Edit the `manifest.yml` file. If your service is not named `mysql-test`, change the name in the manifest file. Random route is set to avoid conflicts with other users.

1. Push it to CloudFoundry.

   ```bash
   cf push
   ```

  Access your application URL in the browser.

### Notes

If you are perusing this repo in order to determine how to interact with a database on Cloud Foundry, the meat is at the beginning of read.php, which shows how to extract the database connection parameters from VCAP_SERVICES and use them to instantiate a PDO object.

This php app uses the PDO object; this requires the pdo and pdo_mysql extensions to be enabled; this is taken care of in the extensions.ini file in the .bp_config\php\php.ini.d subdirectory.

Portions of this repo are based on these two posts:
https://www.taniarascia.com/create-a-simple-database-app-connecting-to-mysql-with-php/
https://lornajane.net/posts/2017/connecting-php-to-mysql-on-bluemix
