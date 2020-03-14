# Cake Base 5 Framework

[![Build Status](https://img.shields.io/badge/build-passing-brightgreen)](https://travis-ci.org/matibaski/cake-base-5)
[![PHPVersion](https://img.shields.io/badge/PHP%20Version-7.4.x-brightgreen)](https://github.com/phpstan/phpstan)

A base for creating applications with [CakePHP](https://cakephp.org) 4.x. made by [matibaski](https://matibaski.ch)

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Requirements
- Composer
- PHP 7.4.*
- MySQL/MariaDB
- PHPUnit

## Installation & Configuration

1. Clone this repository.
2. Run `composer install` in the root directory of this project.
3. Clone `/config/app_local.base.php` to `/config/app_local.php` and edit it:
   -> Enable or disable `DEBUG`
   -> Edit database configuration
   -> Edit mail transport configration
4. Edit `/config/settings.php`:
   -> Edit Project name
5. Import SQL Dump from `/config/sql/default.sql` to MySQL/MariaDB
6. In Terminal go to root directory of project and run:
```bash
bin/cake server
```
7. Visit `http://localhost:8765`.
8. Logins
   - admin@cakebase.com / `$123Vier!`
   - user@cakebase.com  / `$123Vier!`

## Testing

- PHPStan
  `./vendor/bin/phpstan`

## Layout & Plugins

- [Bootstrap](https://getbootstrap.com/docs/4.4/) (v4.4) CSS framework.
- [StartBootstrap](https://startbootstrap.com/themes/sb-admin-2/) (v2) CSS theme.
- [FontAwesome](https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use) (v5) icons framework
- [jQuery](https://api.jquery.com/) (v3.4.1) JavaScript framework.
- [jQueryUI](https://api.jqueryui.com/) (v1.12.1) UI actions for jQuery.
- [TinyMCE](https://www.tiny.cloud/docs/) (v5) WYSIWYG editor.
- [Chart.js](https://www.chartjs.org/docs/latest/) (latest) Charts plugin for jQuery.
- [Datatables](https://datatables.net/manual/index) (v1.10.19) Interactive table manipulator for Bootstrap & jQuery.
- [Iconpicker](https://github.com/itsjavi/fontawesome-iconpicker) (latest) Iconpicker for FontAwesome.
- [Nestable](https://github.com/dbushell/Nestable) (latest) Nestable function.
- [Popper.js](https://popper.js.org/docs/v2/) (v2) PopUp framework. Used with Bootstrap.
- [Timeago.js](http://timeago.yarp.com/) (latest) Calculations for time.
