test-feature:
	./vendor/bin/sail php artisan test --testsuite=Feature --stop-on-failure

build-production:
	docker build --pull --file=docker/production/nginx/Dockerfile -t ${REGISTRY_ADDRESS}-nginx:${IMAGE_TAG} .
	docker build --pull --file=docker/production/php-fpm/Dockerfile -t ${REGISTRY_ADDRESS}-php-fpm:${IMAGE_TAG} .
	docker build --pull --file=docker/production/php-cli/Dockerfile -t ${REGISTRY_ADDRESS}-php-cli:${IMAGE_TAG} .
	docker build --pull --file=docker/production/mysql/Dockerfile -t ${REGISTRY_ADDRESS}-mysql:${IMAGE_TAG} .

push-production:
	docker push ${REGISTRY_ADDRESS}-nginx:${IMAGE_TAG}
	docker push ${REGISTRY_ADDRESS}-php-fpm:${IMAGE_TAG}
	docker push ${REGISTRY_ADDRESS}-php-cli:${IMAGE_TAG}
	docker push ${REGISTRY_ADDRESS}-mysql:${IMAGE_TAG}
