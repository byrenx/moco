FROM php:5.6-alpine

COPY . /src

WORKDIR /src

CMD ["php", "./index.php"]