<?php

namespace Tests\Units;
use App\Helpers\App;
use PHPUnit\Framework\TestCase;

class ApplicationClass extends TestCase
{
    public function testItCanGetInstanceOfApplication()
    {
        self::assertInstanceOf(App::class, new App);
    }

    public function testItCanGetBasicApplicationDatasetFromAppClass()
    {
        $application = new App;
        self::assertTrue($application->isRunningFromConsole());
        self::assertSame('test', $application->getEnvironment());
        self::assertNotNull($application->getLogPath());
        self::assertInstanceOf(\Datetime::class, $application->getServerTime());
    }
}