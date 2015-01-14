<?php
/**
 * EFeed Class file
 * @author Antonio Ramirez
 * @link http://www.ramirezcobos.com
 *
 *
 * THIS SOFTWARE IS PROVIDED BY THE CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * EFeed is the RSS writer
 *
 * @author        Antonio Ramirez <ramirez.cobos@gmail.com>
 * @package    rss
 * @uses        CComponent, CUrlValidator
 * @throws        CException
 */
class EFeed extends CComponent
{
    /**
     *
     * supported Feed formats
     *
     * @var string RSS1
     * @var string RSS2
     * @var string ATOM
     */
    const RSS1 = 'RSS1';
    const RSS2 = 'RSS2';
    const ATOM = 'Atom';
    /**
     *
     * Holds all information and elements
     * to generate the feed
     * @var CMap $feedElements
     */
    private $feedElements;
    /**
     *
     * Holds stylesheet associated to the feed
     * http://www.w3.org/TR/xml-stylesheet/#dt-xml-stylesheet
     */
    private $stylesheets = [];
    /**
     *
     * Type of Feed Format
     * @var string $type
     */
    private $type;

    /**
     * Constructor
     *
     * @param constant the type constant (RSS1/RSS2/ATOM).
     */
    public function __construct($type = self::RSS2)
    {
        if ($type != self::RSS1 && $type != self::RSS2 && $type != self::ATOM) {
            throw new CException(Yii::t('EFeed', 'Feed version not supported'));
        }

        $this->type = $type;

        // Initiate Feed holder
        $this->feedElements = new CMap();

        // Setting default value for essential channel elements
        $this->addChannelTag('title', $this->type . ' Feed');
        $this->addChannelTag('link', 'http://www.ramirezcobos.com/');

        // Tag elements that we need to CDATA encode
        $this->feedElements->add('CDATAEncoded', ['description', 'content:encoded', 'summary']);

    }

    /**
     *
     * Adds stylesheet support
     * @param array $htmlOptions
     */
    public function addStylesheetTag($htmlOptions)
    {
        if (!is_array($htmlOptions)) {
            throw new CException(Yii::t('EFeed', __FUNCTION__ . ' parameter must be an array.'));
        }

        $this->stylesheets[] = '<?xml-stylesheet ' . CHtml::renderAttributes($htmlOptions) . ' ?>';
    }

    /**
     *
     * Adds a channel element
     * @param string $tag name of the element
     * @param string $content of the element
     */
    public function addChannelTag($tag, $content)
    {
        if (null === $this->feedElements->itemAt('channels')) {
            $this->feedElements->add('channels', new CMap());
        }

        $this->feedElements->itemAt('channels')->add($tag, $content);
    }

    /**
     *
     * Adds an array of channel elements
     * They should be on the format:
     * <pre>
     *    array('tagname'=>'tagcontent')
     * </pre>
     * @param unknown_type $tags
     * @throws CException
     */
    public function addChannelTagsArray($tags)
    {
        if (!is_array($tags)) {
            throw new CException(Yii::t('EFeed', __FUNCTION__ . ' parameter must be an array.'));
        }

        foreach ($tags as $tag => $content) {
            $this->addChannelTag($tag, $content);
        }
    }

    /**
     * RSS1, RSS2 or ATOM
     * @return EFeedItemAbstract Item
     */
    public function createNewItem()
    {
        // create EFeedItem based on selected version type
        $class = "EFeedItem" . $this->type;

        return new $class();
    }

    /**
     * Property setter the 'title' channel element
     *
     * @param    string  value of 'title' channel tag
     */
    public function setTitle($title)
    {
        $this->addChannelTag('title', $title);
    }

    /**
     *
     * Property getter 'title'
     *
     * @return value of title channel tag | null
     */
    public function getTitle()
    {
        if (null !== $this->feedElements->itemAt('channels')) {
            return $this->feedElements->itemAt('channels')->itemAt('title');
        }

        return null;
    }

    /**
     * Property setter 'description' channel element
     *
     * @param    string  value of 'description' channel tag
     */
    public function setDescription($description)
    {
        $this->addChannelTag('description', $description);
    }

    /**
     *
     * Property getter 'description'
     *
     * @return value of description channel tag | null
     */
    public function getDescription()
    {
        if (null !== $this->feedElements->itemAt('channels')) {
            return $this->feedElements->itemAt('channels')->itemAt('description');
        }

        return null;
    }

