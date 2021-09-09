docker run --rm --interactive --tty \
--volume $PWD:/app \
composer require rector/rector --dev

./vendor/bin/rector process src tests

docker run --rm --interactive --tty \
--volume $PWD:/app \
composer require squizlabs/php_codesniffer --dev

./vendor/bin/phpcs --standard=PSR12 src tests

docker run --rm --interactive --tty \
--volume $PWD:/app \
composer require phpstan/phpstan --dev --with-all-dependencies

vendor/bin/phpstan analyse src tests --memory-limit=-1 -l 2
