<?php

use Fuitad\StringSequencer\Exceptions\InvalidStringPassed;
use Fuitad\StringSequencer\StringSequencer;

class StringSequencerTest extends PHPUnit_Framework_Testcase
{
    /** @test */
    public function it_parses_string_with_start_step_end()
    {
        $stringSequencer = new StringSequencer("http://www.google.com/page[:1:1:10:].html");

        $expectedResult = $this->arrayFromJson('["http:\/\/www.google.com\/page1.html","http:\/\/www.google.com\/page2.html","http:\/\/www.google.com\/page3.html","http:\/\/www.google.com\/page4.html","http:\/\/www.google.com\/page5.html","http:\/\/www.google.com\/page6.html","http:\/\/www.google.com\/page7.html","http:\/\/www.google.com\/page8.html","http:\/\/www.google.com\/page9.html","http:\/\/www.google.com\/page10.html"]');

        $this->assertEquals($stringSequencer->sequence(), $expectedResult);
    }

    /** @test */
    public function it_parses_string_with_start_step_end_format()
    {
        $stringSequencer = new StringSequencer("http://www.google.com/page[:1:1:10:%03d:].html");

        $expectedResult = $this->arrayFromJson('["http:\/\/www.google.com\/page001.html", "http:\/\/www.google.com\/page002.html", "http:\/\/www.google.com\/page003.html", "http:\/\/www.google.com\/page004.html", "http:\/\/www.google.com\/page005.html", "http:\/\/www.google.com\/page006.html", "http:\/\/www.google.com\/page007.html", "http:\/\/www.google.com\/page008.html", "http:\/\/www.google.com\/page009.html", "http:\/\/www.google.com\/page010.html"]');

        $this->assertEquals($stringSequencer->sequence(), $expectedResult);
    }

    /** @test */
    public function it_parses_string_with_start_step_end_static()
    {
        $sequence = StringSequencer::from("http://www.google.com/page[:1:1:10:].html");

        $expectedResult = $this->arrayFromJson('["http:\/\/www.google.com\/page1.html","http:\/\/www.google.com\/page2.html","http:\/\/www.google.com\/page3.html","http:\/\/www.google.com\/page4.html","http:\/\/www.google.com\/page5.html","http:\/\/www.google.com\/page6.html","http:\/\/www.google.com\/page7.html","http:\/\/www.google.com\/page8.html","http:\/\/www.google.com\/page9.html","http:\/\/www.google.com\/page10.html"]');

        $this->assertEquals($sequence, $expectedResult);
    }

    /** @test */
    public function it_parses_string_with_start_step_end_format_static()
    {
        $sequence = StringSequencer::from("http://www.google.com/page[:1:1:10:%03d:].html");

        $expectedResult = $this->arrayFromJson('["http:\/\/www.google.com\/page001.html", "http:\/\/www.google.com\/page002.html", "http:\/\/www.google.com\/page003.html", "http:\/\/www.google.com\/page004.html", "http:\/\/www.google.com\/page005.html", "http:\/\/www.google.com\/page006.html", "http:\/\/www.google.com\/page007.html", "http:\/\/www.google.com\/page008.html", "http:\/\/www.google.com\/page009.html", "http:\/\/www.google.com\/page010.html"]');

        $this->assertEquals($sequence, $expectedResult);
    }