    /**
     * Property setter 'link' channel element
     *
     * @param    string  value of 'link' channel tag
     * @throws   CException
     */
    public function setLink($link)
    {
        $validator = new CUrlValidator();
        if (!$validator->validateValue($link)) {
            throw new CException(Yii::t('EFeed', $link . ' does not seem to be a valid URL'));
        }

        $this->addChannelTag('link', $link);
    }

    /**
     *
     * Property getter 'link'
     *
     * @return value of link channel tag | null
     */
    public function getLink()
    {
        if (null !== $this->feedElements->itemAt('channels')) {
            return $this->feedElements->itemAt('channels')->itemAt('link');
        }

        return null;
    }

    /**
     * Set the 'image' channel element
     *
     * Cannot be used as property setter
     *
     * @param  string  title of image
     * @param  string  link url of the image
     * @param  string  path url of the image
     */
    public function setImage($title, $link, $url)
    {
        $validator = new CUrlValidator();
        if (!$validator->validateValue($link)) {
            throw new CException(Yii::t('EFeed', $link . ' does not seem to be a valid URL'));
        }

        $this->addChannelTag('image', ['title' => $title, 'link' => $link, 'url' => $url]);
    }

    /**
     *
     * Property getter image
     * @return value of the image channel tag | null
     */
    public function getImage()
    {
        if (null !== $this->feedElements->itemAt('channels')) {
            return $this->feedElements->itemAt('channels')->itemAt('image');
        }
        return null;
    }

    /**
     *
     * Property setter the 'about' RSS 1.0 channel element
     *
     * @param  string  value of 'about' channel tag
     */
    public function setRSS1ChannelAbout($url)
    {
        $validator = new CUrlValidator();
        if (!$validator->validateValue($url)) {
            throw new CException(Yii::t('EFeed', $url . ' does not seem to be a valid URL'));
        }

        $this->addChannelTag('ChannelAbout', $url);

    }

    /**
     *
     * Property getter the 'about' RSS 1.0 channel
     * @return value of 'about' channel tag | null
     */
    public function getRSS1ChannelAbout()
    {
        if (null !== $this->feedElements->itemAt('channels')) {
            return $this->feedElements->itemAt('channels')->itemAt('ChannelAbout');
        }
        return null;
    }

    /**
     *
     * Add a FeedItem to the main class
     *
     * @param  object  instance of EFeedItemAbstract class
     */
    public function addItem(EFeedItemAbstract $item)
    {
        if (null === $this->feedElements->itemAt('items')) {
            $this->feedElements->add('items', new CTypedList('EFeedItemAbstract'));
        }

        $this->feedElements->itemAt('items')->add($item);
    }

    /**
     * Generates an UUID
     *
     * @author     Anis uddin Ahmad <admin@ajaxray.com>
     * @param      string  an optional prefix
     * @return     string  the formated uuid
     */
    public static function uuid($key = null, $prefix = '')
    {
        $key = ($key == null) ? uniqid(rand()) : $key;
        $chars = md5($key);
        $uuid = substr($chars, 0, 8) . '-';
        $uuid .= substr($chars, 8, 4) . '-';
        $uuid .= substr($chars, 12, 4) . '-';
        $uuid .= substr($chars, 16, 4) . '-';
        $uuid .= substr($chars, 20, 12);

        return $prefix . $uuid;
    }

    /**
     *
     * Generates the Feed
     */
    public function generateFeed()
    {
        header("Content-type: text/xml");
        $this->renderHead();
        $this->renderChannels();
        $this->renderItems();
        $this->renderBottom();
    }

    /**
     *
     * Prints the xml and rss namespace
     *
     */
    private function renderHead()
    {
        $head = '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL;
        if (!empty($this->stylesheets)) {
            $head .= implode(PHP_EOL, $this->stylesheets);
        }

        if ($this->type == self::RSS2) {
            $head .= CHtml::openTag(
                    'rss',
                    [
                        "version"       => "2.0",
                        "xmlns:content" => "http://purl.org/rss/1.0/modules/content/",
                        "xmlns:wfw"     => "http://wellformedweb.org/CommentAPI/"
                    ]
                ) . PHP_EOL;
        } elseif ($this->type == self::RSS1) {
            $head .= CHtml::openTag(
                    'rdf:RDF',
                    [
                        "xmlns:rdf" => "http://www.w3.org/1999/02/22-rdf-syntax-ns#",
                        "xmlns"     => "http://purl.org/rss/1.0/",
                        "xmlns:dc"  => "http://purl.org/dc/elements/1.1/"
                    ]
                ) . PHP_EOL;
        } elseif ($this->type == self::ATOM) {
            $head .= CHtml::openTag('feed', ["xmlns" => "http://www.w3.org/2005/Atom"]) . PHP_EOL;
        }
        echo $head;
    }

