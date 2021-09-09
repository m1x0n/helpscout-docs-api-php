docker run --rm --interactive --tty \
--volume $PWD:/app \
composer require rector/rector --dev

./vendor/bin/rector process src tests
