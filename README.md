<p align="center"><img src="https://raw.githubusercontent.com/ikramsyakir/magnetize-web/main/public/images/magnetize-logo.png" width="400"></p>

# Magnetize

Magnetize is a web application built with modern technologies such as Laravel, Bootstrap 4, RESTful API etc. The purpose I built this software because I want to keep this software up to date with current modern technology using the framework that I developed. Aside from that, I use this software as an API to learn other frameworks (Mobile Apps, SPA, Desktop Apps etc)

## 🖥 Requirements

The following tools are required in order to start the installation.

* PHP 8.2 or higher
* Database (eg: MySQL, MariaDB)
* Web Server (eg: Nginx, Apache)
* Local Development (Valet for Mac or Laragon for Windows)

## 🚀 Installation

1. Clone the repository with `git clone`
2. Copy __.env.example__ file to __.env__ and edit database credentials there

    ```shell
    cp .env.example .env
    ```

3. Install composer packages

    ```shell
    composer install
    ```

4. Install npm packages and compile files

    ```shell
    npm install
    ```

   For **Development**:
    ```shell
    npm run dev
    ```

   For **Production**:
    ```shell
    npm run build
    ```

5. Generate `APP_KEY` in **.env**

    ```shell
    php artisan key:generate
    ```

6. Running migrations and all database seeds

    ```shell
    php artisan migrate --seed
    ```

7. Create the symbolic link

    ```shell
    php artisan storage:link
    ```

8. Set up a working e-mail driver like [Mailrap](https://mailtrap.io/) or use [MailHog](https://github.com/mailhog/MailHog) (local)
9. Running horizon for queue

    ```shell
    php artisan horizon
    ```

You can now visit the app in your browser by visiting [https://magnetize.test](http://magnetize.test). If you seeded the database you can login into a test account with **`admin`** & **`password`**.
