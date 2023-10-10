## About this project

`ims-laravel-admin-starter` is a streamlined Admin panel & API starter application built using the powerful [Laravel 10](https://laravel.com/) framework and [Filment 3](https://filamentphp.com/).

Our primary focus is to provide you with a hassle-free and ready-to-use local development starter project.

Unlike traditional API generators or code generators, this project simplifies the process of setting up your local development environment. It enables you to jumpstart your Laravel-based API development and admin panel development without unnecessary complexities. This allows you to focus on building your application logic rather than spending time on initial setup.

## Features

-   Role and permission-based operations
-   User management
-   Profile settings

## Accessing the Admin Panel

Once you have set up the Project using the provided instructions, you can access the admin panel by visiting the `/admin` route in your web browser.

### Logging In

If you have run the seed command during the setup process, you can log in using the following credentials:

```bash
email: superadmin@ims.com
password: 123456

email: admin@ims.com
password: 123456
```

### Role and Permission-Based Operations

The `ims-laravel-admin-starter` supports role and permission-based operations to control access to various functionalities within your admin panel. You can define roles with specific permissions and assign them to users as needed.

Explore this project and experience the convenience of a ready-made local development environment for your Laravel-based APIs and Admin Panels.

![demo](demo.png "Ims Admin Starter")

## Required Commands to run locally

1.**Create Your Project from the Template:**

Begin by creating your project using the provided template.

2.**Clone the Project:**

Clone the created project repository to your local machine by running the following command, replacing `#your project git url` with your project's Git URL:

```bash
git clone git@github.com:Innovix-Matrix-Solutions/your-project.git #your project git url
```

3.**Navigate to the Project Directory:**

Move to the project directory using the following command:

Go to the project directory

```bash
cd your-project
```

4.**Copy .env.example to .env:**

Before proceeding, copy the .env.example file to .env to set up your environment variables:

```bash
cp .env.example .env
```

5.**Install Local Development Packages:**
To install local development packages, including Husky and other Laravel-specific packages, run the following commands:

```bash
npm install #for husky and other Laravel packages
npx husky install #only once
```

To install Composer packages needed for CS Fixer to run independently outside of the Docker shell, run:

```bash
composer install
```

6.**Start Docker and run:**
Launch Docker and run the application with the following command:

```bash
docker-compose up
```

Should be found running in port `8000`
and `phpmyadmin` running at port `8080`

7.**Running Migration and Other Commands:**
To execute Laravel-specific commands like migrations,queue,schedule,csfixer etc use the following command:

```bash
docker-compose exec app bash
```

8.**Runnig on Laragon**
If you prefer not to use Docker for local development, you can use [Laragon](https://github.com/leokhoa/laragon) to set up and run the Dokani backend on your local machine. Laragon is a powerful tool for local web development with a range of features.

9.**Running Migration and Seeder**
To initialize the database and start with some default data, you can run migrations and seeders using the following commands:

**_Step 1: Migrate the Database_**

The `php artisan migrate` command is used to create database tables based on your application's migration files. Run the following command:

```bash
php artisan migrate
```

**_Step 2: Seed the Database_**
To populate the database with default data, including users or initial records, you can use seeders. Use the php artisan db:seed command to run seeders:

```bash
php artisan db:seed
```

**_Step 3: Migrate and Seed in One Command_**
To both migrate the database and seed it in a single command, you can use:

```bash
php artisan migrate --seed
```

This command combines the migration and seeding steps, making it convenient for initial setup.

10.**Generate IDE Helper Files:**
Generate general IDE helper files for improved code autocompletion and navigation by running:

```bash
php artisan ide-helper:generate
```

Generate IDE model helper files without writing to model files using:

```bash
#use any one of this two commands
php artisan ide-helper:models -N
php artisan ide-helper:models --nowrite
```

11.**Fix PHP Lint and Run CS Fixer:**
To fix PHP lint issues and run the Code Style Fixer, use the following command:

```bash
php artisan csfixer:run
```

12.**Run App health Check:**
After starting the app, it's essential to verify its health by performing the following steps:

Open your web browser or use a tool like `curl` to access the health check endpoint:

```bash
http://127.0.0.1:8000/api/healthz
```

Upon hitting the health check endpoint, the app should respond with a JSON object similar to the following:

```json
{
    "cache": true,
    "http": true,
    "storage": true,
    "database": true,
    "migration": true
}
```

If you receive a response like this, congratulations! Your app is healthy and functioning correctly.

Verifying the health of your application is an essential step to ensure that all components and services are running as expected. This check can help you identify and resolve issues promptly.

Remember to perform this health check regularly, especially after making significant changes to your application or its environment.

## Running Test

To execute tests for your application, utilize the following command:

```bash
./vendor/bin/pest
```

Running tests is crucial to ensure the reliability and correctness of your application's functionality. The above command will initiate the testing process and provide you with valuable insights into the quality of your codebase.

## Performance Tips

Some Performance Tips for filament

### Icon cache

To optimize the performance of the Filament app, you can use the `php artisan icons:cache` command to cache icons. This command preloads and caches the icons used in your application, resulting in faster load times.

```bash
php artisan icons:cache
```

## Extra Artisan Commands

This project provides additional Artisan commands to simplify your workflow and enhance productivity.

### Run PHP CS Fixer

```bash
php artisan csfixer:run
```

This command ensures that your code adheres to the predefined coding standards, making your codebase clean and readable.

### Create a Service

Creating services for your application is made effortless. Use the following command to generate a service:

```bash
php artisan make:service subfolder/ServiceName
```

Replace subfolder and ServiceName with the actual values you need. You can also create a service without a subfolder:

```bash
php artisan make:service TestService
```

The newly created service will be located at `app/Http/Services/TestService.php`, ready to handle your application's business logic.

### Generate a Trait

Traits are reusable code components that enhance code organization. To create a new trait, simply run:

```bash
php artisan make:trait TestTrait
```

This command generates a new trait file for your project, promoting code reusability and maintainability.

Leverage these Artisan commands to streamline your development process and maintain a well-structured codebase.

## Authors

-   [@AHS12](https://www.github.com/AHS12)

## License

This project is brought to you by Innovix Matrix System and is released as open-source software under the [MIT license](https://opensource.org/licenses/MIT).

Feel free to use, modify, and distribute this starter project in accordance with the MIT license terms. We encourage collaboration and welcome contributions from the community to make this project even better.
