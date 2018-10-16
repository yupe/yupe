<?php
/**
 * EFeedItemAbstract Class file
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
 * EFeedItemAbstract is the base class for all Feed Items Adapters
 *
 *
 * @author Antonio Ramirez Cobos <ramirez.cobos@gmail.com>
 * @package rss
 */
abstract class EFeedItemAbstract extends CComponent
{
    /**
     *
     * All element tags of this item collection
     * @var CTypedMap('EFeedTag')
     */
    protected $tags;
    /**
     *
     * CDATAEncoded items for all different adapters
     * @var array
     */
    protected $CDATAEncoded = ['description', 'content:encoded', 'summary'];

    /**
     *
     * Class constructor
     */
    public function __construct()
    {
        $this->tags = new CTypedMap('EFeedTag');
    }

    /**
     *
     * Adds a tag to collection
     * @param string $tag name of the element
     * @param string $content of the element
     * @param array $attributes of the tag
     */
    public function addTag($tag, $content, $attributes = [])
    {
        $this->tags->add($tag, new EFeedTag($tag, $content, (!is_array($attributes) ? [] : $attributes)));
    }

    /**
     *
     * Returns specific tag by name
     * @param string $name of the tag
     * @return EFeedTag $tag
     */
    public function getTag($name)
    {
        return $this->tags->itemAt($name);
    }

    /**
     *
     * Property title setter (thanks to CComponent)
     * <pre>
     *    $feed->title = 'mytitle';
     * </pre>
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->addTag('title', $title);
    }

    /**
     *
     * @return string title tag
     */
    public function getTitle()
    {
        return $this->tags->itemAt('title');
    }

    /**
     *
     * Property description setter
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->addTag('description', $description);
    }

    /**
     *
     * @return string description tag
     */
    public function getDescription()
    {
        return $this->tags->itemAt('description');
    }

    /**
     *
     * Property link setter
     * @param string URI $link
     */
    public function setLink($link)
    {
        $validator = new CUrlValidator();
        $validator->pattern = '/(((f|ht){1}tp:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i';

        if (!$validator->validateValue($link)) {
            throw new CException(Yii::t('EFeed', $link . ' does not seem to be a valid URL'));
        }
        $this->addTag('link', $link);
    }

    /**
     *
     * @return link tag
     */
    public function getLink()
    {
        return $this->tags->itemAt('link');
    }

    /**
     *
     * Abstract property setter Ddte
     * @param time () integer|string $date
     */
    abstract public function setDate($date);

    /**
     *
     * Creates a single node as xml format
     * @return   string  formatted xml tag
     */
    abstract public function getNode();

}
