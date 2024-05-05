# Maacars
Maacars is a simple car rental API for demonstration purposes. It allows users to rent cars and manage their rentals.

## Getting Started

### Prerequisites
you need to have the following installed on your machine

- php 8.1 or higher
- composer
- mysql 8.0 or higher
- git
- symfony-cli (optional)

### Installation
1. Clone the repository
```$ git clone git@github.com:maamoune04/maacars.git```
2. Change into the directory
```$ cd maacars```
3. Install the dependencies
```$ composer install ```
4. Create a new file called .env.local or edit the .env file and add your database credentials and other configurations
5. Create the database
```$ php bin/console doctrine:database:create```
6. Run the migrations
```$ php bin/console doctrine:migrations:migrate```
7. Load the fixtures
```$ php bin/console doctrine:fixtures:load```
8. Generate ssl keys
      ```$ php bin/console lexik:jwt:generate-keypair```
9. Start the server
```$ symfony serve``` or if you don't have Symfony-CLI run  ```$ php -S 127.0.1:8000 -t public```
10. Visit the api documentation at
```http://127.0.0.1:8000/api```

## Built With
- [Symfony](https://symfony.com/) - The PHP framework used
- [Api Platform](https://api-platform.com/) - The API framework used

## Authors
- **Maamoune Hassane** - [linkedin](https://www.linkedin.com/in/maamoune-hassane-986a05164/)