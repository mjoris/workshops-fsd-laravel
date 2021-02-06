# Web &amp; Mobile Full-Stack - workshop materials on Laravel
Interactive workshop slides for the course Web &amp; Mobile Full-stack, part of the Professional Bachelor ICT study program @ Odisee, Belgium.

A web-based slideshow containing many PHP/Laravel code examples, which can be interactively executed in the provided Docker multi-container environment.

(CC) Joris Maervoet

## Installation instructions

### Running the slides without working code examples
* Install [git](https://git-scm.com/downloads) and run from your terminal/cmd
```shell
git clone https://github.com/mjoris/workshops-wmfs-laravel.git
```
* Open the file <code>workshops-wmfs-laravel/app/public/slides/index.html</code> in a browser

### Running the slides with working code examples
* Install [git](https://git-scm.com/downloads) and [Docker Desktop](https://www.docker.com/products/docker-desktop).
* Start the Docker Desktop application
* Run from your terminal/cmd
```shell
git clone https://github.com/mjoris/workshops-wmfs-laravel.git
```
* When Docker is up and running, run from your terminal/cmd
```shell
cd workshops-wmfs-laravel
docker-compose up
```
* When the containers are up and running, run from a new terminal/cmd
```shell
cd workshops-wmfs-laravel
docker-compose exec php-web bash
```
From the Bash terminal in the php-web container, run the following commands:
```shell
composer install
cp .env.example .env
php artisan key:generate
```
* Browse to [http://localhost:8080](http://localhost:8080)
* Stop the environment in your terminal/cmd by pressing <code>Ctrl+C</code>
* In order to avoid conflicts with your lab environment, run from your terminal/cmd
```shell
docker-compose down
```

## Recipes and troubleshooting

### Updating the course materials 
* Run from your terminal/cmd, in your <code>workshops-wmfs-laravel</code> directory
```shell
git reset --hard
git pull origin master
```

### <code>docker-compose up</code> does not start one or more containers
* Look at the output of <code>docker-compose up</code>. When a container (fails and) exits, it is shown as the last line of the container output (colored tags by container)
* Alternatively, start another terminal/cmd and inspect the output of <code>docker-compose ps -a</code>. You can see which container exited, exactly when.
* Probably one of the containers fails because TCP/IP port 8000, 8080 or 3307 is already in use on your system. Stop the environment, change the port in <code>docker-compose.yml</code> en rerun <code>docker-compose up</code>.

### Restoring the database (tables)
Might be necessary when this repository contains *raw* database updates.
* Before running <code>docker-compose up</code>, delete all files in the <code>mysql-data</code> directory

Nevertheless, Laravel-related database updates will be provided in the form of Migrations, which can be administered by running ```php artisan migrate``` from the php-web container
