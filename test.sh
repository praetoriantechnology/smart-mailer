docker build -t smart-mailer-tester .
docker run -v "${PWD}:/var/www/html" smart-mailer-tester /usr/local/bin/composer test