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

### How It Works

When you push the application here's what happens.

1. The local bits are pushed to your target.  This is small, six files around 30k. It includes the changes we made and a build pack extension for PHPMyAdmin.
1. The server downloads the [PHP Build Pack] and runs it.  This installs HTTPD and PHP.
1. The build pack sees the extension that we pushed and runs it.  The extension downloads the stock PHPMyAdmin file from their server, unzips it and installs it into the `htdocs` directory.  It then copies the rest of the files that we pushed and replaces the default PHPMyAdmin files with them.  In this case, it's just the `config.inc.php` file.
1. At this point, the build pack is done and CF runs our droplet.

### Notes

This php app uses the PDO object; this requires the pdo and pdo_mysql extensions to be enabled; this is taken care of in the extensions.ini file in the .bp_config\php\php.ini.d subdirectory.

Portions of this repo are based on these two posts:
https://www.taniarascia.com/create-a-simple-database-app-connecting-to-mysql-with-php/
https://lornajane.net/posts/2017/connecting-php-to-mysql-on-bluemix
