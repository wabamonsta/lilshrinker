# LIL Shortner

Simple URL shortner with basic interface and API.

## Language

- PHP
- JavaScript

## System Requirements

- PHP 7^
- nginx / apache

#

## UI Mode

- Browse to site index, submit URL in the form onscreen

## API

```
url: {siteURL}/api
Accepted Methods: GET/POST
```

## GET Request

```
[{

 "originalURL": "http://example.com",
 "frequency":1
},
{

 "originalURL": "http://example2.com",
 "frequency":10
}
...

]

```

## POST Request

The Request

```
{
  "url":"http://google.com"
}
```

The Response

```
{
  "id": "12324" // uniqueid
  "title": "Website Title",
  "shortenURL": "{scheme}://{host}/u/1234",
  "originalURL":"http://google.com"
}
```

#

## TODO

- Migrate from flat file to a database instance
- Collect more metric data
