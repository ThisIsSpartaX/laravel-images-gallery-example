<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

# Example Image Gallery based on Laravel + S3 + Kraken.io

## Installation

1. Clone

    ```git clone https://github.com/ThisIsSpartaX/laravel-images-gallery-example.git .```

2. Install Vendors

    ```composer install```

3. Generate Your app key

    ```php artisan key:generate ```

4. Set DB credentials in .env file 

    ```
    DB_CONNECTION=
    DB_HOST=
    DB_PORT=
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
    ```

5. Migrate tables

    ```php artisan migrate```

## Set Amazon AWS credentials

Get Api key in IAM Service
https://console.aws.amazon.com/iam/home

Ger bucket information in S3 service https://s3.console.aws.amazon.com/

Set it in environment file:

```
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
AWS_BUCKET=
AWS_URL=
```
## Set Kraken IO credentials
Create account in Kraken IO service https://kraken.io

Get credentials here https://kraken.io/account/api-credentials

Set it in environment file:

```
KRAKEN_API_KEY=
KRAKEN_API_SECRET=
```