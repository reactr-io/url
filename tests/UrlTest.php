<?php

namespace ReactrIO\Url;

require_once(realpath(__DIR__.'/../vendor/autoload.php'));

class UrlTest extends \PHPUnit\Framework\TestCase
{
    function test_fromUrl()
    {
        $url = Url::fromString("http://localhost/wp-json/v2/?foo=bar");
        $this->assertInstanceOf(Url::class, $url);

        $this->assertEquals("http", $url->getScheme());
        $this->assertEquals("localhost", $url->getHost());
        $this->assertEquals("/wp-json/v2/", $url->getPath());
        $this->assertEquals("foo=bar", $url->getQuery());
        return $url;
    }

    function test_manipulatingUrl()
    {
        $url = $this->test_fromUrl();
        $this->assertEquals('foobar', $url->withHost('foobar')->getHost());

        $url = $url->withHost('foobar');
        $this->assertEquals("http", $url->getScheme());
        $this->assertEquals("foobar", $url->getHost());
        $this->assertEquals("/wp-json/v2/", $url->getPath());
        $this->assertEquals("foo=bar", $url->getQuery());

        $url = $url->withPath('/wp-json/v2/reactr-bg');
        $this->assertEquals('/wp-json/v2/reactr-bg', $url->getPath());
        $this->assertEquals("http", $url->getScheme());
        $this->assertEquals("foobar", $url->getHost());
        $this->assertEquals("foo=bar", $url->getQuery());

        $url = $url->withPort(80);
        $this->assertEquals('/wp-json/v2/reactr-bg', $url->getPath());
        $this->assertEquals("http", $url->getScheme());
        $this->assertEquals("foobar", $url->getHost());
        $this->assertEquals("foo=bar", $url->getQuery());
        $this->assertEquals(80, $url->getPort());
    }
}