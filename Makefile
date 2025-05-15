.PHONY: test-integration
test-integration:
	# using group: make test-integration GROUP=kiwi
	vendor/bin/codecept run integration $(if $(GROUP),--group $(GROUP))


# stub server for Job Runner (testing only)
.PHONY: stub-server
stub-server:
	php -S localhost:9999 -t tests/tests/stubs tests/tests/stubs/server.php