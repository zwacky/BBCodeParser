<?php

use \Golonka\BBCode\BBCodeParser;

class BBCodeParserTest extends PHPUnit_Framework_TestCase {

    public function testBBCodeParserCanBeCreated()
    {
        $b = new BBCodeParser;
        $this->assertNotEmpty($b);
    }

    public function testBoldCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = 'foo[b]bar[/b]baz';
        $r = $b->parseBold($s);
        $this->assertEquals('foo<strong>bar</strong>baz', $r);
    }

    public function testItalicCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = 'foo[i]bar[/i]baz';
        $r = $b->parseItalic($s);
        $this->assertEquals('foo<em>bar</em>baz', $r);
    }

    public function testLineThroughCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = 'foo[s]bar[/s]baz';
        $r = $b->parseLineThrough($s);
        $this->assertEquals('foo<strike>bar</strike>baz', $r);
    }

    public function testFontSizeCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = 'foo[size=6]bar[/size]baz';
        $r = $b->parseFontSize($s);
        $this->assertEquals('foo<font size="6">bar</font>baz', $r);
    }

    public function testFontColorWithSixCharactersCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = 'foo[color=#ff0000]bar[/color]baz';
        $r = $b->parseFontColor($s);
        $this->assertEquals('foo<font color="#ff0000">bar</font>baz', $r);
    }

    public function testFontColorWithThreeCharactersCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = 'foo[color=#eee]bar[/color]baz';
        $r = $b->parseFontColor($s);
        $this->assertEquals('foo<font color="#eee">bar</font>baz', $r);
    }

    public function testCenterCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = '[center]foobar[/center]';
        $r = $b->parseCenter($s);
        $this->assertEquals('<div style="text-align:center;">foobar</div>', $r);
    }

    public function testQuoteCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = '[quote]foobar[/quote]';
        $r = $b->parseQuote($s);
        $this->assertEquals('<blockquote>foobar</blockquote>', $r);
    }

    public function testNamedQuoteCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = '[quote=golonka]foobar[/quote]';
        $r = $b->parseNamedQuote($s);
        $this->assertEquals('<blockquote><small>golonka</small>foobar</blockquote>', $r);
    }

    public function testLinkCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = '[url]http://www.aftonbladet.se[/url]';
        $r = $b->parseLink($s);
        $this->assertEquals('<a href="http://www.aftonbladet.se">http://www.aftonbladet.se</a>', $r);
    }

    public function testNamedLinkCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = '[url=http://www.example.com]aftonbladet[/url]';
        $r = $b->parseNamedLink($s);
        $this->assertEquals('<a href="http://www.example.com">aftonbladet</a>', $r);
    }

    public function testImageCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = '[img]http://example.com/images/logo.png[/img]';
        $r = $b->parseImage($s);
        $this->assertEquals('<img src="http://example.com/images/logo.png">', $r);
    }

    public function testOrderedListCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = '[ol][/ol]';
        $r = $b->parseOrderedList($s);
        $this->assertEquals('<ol></ol>', $r);
    }

    public function testUnorderedListCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = '[ul][/ul]';
        $r = $b->parseUnorderedList($s);
        $this->assertEquals('<ul></ul>', $r);
    }

    public function testListItemCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = '[*]Item 1';
        $r = $b->parseListItem($s);
        $this->assertEquals('<li>Item 1</li>', $r);
    }

    public function testCodeCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = '[code]<?php echo \'Hello World\'; ?>[/code]';
        $r = $b->parseCode($s);
        $this->assertEquals('<code><?php echo \'Hello World\'; ?></code>', $r);
    }

    public function testYoutubeCanBeParsed()
    {
        $b = new BBCodeParser;
        $s = '[youtube]Nizq4RnsJJo[/youtube]';
        $r = $b->parseYoutube($s);
        $this->assertEquals('<iframe width="560" height="315" src="//www.youtube.com/embed/Nizq4RnsJJo" frameborder="0" allowfullscreen></iframe>', $r);
    }

    public function testCompleteBBCodeParser()
    {
        $b = new BBCodeParser;
        $s = '
            [b]bold[/b][i]italic[/i][u]underline[/u][s]line through[/s][size=6]size[/size]
            [color=#eee]color[/color][center]centered text[/center][quote]quote[/quote]
            [quote=golonka]quote[/quote][url]http://www.example.com[/url]
            [url=http://www.example.com]example.com[/url][img]http://example.com/logo.png[/img]
            [ol]
                [*]Item 1
                [*]Item 2
                [*]Item 3
            [/ol]
            [code]<?php echo \'Hello World\'; ?>[/code]
            [youtube]Nizq4RnsJJo[/youtube]
            [ul]
                [*]Item 1
                [*]Item 2
                [*]Item 3
            [/ul]
        ';
        $r = $b->parse($s);
        $this->assertEquals('
            <strong>bold</strong><em>italic</em><u>underline</u><strike>line through</strike><font size="6">size</font>
            <font color="#eee">color</font><div style="text-align:center;">centered text</div><blockquote>quote</blockquote>
            <blockquote><small>golonka</small>quote</blockquote><a href="http://www.example.com">http://www.example.com</a>
            <a href="http://www.example.com">example.com</a><img src="http://example.com/logo.png">
            <ol>
                <li>Item 1</li>
                <li>Item 2</li>
                <li>Item 3</li>
            </ol>
            <code><?php echo \'Hello World\'; ?></code>
            <iframe width="560" height="315" src="//www.youtube.com/embed/Nizq4RnsJJo" frameborder="0" allowfullscreen></iframe>
            <ul>
                <li>Item 1</li>
                <li>Item 2</li>
                <li>Item 3</li>
            </ul>
        ', $r);
    }

    public function testOnlyFunctionality()
    {
        $b = new BBCodeParser;

        $onlyParsers = array_values($b->only('image', 'link')->getParsers());

        $this->assertEquals($onlyParsers, array('link', 'image'));
    }

    public function testExceptFunctionality()
    {
        $b = new BBCodeParser;

        $exceptParsers = array_values($b->except('image', 'link', 'bold', 'fontSize')->getParsers());

        $this->assertEquals(
            $exceptParsers,
            array(
                'italic',
                'underLine',
                'lineThrough',
                'fontColor',
                'center',
                'quote',
                'namedQuote',                   
                'namedLink',
                'orderedList',
                'unorderedList',
                'listItem',
                'code',
                'youtube',
            )
        );
    }

}
