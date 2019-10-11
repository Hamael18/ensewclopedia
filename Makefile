## Toutes les commandes ci-dessous sont à lancer dans un terminal, dans le dossier racine du projet.
## Elles doivent être préfixées de 'make ' puis le nom de la commande souhaitée


## Commande à lancer une seule fois lors de la première install du projet sur le pc
install:
	docker-compose build
	docker-compose up -d
	docker-compose exec symfony composer install
	docker-compose exec symfony npm install

## Commande pour lancer le projet (équivalent du bin/console s:r). Si tu éteins ton pc, il faudra surement la relancer
## Tu peux checker les docker qui tournent sur ton pc dans un terminal avec 'docker ps'
## EN DEHORS DE LA CONSOLE DOCKER
start: ## Start the project
	docker-compose up -d
	@echo "started on http://127.0.0.1:8909"
	@echo "PMA on http://127.0.0.1:8919/"

## Arrête le container et les images à l'intérieur (stoppe le serveur et la BD toussa)
## On ne s'en sert quasiment jamais. Il y a une partie des dev qui disent qu'il faut make stop avant de git commit et push
## mais jamais rencontré de souci (seulement greffée ^^)
## EN DEHORS DE LA CONSOLE DOCKER
stop:
	docker-compose down --remove-orphans

## Permet de lancer la console docker
## Tous les bin/console, composer require, npm require, ...
## Pour sortir de la console docker, tape : exit
console: ## Start a symfony console
	docker-compose exec symfony bash

## Permet de réindexer elastic Search
## DANS LA CONSOLE DOCKER
elastic:
	php bin/console elastic:reindex

## Permet de vider le cache (équivalent voir en dessous)
## DANS LA CONSOLE DOCKER
cc:
	php bin/console cache:clear

## Permet de compiler webpack une fois
## DANS LA CONSOLE DOCKER
webpack:
	./node_modules/.bin/encore dev

## Permet de builder webpack (une fois le make install fait)
## DANS LA CONSOLE DOCKER
wp-watch: #WebPack Encore Watch
	./node_modules/.bin/encore dev --watch

## Permet d'appliquer les migrations à la BD du docker et de lancer les fixtures
## DANS LA CONSOLE DOCKER
migrate:
	php bin/console d:m:m
	php bin/console d:f:l

## Lance les tests
## DANS LA CONSOLE DOCKER
test:
	cp phpunit.xml.dist phpunit.xml
	php bin/console doc:schem:up --force
	php bin/console doctrine:fixtures:load -n
	php bin/phpunit tests/ -v --coverage-clover var/coverage/phpunit.coverage.xml --log-junit var/coverage/phpunit.report.xml

.PHONY: test build init