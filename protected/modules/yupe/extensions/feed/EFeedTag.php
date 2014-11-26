<?php
/**
 *
 * @author Antonio Ramirez Cobos <ramirez.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
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
 * EFeedTag is the class for the Feed Items
 *
 *
 * @author Antonio Ramirez Cobos <ramirez.cobos@gmail.com>
 * @version $Id: EFeedTag.php 1 2010-12-31 Antonio Ramirez Cobos $
 * @package rss
 */
class EFeedTag
{
    /**
     * Tag name
     * @var string name
     */
    public $name;
    /**
     *
     * Tag content
     * @var string content
     */
    public $content;
    /**
     *
     * Tag attributes array
     * @var array attributes
     */
    public $attributes = [];

    /**
     *
     * EFeedTag constructor
     * @param string $name
     * @param string $content
     * @param array $attributes
     */
    public function __construct($name, $content, $attributes = [])
    {
        $this->name = $name;
        $this->content = $content;
        $this->attributes = is_array($attributes) ? $attributes : [];
    }
}
