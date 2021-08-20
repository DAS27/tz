setup:
	make -C src setup
	make migrate
	make seed

migrate:
	make -C docker migrate

migrate:
	make -C docker seed