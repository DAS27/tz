setup:
	make -C src setup
	make migrate
	make seed
	make chmod
	make mkdir

migrate:
	make -C docker migrate

seed:
	make -C docker seed

mkdir:
	make -C mkdir

chmod:
	make -C chmod