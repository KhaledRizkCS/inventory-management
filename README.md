# Inventory Management System

This project utilizes Laravel as a framework to provide a basic inventory management system. This system has an single endpoint that receives an order from the user. The order is then processed and the relevant inventory is updated accordingly.

The processing works as follows:

-   The system checks if the order is valid. If it is not, it returns an error message.
-   If the order is valid, the system checks if there's enough stock in the inventory to satisfy the order. If not, a 400 response is returned.
-   If there's enough stock, the used stock for the order is deducted from the inventory and the order is created with its relations with the used products.
-   If any of the used inventory items' stock go below 50%, an email is sent to the vendor notifying them of such.

## Technology Stack

-   Laravel Framework
-   Eloquent ORM
-   PostgreSQL DB
-   PHPUnit Testing Framework

## Get Started

### Clone The Repo

```shell
git clone https://github.com/KhaledRizkCS/inventory-management
cd inventory-management
```

### Install the dependencies

```shell
composer install
```

### Migrate and seed the database

```shell
php artisan migrate
php artisan db:seed
```

### Serve the app

```shell
php artisan serve
```

### Run the tests

```shell
./vendor/bin/phpunit  tests
```

### API Documentation

| /api/ | GET / | POST / | GET /:id | PATCH /:id | DELETE /:id |
| ----- | ----- | ------ | -------- | ---------- | ----------- |
| order |       | ✅     |          |            |             |

### Example Payload

```shell
{
"products": [
  {
  "product_id": 1,
  "quantity": 5
  }
]
}
```
