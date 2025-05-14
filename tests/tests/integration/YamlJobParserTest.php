<?php
namespace App\Tests\tests\integration;
/**
 * @group kiwis
 */

use App\Context\JobSystem\Infrastructure\YamlJobParser;
use App\Tests\Support\IntegrationTestCase;

class YamlJobParserTest extends IntegrationTestCase
{

    public function testItParsesYaml()
    {
        /**
         * @var YamlJobParser $yamlParser
         */
        $yamlParser = $this->tester->grabService(YamlJobParser::class);
        $parseResult = $yamlParser->parse();
    }
}