    /**
     *
     * Prints the xml closing tags
     *
     */
    private function renderBottom()
    {
        if ($this->type == self::RSS2) {
            echo CHtml::closeTag('channel');
            echo CHtml::closeTag('rss');
        } elseif ($this->type == self::RSS1) {
            echo CHtml::closeTag('rdf:RDF');
        } elseif ($this->type == self::ATOM) {
            echo CHtml::closeTag('feed');
        }

    }

    /**
     *
     * Prints the channels of the xml document
     * @throws CException
     */
    private function renderChannels()
    {
        switch ($this->type) {
            case self::RSS2 :
                echo '<channel>' . PHP_EOL;
                break;
            case self::RSS1:
                if (null !== $this->RSS1ChannelAbout) {
                    echo CHtml::tag('channel', ['rdf:about' => $this->RSS1ChannelAbout]);
                } else {
                    echo CHtml::tag('channel', ['rdf:about' => $this->link]);
                }
                break;
        }

        // Printing channel items
        foreach ($this->feedElements->itemAt('channels') as $key => $value) {
            if ($this->type == self::ATOM && $key == 'link') {
                // ATOM prints link element as href attribute
                echo $this->makeNode($key, '', ['href' => $value]);
                // And add the id for ATOM
                echo $this->makeNode('id', $this->uuid($value, 'urn:uuid:'));
            } else {
                echo $this->makeNode($key, $value);
            }

        }

        // RSS 1.0 have special tag <rdf:Seq> with channel
        if ($this->type == self::RSS1) {
            if (null === $this->feedElements->itemAt('items')) {
                throw new CException(Yii::t('EFeed', 'No items have been set'));
            }

            echo "<items>" . PHP_EOL . "<rdf:Seq>" . PHP_EOL;

            foreach ($this->feedElements->itemAt('items') as $item) {
                $tag = $item->link;

                if (null === $tag) {
                    throw new CException(Yii::t(
                        'EFeed',
                        'For RSS 1.0 specifications link element should be add per item'
                    ));
                }

                echo CHtml::tag('rdf:li', ['resource' => $tag->content], true) . PHP_EOL;
            }
            echo "</rdf:Seq>" . PHP_EOL . "</items>" . PHP_EOL;
        }
    }

    /**
     *
     * Prints feed items
     * @throws CException
     */
    private function renderItems()
    {
        if (null === $this->feedElements->itemAt('items')) {
            throw new CException(Yii::t('EFeed', 'No feed items configured'));
        }

        foreach ($this->feedElements->itemAt('items') as $item) {
            echo $item->getNode();
        }
    }

    /**
     *
     * Creates a single node as xml format
     *
     * @access   private
     * @param    string  name of the tag
     * @param    mixed   tag value as string or array of nested tags in 'tagName' => 'tagValue' format
     * @param    array   Attributes(if any) in 'attrName' => 'attrValue' format
     * @return   string  formatted xml tag
     */
    private function makeNode($tagName, $tagContent, $attributes = [])
    {
        $node = '';

        if (is_array($tagContent) && $this->type == self::RSS1) {
            $attributes['rdf:parseType'] = "Resource";
        }

        if (in_array($tagName, $this->feedElements->itemAt('CDATAEncoded'))) {
            if ($this->type == self::ATOM) {
                $attributes['type'] = "html";
            }
            $node .= CHtml::openTag($tagName, $attributes) . '<![CDATA[';
        } else {
            $node .= CHtml::openTag($tagName, $attributes);
        }

        if (is_array($tagContent)) {
            foreach ($tagContent as $tag => $content) {
                $node .= $this->makeNode($tag, $content);
            }
        } else {
            $node .= in_array($tagName, $this->feedElements->itemAt('CDATAEncoded')) ? $tagContent : CHtml::encode(
                $tagContent
            );
        }

        $node .= in_array($tagName, $this->feedElements->itemAt('CDATAEncoded')) ? PHP_EOL . ']]>' : '';

        $node .= CHtml::closeTag($tagName);

        return $node . PHP_EOL;

    }
}
