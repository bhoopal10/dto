vendor:
	docker run --rm -v $(shell pwd):/app library/composer install

test: vendor
	./vendor/bin/phpunit

clean:
	rm -rf ./vendor