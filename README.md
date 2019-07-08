# DFMS_Project
Document flow management system (DFMS)

Getting Start
------------
### Prerequisites
- [Git](https://git-scm.com/) 2.17.0 *or newer.*
- [PHP](https://www.php.net/) 7.2.0 *or newer.*
- [PHP Extensions]
    - MongoDB (http://php.net/manual/en/mongodb.installation.php)
- [Composer](https://getcomposer.org/) 1.6.0 *or newer.*
- [NodeJS](https://nodejs.org/en/) 11.3.0 *or newer.*

Installation
------------
Make sure you have the MongoDB PHP driver installed. [MongoDB Extensions](http://php.net/manual/en/mongodb.installation.php)

Install [jenssegers/mongodb](https://github.com/jenssegers/laravel-mongodb/blob/master/README.md) package for manage mongodb with laravel:

```
composer require jenssegers/mongodb
```

Install [jQuery Form Builder](https://formbuilder.online) package for using plugin that gives users to create forms with drag and drop component (You need to install [NodeJs](https://nodejs.org/en/) first)

```
npm i --save formBuilder
```

And setup project:

```
composer update
```

### Environment Configuration

Copy the `.env.example` to `.env`

```
cp .env.example .env
```

And edit the .env file with your configuration

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

Generate application encryption key

```
php artisan key:generate
```

Test application with `php artisan`

```
php artisan serve
```


## Authors
- **Panupong Choragam**
- **Patchareeporn Sricharoen**
- **Ratchanon Bunchamroon**









