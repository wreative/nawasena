<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<img alt="Laravel Version" src="https://img.shields.io/badge/Laravel%20Version-9.15.0-informational">
<img alt="GitHub repo size" src="https://img.shields.io/github/repo-size/wreative/nawasena">
<a href="https://www.codacy.com/gh/wreative/nawasena/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=wreative/nawasena&amp;utm_campaign=Badge_Grade"><img src="https://app.codacy.com/project/badge/Grade/37f9df0519b949f787d2ec4b6cb38e32"/></a>
<a href="https://deepscan.io/dashboard#view=project&tid=17948&pid=21286&bid=607488"><img src="https://deepscan.io/api/teams/17948/projects/21286/branches/607488/badge/grade.svg" alt="DeepScan grade"></a>
<a href="https://github.com/rdp77/veyaz/blob/master/LICENSE"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Requirement

- [Composer](https://getcomposer.org/).
- [Node JS](https://nodejs.org/en/) (Optional).
- Code editor for doing coding activities [Visual Studio Code](https://code.visualstudio.com/) or [Sublime](https://www.sublimetext.com/) or [Atom](https://atom.io/).
- Php and Web server for running laravel in web browser, can use [XAMPP](https://www.apachefriends.org/) or [Laragon](https://laragon.org/).
- Database Management System.

Because it uses Laravel migrations feature it can use any type of DBMS as long as it's a Relational Database.

## Getting Started

1. Clone repository with the command `git clone https://github.com/wreative/nawasena`
2. Installing package form Composer with command `composer install`
3. Installing package module node js with command `node install` (Optional)
4. Run command `php artisan nawasena:setup`
5. Running web application using commands `php artisan serve` or running manually with web server.

Login using username `admin` and password `admin`

## Command Reference

```
  php artisan command:name
```

| Name             | Description    |
| :--------------- | :------------- |
| `nawasena:setup` | Setup nawasena |

## Third-party Library

This template uses several libraries as helpers to improve the template, and can be seen [here](/library.md)

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct) or nawasena [Code of Conduct](https://github.com/wreative/nawasena/blob/master/CODE_OF_CONDUCT.md).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
