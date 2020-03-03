<?php

namespace ReactrIO\Url;

require_once('vendor/autoload.php');

/**
 * Provides an interface that matches spatie/url, but is WP-compatible
 */
class Url
{
    /**
     * The parts that compose the url
     */
    protected $_components = [];
    protected $_query = [];

    protected function __construct($components)
    {
        $this->_components = $components;
        if (!isset($this->_components))

        // Set query vars
        unset($this->_components['query']);
        $query = isset($components['query']) ? $components['query'] : '';
        $this->_query = $this->_to_query_assoc_array($query);
    }

    /**
     * Returns a new url instance created from an array of components
     * @param array $components
     * @return self
     */
    protected static function _fromComponents($components=[])
    {
        $klass = self::class;
        return new $klass($components);
    }

    protected function _to_query_assoc_array($query='')
    {
        if ($query) {
            return array_reduce(
                explode('&', $query),
                function($retval, $part) {
                    if (strpos($part, '=') !== FALSE) {
                        $keyAndVal = explode('=', $part);
                        $key = $keyAndVal[0];
                        $val = $keyAndVal[1];
                        $retval[$key] = $val;
                    }
                    else $retval[$part] = NULL;
                    return $retval;
                },
                []
            );
            
        }

        return '';
    }

    /**
     * Generates a url instance from a string
     * @param string $url
     * @return self
     */
    public static function fromString($url)
    {
        return self::_fromComponents(parse_url($url));
    }

    /**
     * Gets the host component of the url
     * @return string
     */
    function getHost()
    {
        return isset($this->_components['host']) ? strval($this->_components['host']) : '';
    }

    /**
     * Sets the host of the url, and returns a new instance
     * @param string $host
     * @return self
     */
    function withHost(string $host)
    {
        $parts = $this->_components;
        $parts['host'] = $host;
        return self::_fromComponents($parts);
    }

    /**
     * Gets the port component of the url
     * @return int|NULL
     */
    function getPort()
    {
        return isset($this->_components['port']) ? intval($this->_components['port']) : 0;
    }

    /**
     * Sets the port of the url
     * @param int $port set to 0 if the port is implicit
     * @return self
     */
    function withPort(int $port)
    {
        $parts = $this->_components;
        $parts['port'] = ($port === 0 ? NULL : $port);
        return self::_fromComponents($parts);
    }

    /**
     * Gets the path component of the url
     * @return string
     */
    function getPath()
    {
        return isset($this->_components['path']) ? strval($this->_components['path']) : '';
    }

    /**
     * Sets the path of the url
     * @param string $path
     * @return self
     */
    function withPath(string $path)
    {
        $parts = $this->_components;
        $parts['path'] = $path;
        return self::_fromComponents($parts);
    }

    /**
     * Gets the scheme component of the url
     * @return string
     */
    function getScheme()
    {
        return isset($this->_components['scheme']) ? strval($this->_components['scheme']) : '';
    }

    /**
     * Returns a new url instance with the given scheme
     * @param string $scheme
     * @return self
     */
    function withScheme(string $scheme)
    {
        $parts = $this->_components;
        $parts['scheme'] = trim($scheme, ':/');
        return self::_fromComponents($parts);
        
    }

    /**
     * Gets the query string of the url
     * @return string
     */
    function getQuery()
    {
        return implode("&", array_reduce(
            array_keys($this->_query),
            function($retval, $key) {
                $val = $this->_query[$key];
                $retval[] = ($val ? "{$key}={$val}" : $key);
                return $retval;
            },
            []
        ));
    }

    /**
     * Returns a new url instance with the provided query string set
     * @param string $query
     * @return self
     */
    function withQuery(string $query)
    {
        $parts = $this->_components;
        $parts['query'] = $query;
        return self::_fromComponents($parts);
    }

    /**
     * Gets the value of a query string argument
     * @param string $key
     * @return string
     */
    function getQueryParameter(string $key)
    {
        return isset($this->_query[$key]) ? $this->_query[$key] : '';
    }

    /**
     * Gets the url with a query string argument set
     * @param string $key
     * @param string $val can be null
     * @return self
     */
    function withQueryParameter(string $key, string $val=NULL)
    {
        $parts = $this->_components;
        $query = $this->_query;
        $query[$key] = $val;
        $retval = self::_fromComponents($parts);
        $retval->_query = $query;
        return $retval;
    }

    /**
     * Gets the url with a query string argument omitted
     * @param string $key
     * @return self
     */
    function withoutQueryParameter(string $key)
    {
        $parts = $this->_components;
        $query = $this->_query;
        unset($query[$key]);
        $retval = self::_fromComponents($parts);
        $retval->_query = $query;
        return $retval;
    }

    /**
     * Converts the url instance to a string
     * @return string
     */
    function toString()
    {
        $parts = $this->_components;
        $parts['query'] = $this->getQuery();
        return http_build_url($parts);
    }

    /**
     * Converts the url instance to a string
     * @return string
     */
    function __toString()
    {
        return $this->toString();
    }
}
