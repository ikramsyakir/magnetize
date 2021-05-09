<p align="center"><img src="https://raw.githubusercontent.com/ikramsyakir/magnetize-web/main/public/images/magnetize-logo.png" width="400"></p>

# Magnetize

Magnetize is a web application built with modern technologies such as Laravel, Bootstrap 4, RESTful API etc. The purpose I built this software because I want to keep this software up to date with current modern technology using the framework that I developed. Aside from that, I use this software as an API to learn other frameworks (Mobile Apps, SPA, Desktop Apps etc)

## 🖥 Requirements

The following tools are required in order to start the installation.

* PHP 7.3 or higher
* Database (eg: MySQL, MariaDB)
* Web Server (eg: Nginx, Apache)
* Local Development (Valet for Mac or Laragon for Windows)

## 🚀 Installation

- Clone the repository with `git clone`
- Copy __.env.example__ file to __.env__ and edit database credentials there
- Run `composer install`
- Run `php artisan key:generate`
- Run `php artisan migrate --seed` (it has some seeded data for your testing)
- Set up a working e-mail driver like [Mailtrap](https://mailtrap.io/)
- Run `php artisan horizon` for queue

You can now visit the app in your browser by visiting [https://magnetize.test](http://magnetize.test). If you seeded the database you can login into a test account with **`admin`** & **`password`**.