    /** @test */
    public function it_parses_string_with_multiple_blocks_static()
    {
        $sequence = StringSequencer::multi("http://www.google.com/page[:1:1:5:]-[:50:2:60:].html");

        $expectedResult = $this->arrayFromJson('["http:\/\/www.google.com\/page1-50.html","http:\/\/www.google.com\/page1-52.html","http:\/\/www.google.com\/page1-54.html","http:\/\/www.google.com\/page1-56.html","http:\/\/www.google.com\/page1-58.html","http:\/\/www.google.com\/page1-60.html","http:\/\/www.google.com\/page2-50.html","http:\/\/www.google.com\/page2-52.html","http:\/\/www.google.com\/page2-54.html","http:\/\/www.google.com\/page2-56.html","http:\/\/www.google.com\/page2-58.html","http:\/\/www.google.com\/page2-60.html","http:\/\/www.google.com\/page3-50.html","http:\/\/www.google.com\/page3-52.html","http:\/\/www.google.com\/page3-54.html","http:\/\/www.google.com\/page3-56.html","http:\/\/www.google.com\/page3-58.html","http:\/\/www.google.com\/page3-60.html","http:\/\/www.google.com\/page4-50.html","http:\/\/www.google.com\/page4-52.html","http:\/\/www.google.com\/page4-54.html","http:\/\/www.google.com\/page4-56.html","http:\/\/www.google.com\/page4-58.html","http:\/\/www.google.com\/page4-60.html","http:\/\/www.google.com\/page5-50.html","http:\/\/www.google.com\/page5-52.html","http:\/\/www.google.com\/page5-54.html","http:\/\/www.google.com\/page5-56.html","http:\/\/www.google.com\/page5-58.html","http:\/\/www.google.com\/page5-60.html"]');

        $this->assertEquals($sequence, $expectedResult);
    }

    /** @test */
    public function it_throws_an_exception_when_no_string_is_passed()
    {
        $this->expectException(InvalidStringPassed::class);

        $stringSequencer = new StringSequencer();
    }

    /** @test */
    public function it_throws_an_exception_when_no_string_is_passed_in_static()
    {
        $this->expectException(InvalidStringPassed::class);

        $sequence = StringSequencer::from();
    }

    /** @test */
    public function it_throws_an_exception_when_no_string_is_passed_in_static_multi()
    {
        $this->expectException(InvalidStringPassed::class);

        $sequence = StringSequencer::multi();
    }

    /** @test */
    public function it_return_an_empty_array_when_end_is_smaller_than_start()
    {
        $sequence = StringSequencer::from("http://www.google.com/page[:10:1:5:].html");

        $this->assertEquals($sequence, []);
    }

    public function arrayFromJson($string)
    {
        return json_decode($string, true);
    }

    /** @test */
    public function it_parses_string_with_start_step_end_and_back_reference()
    {
        $stringSequencer = new StringSequencer("http://www.google.com/page[:1:1:10:]/[\\1].html");

        $expectedResult = $this->arrayFromJson('["http:\/\/www.google.com\/page1/1.html","http:\/\/www.google.com\/page2/2.html","http:\/\/www.google.com\/page3/3.html","http:\/\/www.google.com\/page4/4.html","http:\/\/www.google.com\/page5/5.html","http:\/\/www.google.com\/page6/6.html","http:\/\/www.google.com\/page7/7.html","http:\/\/www.google.com\/page8/8.html","http:\/\/www.google.com\/page9/9.html","http:\/\/www.google.com\/page10/10.html"]');

        $this->assertEquals($stringSequencer->sequence(), $expectedResult);
    }

    /** @test */
    public function it_parses_string_with_start_step_end_format_and_back_reference()
    {
        $stringSequencer = new StringSequencer("http://www.google.com/page[:1:1:10:%03d:]/[\\1].html");

        $expectedResult = $this->arrayFromJson('["http:\/\/www.google.com\/page001/001.html","http:\/\/www.google.com\/page002/002.html","http:\/\/www.google.com\/page003/003.html","http:\/\/www.google.com\/page004/004.html","http:\/\/www.google.com\/page005/005.html","http:\/\/www.google.com\/page006/006.html","http:\/\/www.google.com\/page007/007.html","http:\/\/www.google.com\/page008/008.html","http:\/\/www.google.com\/page009/009.html","http:\/\/www.google.com\/page010/010.html"]');

        $this->assertEquals($stringSequencer->sequence(), $expectedResult);
    }

