<?php
/**
 * EFeedItemAtom Class file
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
 * EFeedItemAtom is an element of an ATOM Feed
 *
 * @author        Antonio Ramirez <ramirez.cobos@gmail.com>
 * @package    rss
 * @uses        CUrlValidator
 * @throws        CException
 */
class EFeedItemAtom extends EFeedItemAbstract
{
    /**
     * (non-PHPdoc)
     * @see EFeedItemAbstract::setDescription()
     */
    public function setDescription($description)
    {
        $this->addTag('summary', $description);
    }

    /**
     * (non-PHPdoc)
     * @see EFeedItemAbstract::setDate()
     */
    public function setDate($date)
    {
        if (!is_numeric($date)) {
            $date = strtotime($date);
        }
        $date = date(DATE_ATOM, $date);

        $this->addTag('updated', $date);
    }

    /**
     *
     * Property getter date
     */
    public function getDate()
    {
        return $this->tags->itemAt('updated');
    }

    /**
     * (non-PHPdoc)
     * @see EFeedItemAbstract::setLink()
     */
    public function setLink($link)
    {
        $validator = new CUrlValidator();
        if (!$validator->validateValue($link)) {
            throw new CException(Yii::t('EFeed', $link . ' does not seem to be a valid URL'));
        }

        $this->addTag('link', '', ['href' => $link]);
        $this->addTag('id', EFeed::uuid($link, 'urn:uuid:'));
    }

    /**
     * (non-PHPdoc)
     * @see EFeedItemAbstract::getNode()
     */
    public function getNode()
    {
        $node = CHtml::openTag('entry') . PHP_EOL;

        foreach ($this->tags as $tag) {
            $node .= $this->getElement($tag);
        }

        $node .= CHtml::closeTag('entry') . PHP_EOL;

        return $node;
    }

    /**
     *
     * @return a well formatted XML element
     * @param EFeedTag $tag
     */
    private function getElement(EFeedTag $tag)
    {
        $element = '';

        if (in_array($tag->name, $this->CDATAEncoded)) {
            $tag->attributes['type'] = "html";
            $element .= CHtml::openTag($tag->name, $tag->attributes);
            $element .= '<![CDATA["' . PHP_EOL;

        } else {
            $element .= CHtml::openTag($tag->name, $tag->attributes);
        }

        if (is_array($tag->content)) {
            foreach ($tag->content as $tag => $content) {
                $tmpTag = new EFeedTag($tag, $content);

                $element .= $this->getElement($tmpTag);
            }
        } else {
            $element .= (in_array($tag->name, $this->CDATAEncoded)) ? $tag->content : CHtml::encode($tag->content);
        }

        $element .= (in_array($tag->name, $this->CDATAEncoded)) ? "]]>" : "";

        $element .= CHtml::closeTag($tag->name) . PHP_EOL;

        return $element;
    }
}
