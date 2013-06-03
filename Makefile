all:
	cp -Ru src/* lib/

test: all
	sqlite3 /tmp/test.sqlite < test/database.sql
	php test/sqlmapper.php
	php test/user.php
	php test/group.php
	php test/acl.php
	php test/module.php
	php test/form.php

test-form: all
	sqlite3 /tmp/test.sqlite < test/database.sql
	php test/form.php

clean:
	rm lib/acl.php
	rm lib/datatype -R
	rm lib/form.php
	rm lib/group.php
	rm lib/module.php
	rm lib/sqlmapper.php
	rm lib/user.php
