.PHONY: test-integration
test-integration:
	# using group: make test-integration GROUP=kiwi
	vendor/bin/codecept run integration $(if $(GROUP),--group $(GROUP))