    /** @test */
    public function it_parses_string_with_start_step_end_and_back_reference_static()
    {
        $sequence = StringSequencer::from("http://www.google.com/page[:1:1:10:]/[\\1].html");

        $expectedResult = $this->arrayFromJson('["http:\/\/www.google.com\/page1/1.html","http:\/\/www.google.com\/page2/2.html","http:\/\/www.google.com\/page3/3.html","http:\/\/www.google.com\/page4/4.html","http:\/\/www.google.com\/page5/5.html","http:\/\/www.google.com\/page6/6.html","http:\/\/www.google.com\/page7/7.html","http:\/\/www.google.com\/page8/8.html","http:\/\/www.google.com\/page9/9.html","http:\/\/www.google.com\/page10/10.html"]');

        $this->assertEquals($sequence, $expectedResult);
    }

    /** @test */
    public function it_parses_string_with_start_step_end_format_and_back_reference_static()
    {
        $sequence = StringSequencer::from("http://www.google.com/page[:1:1:10:%03d:]/[\\1].html");

        $expectedResult = $this->arrayFromJson('["http:\/\/www.google.com\/page001/001.html","http:\/\/www.google.com\/page002/002.html","http:\/\/www.google.com\/page003/003.html","http:\/\/www.google.com\/page004/004.html","http:\/\/www.google.com\/page005/005.html","http:\/\/www.google.com\/page006/006.html","http:\/\/www.google.com\/page007/007.html","http:\/\/www.google.com\/page008/008.html","http:\/\/www.google.com\/page009/009.html","http:\/\/www.google.com\/page010/010.html"]');

        $this->assertEquals($sequence, $expectedResult);
    }

    /** @test */
    public function it_parses_string_with_multiple_blocks_and_back_reference_static()
    {
        $sequence = StringSequencer::multi("http://www.google.com/page[:1:1:5:]-[:50:2:60:]/[\\1]/[\\2].html");

        $expectedResult = $this->arrayFromJson('["http:\/\/www.google.com\/page1-50\/1\/50.html","http:\/\/www.google.com\/page1-52\/1\/52.html","http:\/\/www.google.com\/page1-54\/1\/54.html","http:\/\/www.google.com\/page1-56\/1\/56.html","http:\/\/www.google.com\/page1-58\/1\/58.html","http:\/\/www.google.com\/page1-60\/1\/60.html","http:\/\/www.google.com\/page2-50\/2\/50.html","http:\/\/www.google.com\/page2-52\/2\/52.html","http:\/\/www.google.com\/page2-54\/2\/54.html","http:\/\/www.google.com\/page2-56\/2\/56.html","http:\/\/www.google.com\/page2-58\/2\/58.html","http:\/\/www.google.com\/page2-60\/2\/60.html","http:\/\/www.google.com\/page3-50\/3\/50.html","http:\/\/www.google.com\/page3-52\/3\/52.html","http:\/\/www.google.com\/page3-54\/3\/54.html","http:\/\/www.google.com\/page3-56\/3\/56.html","http:\/\/www.google.com\/page3-58\/3\/58.html","http:\/\/www.google.com\/page3-60\/3\/60.html","http:\/\/www.google.com\/page4-50\/4\/50.html","http:\/\/www.google.com\/page4-52\/4\/52.html","http:\/\/www.google.com\/page4-54\/4\/54.html","http:\/\/www.google.com\/page4-56\/4\/56.html","http:\/\/www.google.com\/page4-58\/4\/58.html","http:\/\/www.google.com\/page4-60\/4\/60.html","http:\/\/www.google.com\/page5-50\/5\/50.html","http:\/\/www.google.com\/page5-52\/5\/52.html","http:\/\/www.google.com\/page5-54\/5\/54.html","http:\/\/www.google.com\/page5-56\/5\/56.html","http:\/\/www.google.com\/page5-58\/5\/58.html","http:\/\/www.google.com\/page5-60\/5\/60.html"]');

        $this->assertEquals($sequence, $expectedResult);
    }

}
