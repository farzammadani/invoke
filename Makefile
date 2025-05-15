.PHONY: test-integration
test-integration:
	vendor/bin/codecept run integration
#	vendor/bin/codecept run integration --group kiwi --debug


