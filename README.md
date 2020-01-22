## CloudFoundry PHP and MySQL Example Application

This is an example PHP application which can be run on CloudFoundry with MySQL.

### Usage

1. Clone the app (i.e. this repo).

   ```bash
   git clone https://github.com/cloudfoundry-samples/php-mysql
   cd php-mysql
   ```

1. If you don't have one already, create a MySQL service.

   ```bash
   cf create-service p.mysql db-medium mysql-test
   ```
   *If you have an existing DB service with some arbitary name, please re-name the service such that it contains the string `mysql`. The `config.inc.php` file will automatically configure MySQL services if the plan is ClearDb or Pivotal MySQL, if they are tagged with `mysql` or if the service name contains the word `mysql`. If you do not follow this pattern, your MySQL service will require manual configuration.*

1. Edit the `manifest.yml` file. If your service is not named `mysql-test`, change the name in the manifest file. Random route is set to avoid conflicts with other users.

1. Push it to CloudFoundry.

   ```bash
   cf push
   ```

  Access your application URL in the browser.

### Notes

This php app uses the PDO object; this requires the pdo and pdo_mysql extensions to be enabled; this is taken care of in the extensions.ini file in the .bp_config\php\php.ini.d subdirectory.

Portions of this repo are based on these two posts:
https://www.taniarascia.com/create-a-simple-database-app-connecting-to-mysql-with-php/
https://lornajane.net/posts/2017/connecting-php-to-mysql-on-bluemix
