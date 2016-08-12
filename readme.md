# StringSequencer
==============

PHP package that allows you to parse strings as sequences.

# Installation

Require this package with Composer

```bash
composer require fuitad/string-sequencer
```

## Usage

Import the class in your PHP file

```php
use \Fuitad\StringSequencer;
```

### static from() method:

```php
use \Fuitad\StringSequencer;

$str = "http://www.google.com/page[:1:1:5:].html";
$result = StringSequencer::from($str);
```

Will return

    array:5 [
      0 => "http://www.google.com/page1.html"
      1 => "http://www.google.com/page2.html"
      2 => "http://www.google.com/page3.html"
      3 => "http://www.google.com/page4.html"
      4 => "http://www.google.com/page5.html"
    ]

### static multi() method:

```php
$str = "http://www.google.com/page[:1:1:5:]-[:20:5:40:].html";
$result = StringSequencer::from($str);
```

Will return

    array:25 [
      0 => "http://www.google.com/page1-20.html"
      1 => "http://www.google.com/page1-25.html"
      2 => "http://www.google.com/page1-30.html"
      3 => "http://www.google.com/page1-35.html"
      4 => "http://www.google.com/page1-40.html"
      5 => "http://www.google.com/page2-20.html"
      6 => "http://www.google.com/page2-25.html"
      7 => "http://www.google.com/page2-30.html"
      8 => "http://www.google.com/page2-35.html"
      9 => "http://www.google.com/page2-40.html"
      10 => "http://www.google.com/page3-20.html"
      11 => "http://www.google.com/page3-25.html"
      12 => "http://www.google.com/page3-30.html"
      13 => "http://www.google.com/page3-35.html"
      14 => "http://www.google.com/page3-40.html"
      15 => "http://www.google.com/page4-20.html"
      16 => "http://www.google.com/page4-25.html"
      17 => "http://www.google.com/page4-30.html"
      18 => "http://www.google.com/page4-35.html"
      19 => "http://www.google.com/page4-40.html"
      20 => "http://www.google.com/page5-20.html"
      21 => "http://www.google.com/page5-25.html"
      22 => "http://www.google.com/page5-30.html"
      23 => "http://www.google.com/page5-35.html"
      24 => "http://www.google.com/page5-40.html"
    ]


