all:
	cp -Ru src/* lib/

test: all
	php test/sqlmapper.php
	php test/user.php

clean:
	rm lib/acl.php
	rm lib/datatype -R
	rm lib/form.php
	rm lib/group.php
	rm lib/module.php
	rm lib/sqlmapper.php
	rm lib/user.php
