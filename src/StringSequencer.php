<?php

namespace Fuitad\StringSequencer;

use Fuitad\StringSequencer\Exceptions\InvalidStringPassed;
use Fuitad\StringSequencer\Exceptions\SequenceRegexNotMatched;

class StringSequencer
{
    /**
     * @var int
     */
    protected $start = 1;
    /**
     * @var int
     */
    protected $step = 1;
    /**
     * @var int
     */
    protected $end = 1;
    /**
     * @var string
     */
    protected $format = "%s";

    /**
     * @var string
     */
    protected $originalString = '';

    /**
     * @var string
     */
    protected $replace = '';

    /**
     * @var boolean
     */
    protected $parsed = false;

    /**
     * @var string
     */
    protected static $regex = '/\[:(?P<start>\d+):(?:(?P<step>\d+):)?(?:(?P<end>\d+):)?(?:(?P<format>[\d\w%]+):)?\]/i';

    /**
     * @param string $string
     * @return array
     */
    public static function from($string = false)
    {
        $stringSequencer = new self($string);

        return $stringSequencer->parse()->sequence();
    }

    /**
     * @param string $string
     * @return array
     */
    public static function multi($string = false)
    {
        if (!is_string($string) || !strlen($string)) {
            throw new InvalidStringPassed;
        }

        $blocksFound = preg_match_all(self::$regex, $string);

        if (!$blocksFound) {
            return [];
        }

        $result = [$string];
        $counter = 1;

        while ($counter <= $blocksFound) {
            $newResult = [];

            foreach ($result as $str) {
                $newResult = array_merge($newResult, self::from($str));
            }

            $result = $newResult;

            $counter++;
        }

        return $result;
    }

    /**
     * @param $string
     * @return $this
     */
    public function __construct($string = false)
    {
        if (!is_string($string) || !strlen($string)) {
            throw new InvalidStringPassed;
        }

        $this->originalString = $string;

        return $this;
    }

    /**
     * @return $this
     */
    public function parse()
    {
        if (!preg_match(self::$regex, $this->originalString, $matchedBlocks)) {
            throw new SequenceRegexNotMatched;
        }

        $this->replace($matchedBlocks[0]);

        foreach (['start', 'step', 'end', 'format'] as $key) {
            if (array_key_exists($key, $matchedBlocks)) {
                $this->$key($matchedBlocks[$key]);
            }
        }

        $this->parsed = true;

        return $this;
    }

    /**
     * @return array
     */
    public function sequence()
    {
        if (!$this->parsed) {
            $this->parse();
        }

        $result = [];

        if (!is_numeric($this->step)) {
            return $result;
        }

        $counter = $this->start;

        while ($counter <= $this->end) {
            $result[] = $this->str_replace_once($this->replace, sprintf($this->format, $counter), $this->originalString);

            $counter += $this->step;
        }

        return $result;
    }

    /**
     * @param int $startNumber
     * @return $this
     */
    public function start($startNumber)
    {
        $this->start = $startNumber;
        return $this;
    }

    /**
     * @param int $stepNumber
     * @return $this
     */
    public function step($stepNumber)
    {
        $this->step = $stepNumber;
        return $this;
    }

    /**
     * @param int $endNumber
     * @return $this
     */
    public function end($endNumber)
    {
        $this->end = $endNumber;
        return $this;
    }

    /**
     * @param string $formatString
     * @return $this
     */
    public function format($formatString)
    {
        $this->format = $formatString;
        return $this;
    }

    /**
     * @param string $string
     * @return $this
     */
    public function replace($string)
    {
        $this->replace = $string;
        return $this;
    }

    /**
     * @param string $search
     * @param string $replace
     * @param string $subject
     * @return string
     */
    protected function str_replace_once($search, $replace, $subject)
    {
        $firstChar = strpos($subject, $search);
        if ($firstChar !== false) {
            $beforeStr = substr($subject, 0, $firstChar);
            $afterStr = substr($subject, $firstChar + strlen($search));
            return $beforeStr . $replace . $afterStr;
        } else {
            return $subject;
        }
    }

}
