<?php namespace Golonka\BBCode;

class BBCodeParser {

    private $availableParsers = array(
        'bold',
        'italic',
        'underLine',
        'lineThrough',
        'fontSize',
        'fontColor',
        'center',
        'quote',
        'namedQuote',
        'link',
        'namedLink',
        'image',
        'orderedList',
        'unorderedList',
        'listItem',
        'code',
        'youtube',
    );

    private $parsers;

    public function __construct(array $parsers = null)
    {
        $this->parsers = ($parsers === null) ? $this->availableParsers : $parsers;
    }

    /**
     * Parses the BBCode string
     * @param  string $source String containing the BBCode
     * @return string Parsed string
     */
    public function parse($source)
    {
        foreach ($this->parsers as $parser) {
            $parser = 'parse'.ucfirst($parser);
            $source = call_user_func(array($this, $parser), $source);
        }
        return $source;
    }

    /**
     * Parse bold tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseBold($source)
    {
        $pattern = '/\[b\](.*)\[\/b\]/';
        $replace = '<strong>$1</strong>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse italic tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseItalic($source)
    {
        $pattern = '/\[i\](.*)\[\/i\]/';
        $replace = '<em>$1</em>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse under line tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseUnderLine($source)
    {
        $pattern = '/\[u\](.*)\[\/u\]/';
        $replace = '<u>$1</u>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse line through tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseLineThrough($source)
    {
        $pattern = '/\[s\](.*)\[\/s\]/';
        $replace = '<strike>$1</strike>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse font size tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseFontSize($source)
    {
        $pattern = '/\[size\=([1-7])\](.*)\[\/size\]/';
        $replace = '<font size="$1">$2</font>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse font color tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseFontColor($source)
    {
        $pattern = '/\[color\=(#[A-f0-9]{6}|#[A-f0-9]{3})\](.*)\[\/color\]/';
        $replace = '<font color="$1">$2</font>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse center tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseCenter($source)
    {
        $pattern = '/\[center\](.*)\[\/center\]/';
        $replace = '<div style="text-align:center;">$1</div>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse quote tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseQuote($source)
    {
        $pattern = '/\[quote\](.*)\[\/quote\]/';
        $replace = '<blockquote>$1</blockquote>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse named quote tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseNamedQuote($source)
    {
        $pattern = '/\[quote\=(.*)\](.*)\[\/quote\]/';
        $replace = '<blockquote><small>$1</small>$2</blockquote>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse link tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseLink($source)
    {
        $pattern = '/\[url\](.*)\[\/url\]/';
        $replace = '<a href="$1">$1</a>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse named link tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseNamedLink($source)
    {
        $pattern = '/\[url\=(.*)\](.*)\[\/url\]/';
        $replace = '<a href="$1">$2</a>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse image tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseImage($source)
    {
        $pattern = '/\[img\](.*)\[\/img\]/';
        $replace = '<img src="$1">';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse ordered list tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseOrderedList($source)
    {
        $pattern = '/\[ol\](.*)\[\/ol\]/s';
        $replace = '<ol>$1</ol>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse unordered list tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseUnorderedList($source)
    {
        $pattern = '/\[ul\](.*)\[\/ul\]/s';
        $replace = '<ul>$1</ul>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse list item tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseListItem($source)
    {
        $pattern = '/\[\*\](.*)/';
        $replace = '<li>$1</li>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse code tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseCode($source)
    {
        $pattern = '/\[code\](.*)\[\/code\]/';
        $replace = '<code>$1</code>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Parse youtube tags
     * @param  string $source String to parse
     * @return string Parsed string
     */
    public function parseYoutube($source)
    {
        $pattern = '/\[youtube\](.*)\[\/youtube\]/';
        $replace = '<iframe width="560" height="315" src="//www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>';
        return preg_replace($pattern, $replace, $source);
    }

    /**
     * Limits the parsers to only those you specify
     * @param  mixed $only parsers
     * @return object BBCodeParser object
     */
    public function only($only = null)
    {
        $only = (is_array($only)) ? $only : func_get_args();
        $this->parsers = $this->arrayOnly($this->availableParsers, $only);
        return $this;
    }

    /**
     * Removes the parsers you want to exclude
     * @param  mixed $except parsers
     * @return object BBCodeParser object
     */
    public function except($except = null)
    {
        $except = (is_array($except)) ? $except : func_get_args();
        $this->parsers = $this->arrayExcept($this->availableParsers, $except);
        return $this;
    }

    /**
     * List of all available parsers
     * @return array array of available parsers
     */
    public function getAvailableParsers()
    {
        return $this->availableParsers;
    }

    /**
     * List of chosen parsers
     * @return array array of parsers
     */
    public function getParsers()
    {
        return $this->parsers;
    }

    /**
     * Removes all parsers that you don´t want
     * @param  array $allParsers Available parsers
     * @param  array $only chosen parsers
     * @return array parsers
     */
    private function arrayOnly($allParsers, $only)
    {
        return array_flip(
                array_intersect_key(
                    array_flip($allParsers), 
                    array_flip($only)
                )
        );
    }

    /**
     * Removes the parsers that you don´t want
     * @param  array $allParsers Available parsers
     * @param  array $except parsers to exclude
     * @return array parsers
     */
    private function arrayExcept($allParsers, $except)
    {
        return array_flip(
                array_diff_key(
                    array_flip($allParsers),
                    array_flip($except)
                )
        );
    }

}